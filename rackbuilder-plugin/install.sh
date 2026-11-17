#!/usr/bin/env bash
#
# RackBuilder for LibreNMS — installer / uninstaller
#
#   Install or repair:  sudo bash /opt/librenms/app/Plugins/RackBuilder/install.sh
#   Uninstall:          sudo bash /opt/librenms/app/Plugins/RackBuilder/install.sh --uninstall
#
# Safe to run again at any time. It never edits LibreNMS's own files: the API routes and the
# database migration ship as a small Composer package that `lnms plugin:add` installs, and
# LibreNMS's daily.sh re-installs it after every update.
#
# Environment overrides: LIBRENMS_DIR (default: detected from this script's location),
#                        LIBRENMS_USER (default: owner of the LibreNMS directory).

set -euo pipefail

PACKAGE="local/librenms-rackbuilder"
PACKAGE_VERSION="1.0.0"
REPO_KEY="rackbuilder"

# ----------------------------------------------------------------------------
# helpers
# ----------------------------------------------------------------------------
if [ -t 1 ]; then
    C_OK=$'\e[32m'; C_WARN=$'\e[33m'; C_ERR=$'\e[31m'; C_DIM=$'\e[2m'; C_OFF=$'\e[0m'
else
    C_OK=''; C_WARN=''; C_ERR=''; C_DIM=''; C_OFF=''
fi
step() { printf '\n%s==>%s %s\n' "$C_OK" "$C_OFF" "$*"; }
info() { printf '    %s\n' "$*"; }
warn() { printf '    %sWARNING:%s %s\n' "$C_WARN" "$C_OFF" "$*"; }
die()  { printf '\n%sERROR:%s %s\n' "$C_ERR" "$C_OFF" "$*" >&2; exit 1; }

usage() {
    sed -n '3,13p' "$0" | sed 's/^# \{0,1\}//'
    exit 0
}

MODE="install"
case "${1:-}" in
    ""|--install)  MODE="install" ;;
    --uninstall)   MODE="uninstall" ;;
    -h|--help)     usage ;;
    *)             die "Unknown option '$1' (use --help)" ;;
esac

[ "$(id -u)" -eq 0 ] || die "Please run as root (e.g. sudo bash $0)"

PLUGIN_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd -P)"
LIBRENMS_DIR="${LIBRENMS_DIR:-$(cd "$PLUGIN_DIR/../../.." && pwd -P)}"

[ -f "$LIBRENMS_DIR/lnms" ] && [ -f "$LIBRENMS_DIR/artisan" ] \
    || die "LibreNMS not found at $LIBRENMS_DIR. Clone this repo into <librenms>/app/Plugins/RackBuilder or set LIBRENMS_DIR."

[ "$PLUGIN_DIR" = "$LIBRENMS_DIR/app/Plugins/RackBuilder" ] \
    || die "The plugin must live at $LIBRENMS_DIR/app/Plugins/RackBuilder (folder name is case-sensitive), but it is at $PLUGIN_DIR."

LIBRENMS_USER="${LIBRENMS_USER:-$(stat -c %U "$LIBRENMS_DIR/lnms")}"
id "$LIBRENMS_USER" >/dev/null 2>&1 || die "User '$LIBRENMS_USER' does not exist (set LIBRENMS_USER)."
USER_HOME="$(getent passwd "$LIBRENMS_USER" | cut -d: -f6)"

# Run a command as the LibreNMS user, with that user's HOME (composer keeps its global config there,
# and daily.sh runs as the same user, so both must see the same config).
as_user() {
    if command -v sudo >/dev/null 2>&1; then
        sudo -u "$LIBRENMS_USER" -H "$@"
    else
        runuser -u "$LIBRENMS_USER" -- env HOME="$USER_HOME" "$@"
    fi
}

composer() { as_user php "$LIBRENMS_DIR/scripts/composer_wrapper.php" --no-interaction "$@"; }

restart_php_fpm() {
    local unit
    unit="$(systemctl list-units --type=service --all --no-legend 'php*fpm*' 2>/dev/null | awk '{print $1}' | grep -m1 fpm || true)"
    if [ -n "$unit" ]; then
        systemctl restart "$unit" && info "Restarted $unit"
    else
        warn "Could not find a PHP-FPM service. Restart your PHP-FPM / web server manually so it loads the new routes."
    fi
}

cd "$LIBRENMS_DIR"

printf '%sRackBuilder %s — LibreNMS at %s (user: %s)%s\n' "$C_DIM" "$MODE" "$LIBRENMS_DIR" "$LIBRENMS_USER" "$C_OFF"

# ----------------------------------------------------------------------------
# uninstall
# ----------------------------------------------------------------------------
if [ "$MODE" = "uninstall" ]; then
    step "Removing the Composer package"
    if [ -f composer.plugins.json ] && grep -q "\"$PACKAGE\"" composer.plugins.json; then
        as_user ./lnms plugin:remove "$PACKAGE"
    else
        info "Not installed — skipping"
    fi

    step "Removing the Composer repository entry"
    composer config --global --unset "repositories.$REPO_KEY" || true

    step "Clearing caches"
    as_user php artisan optimize:clear >/dev/null
    restart_php_fpm

    cat <<EOF

${C_OK}RackBuilder's API has been removed.${C_OFF}

  - Your rack data is still in the database (tables rack_builder_racks, rack_builder_servers,
    rack_builder_nodes). Drop them yourself if you no longer need them.
  - To remove the plugin completely:  rm -rf $PLUGIN_DIR
EOF
    exit 0
fi

# ----------------------------------------------------------------------------
# install
# ----------------------------------------------------------------------------
step "Checking for an older manual install"
if grep -q 'RackBuilder' bootstrap/providers.php 2>/dev/null; then
    if as_user git ls-files --error-unmatch bootstrap/providers.php >/dev/null 2>&1; then
        as_user git checkout -- bootstrap/providers.php
        info "Restored LibreNMS's original bootstrap/providers.php (updates won't conflict any more)"
    else
        sed -i '/RackBuilder/d' bootstrap/providers.php
        info "Removed the RackBuilder line from bootstrap/providers.php"
    fi
else
    info "bootstrap/providers.php is clean"
fi
if [ -d "$PLUGIN_DIR/Providers" ]; then
    rm -rf "$PLUGIN_DIR/Providers"
    info "Removed the old Providers/ folder (replaced by package/)"
fi

step "Fixing file ownership and permissions"
chown -R "$LIBRENMS_USER:$LIBRENMS_USER" "$PLUGIN_DIR"
info "Owner set to $LIBRENMS_USER"
if command -v selinuxenabled >/dev/null 2>&1 && selinuxenabled && command -v restorecon >/dev/null 2>&1; then
    restorecon -RF "$PLUGIN_DIR"
    info "SELinux labels restored"
fi

step "Registering the package location with Composer"
composer config --global "repositories.$REPO_KEY" \
    "{\"type\":\"path\",\"url\":\"$PLUGIN_DIR/package\",\"options\":{\"symlink\":true}}"
info "$PACKAGE -> $PLUGIN_DIR/package"

step "Installing the package with lnms plugin:add"
[ -f composer.plugins.json ] || as_user sh -c 'echo "{}" > composer.plugins.json'
if grep -q "\"$PACKAGE\"" composer.plugins.json && [ -e "vendor/$PACKAGE" ]; then
    info "Already installed"
else
    as_user ./lnms plugin:add "$PACKAGE" "$PACKAGE_VERSION"
fi

step "Creating database tables (if needed)"
as_user php artisan migrate --force

step "Clearing caches"
as_user php artisan optimize:clear >/dev/null
info "Done"
restart_php_fpm

step "Verifying"
ROUTES="$(as_user php -r '
    chdir($argv[1]);
    require "vendor/autoload.php";
    $app = require "bootstrap/app.php";
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    $n = 0;
    foreach (app("router")->getRoutes() as $r) { if (str_starts_with($r->uri(), "plugin/RackBuilder/api/")) $n++; }
    echo $n;
' "$LIBRENMS_DIR" 2>/dev/null || echo 0)"
if [ "${ROUTES:-0}" -gt 0 ]; then
    info "$ROUTES API routes registered"
else
    die "The RackBuilder API routes are not registered. Check $LIBRENMS_DIR/logs/librenms.log for errors."
fi

cat <<EOF

${C_OK}RackBuilder is installed.${C_OFF}

  Open LibreNMS and choose  Overview -> Plugins -> RackBuilder.

  - LibreNMS updates (daily.sh) re-install the package automatically; nothing to redo.
  - Don't move or delete $PLUGIN_DIR/package — Composer installs from it.
  - To update RackBuilder:  cd $PLUGIN_DIR && sudo -u $LIBRENMS_USER git pull && sudo bash install.sh
EOF

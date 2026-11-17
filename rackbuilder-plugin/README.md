# RackBuilder for LibreNMS

Visual rack elevations inside LibreNMS. Lay out your racks, mount servers, link each node to a
LibreNMS device and watch live up/down status right on the rack.

<!-- Add a screenshot here, e.g. ![RackBuilder](docs/screenshot.png) -->

## Features

- **Front and rear views** of 42U / 48U racks. The rear view is mirrored, like looking at the real thing from behind.
- **Telecom racks** with 6U side panels (left and right).
- **Full-width and half-width servers**, mounted front, rear or both. Multi-node chassis supports 1, 2 or 4 nodes.
- **Live status lights** per node: up, recently rebooted, down, disabled and not linked. They refresh every minute.
- **Drag and drop** to move servers, with a preview that shows whether the spot is free.
- **Device search** to link nodes to LibreNMS devices. Node names link straight to the device page.
- **Rack summary**: U used, number of servers and nodes, and a status breakdown.
- **Compact / normal view, zoom and fit to screen**, plus a **print-friendly layout**.
- **Dark and light themes**, following LibreNMS.
- **Permissions**: anyone logged in can view racks, but only admins can change them. The API enforces this.
- **Survives LibreNMS updates.** No LibreNMS files are edited (see [How it works](#how-it-works)).

## Requirements

- LibreNMS **26.10 or newer** (tested on 26.10.2 and 26.11.0), installed from git, which is the standard install
- Root access to the LibreNMS server

## Install

```bash
cd /opt/librenms/app/Plugins
sudo -u librenms git clone https://github.com/<your-user>/RackBuilder.git RackBuilder
sudo bash RackBuilder/install.sh
```

The folder **must** be named `RackBuilder`, because the name is case-sensitive. Then open
**Overview → Plugins → RackBuilder** in LibreNMS. The menu entry is shown to admins.

The installer is safe to run again at any time. It:

1. Cleans up an older manual install, i.e. a `RackBuilderProvider` line in `bootstrap/providers.php`.
2. Fixes file ownership and, on SELinux systems, the file labels.
3. Installs the small `package/` folder with `lnms plugin:add`.
4. Creates the database tables, if they don't exist yet.
5. Clears the caches, restarts PHP-FPM, and checks that the API routes are registered.

If LibreNMS isn't in `/opt/librenms` or runs as a different user, the script detects that from
its own location. You can also set `LIBRENMS_DIR=... LIBRENMS_USER=...`.

## Update RackBuilder

```bash
cd /opt/librenms/app/Plugins/RackBuilder
sudo -u librenms git pull
sudo bash install.sh
```

## LibreNMS updates

There's nothing to do. `daily.sh` re-installs the RackBuilder package after every update, and any
new database changes run with LibreNMS's own migrations.

## Uninstall

```bash
sudo bash /opt/librenms/app/Plugins/RackBuilder/install.sh --uninstall
sudo rm -rf /opt/librenms/app/Plugins/RackBuilder
```

Your rack data stays in the database (`rack_builder_racks`, `rack_builder_servers`,
`rack_builder_nodes`) until you drop those tables yourself.

## How it works

LibreNMS automatically loads a plugin's **menu entry and page** from `app/Plugins/<Name>/`, but not
its API routes or database migrations. Adding the plugin to `bootstrap/providers.php` works, but
that file belongs to LibreNMS. The next update then fails with a git conflict, or silently drops
the line, and RackBuilder's API returns 404.

To avoid that, the routes and migration live in `package/`, a tiny Composer package. The installer
registers it with LibreNMS's official `lnms plugin:add` command. That command records it in
`composer.plugins.json`, which git ignores and which `daily.sh` re-installs after every update.

```
RackBuilder/
├── Menu.php, Page.php          menu entry + page (auto-loaded by LibreNMS)
├── Http/Controllers/           API controller
├── Models/                     Rack, Server, Node
├── resources/views/            page UI (single Blade file: CSS + JS)
├── package/                    Composer package: API routes + DB migration
└── install.sh                  installer / uninstaller
```

> Don't add other `.php` files to the top level of the plugin folder. LibreNMS treats every top-level
> PHP file as a plugin hook.

## Troubleshooting

| Symptom | Fix |
|---|---|
| Page loads but shows nothing, and the browser console shows `404` on `/plugin/RackBuilder/api/...` | Run `sudo bash install.sh` again. It restarts PHP-FPM, which may still be holding old files. |
| `500` errors | `grep -iE 'error\|exception' /opt/librenms/logs/librenms.log \| grep -v device:poll \| tail` |
| `daily.sh` says *"Please commit your changes or stash them"* | An old manual install edited `bootstrap/providers.php`. Run `sudo bash install.sh` to clean it up. |
| Menu entry missing | It's shown to admins only. Also check **Overview → Plugins → Plugin Admin** that RackBuilder is enabled. |

<!-- License: choose one (LibreNMS itself is GPL-3.0) and add a LICENSE file. -->

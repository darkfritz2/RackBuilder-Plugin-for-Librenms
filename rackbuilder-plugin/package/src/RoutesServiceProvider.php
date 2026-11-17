<?php

namespace LocalPlugins\RackBuilder;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Registers the RackBuilder API routes and database migration.
 *
 * This lives in a tiny Composer package (installed with `lnms plugin:add`) instead of
 * bootstrap/providers.php, so LibreNMS updates never overwrite or conflict with it:
 * daily.sh re-installs everything listed in composer.plugins.json after each update,
 * and Laravel auto-discovers the provider from this package's composer.json.
 */
class RoutesServiceProvider extends ServiceProvider
{
    private const CONTROLLER = \App\Plugins\RackBuilder\Http\Controllers\RackBuilderController::class;

    public function boot(): void
    {
        // Database tables: picked up by `lnms migrate`, which daily.sh runs on every update.
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // If the plugin folder is ever removed, do nothing instead of breaking LibreNMS.
        if (! class_exists(self::CONTROLLER) || $this->routesRegistered()) {
            return;
        }

        Route::prefix('plugin/RackBuilder/api')
            ->middleware(['web', 'auth'])
            ->group(function () {
                $ctrl = self::CONTROLLER;

                // Read-only: any logged-in user can view racks and status.
                Route::get('racks',                 [$ctrl, 'listRacks']);
                Route::get('racks/{rack}/servers',  [$ctrl, 'getServers']);
                Route::get('racks/{rack}/status',   [$ctrl, 'getStatus']);

                // Changes: admins only (same gate as the menu entry).
                Route::middleware('can:admin')->group(function () use ($ctrl) {
                    Route::post('racks',              [$ctrl, 'createRack']);
                    Route::put('racks/{rack}',        [$ctrl, 'updateRack']);
                    Route::delete('racks/{rack}',     [$ctrl, 'deleteRack']);

                    Route::post('servers',            [$ctrl, 'createServer']);
                    Route::put('servers/{server}',    [$ctrl, 'updateServer']);
                    Route::delete('servers/{server}', [$ctrl, 'deleteServer']);

                    Route::post('nodes',              [$ctrl, 'createNode']);
                    Route::put('nodes/{node}',        [$ctrl, 'updateNode']);
                    Route::delete('nodes/{node}',     [$ctrl, 'deleteNode']);

                    Route::get('devices/search',      [$ctrl, 'searchDevices']);
                });
            });
    }

    private function routesRegistered(): bool
    {
        foreach (Route::getRoutes() as $route) {
            if ($route->uri() === 'plugin/RackBuilder/api/racks') {
                return true;
            }
        }

        return false;
    }
}

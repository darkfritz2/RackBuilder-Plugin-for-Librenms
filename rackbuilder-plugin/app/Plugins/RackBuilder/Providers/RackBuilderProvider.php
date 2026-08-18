<?php

namespace App\Plugins\RackBuilder\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RackBuilderProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->apiRoutesRegistered()) {
            return;
        }

        Route::prefix('plugin/RackBuilder/api')
            ->middleware(['web', 'auth'])
            ->group(function () {
                $ctrl = '\App\Plugins\RackBuilder\Http\Controllers\RackBuilderController';

                Route::get('racks',                 [$ctrl, 'listRacks']);
                Route::post('racks',                [$ctrl, 'createRack']);
                Route::put('racks/{rack}',          [$ctrl, 'updateRack']);
                Route::delete('racks/{rack}',       [$ctrl, 'deleteRack']);
                Route::get('racks/{rack}/servers',  [$ctrl, 'getServers']);
                Route::get('racks/{rack}/status',   [$ctrl, 'getStatus']);

                Route::post('servers',              [$ctrl, 'createServer']);
                Route::put('servers/{server}',      [$ctrl, 'updateServer']);
                Route::delete('servers/{server}',   [$ctrl, 'deleteServer']);

                Route::post('nodes',                [$ctrl, 'createNode']);
                Route::put('nodes/{node}',          [$ctrl, 'updateNode']);
                Route::delete('nodes/{node}',       [$ctrl, 'deleteNode']);

                Route::get('devices/search',        [$ctrl, 'searchDevices']);
            });
    }

    private function apiRoutesRegistered(): bool
    {
        foreach (Route::getRoutes() as $route) {
            if (($route->uri ?? '') === 'plugin/RackBuilder/api/racks') {
                return true;
            }
        }

        return false;
    }
}
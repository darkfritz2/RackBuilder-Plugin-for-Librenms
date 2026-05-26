<?php

namespace App\Plugins\RackBuilder;

use App\Plugins\Hooks\PageHook;
use Illuminate\Support\Facades\Route;

class Page extends PageHook
{
    public string $view = 'resources.views.page';

    public function __construct()
    {
        if (!app()->routesAreCached()) {
            Route::prefix('plugin/RackBuilder/api')
                ->middleware(['web', 'auth'])
                ->group(function () {
                    $ctrl = '\App\Plugins\RackBuilder\Http\Controllers\RackBuilderController';

                    Route::get('racks',               [$ctrl, 'listRacks']);
                    Route::post('racks',              [$ctrl, 'createRack']);
                    Route::put('racks/{rack}',        [$ctrl, 'updateRack']);
                    Route::delete('racks/{rack}',     [$ctrl, 'deleteRack']);
                    Route::get('racks/{rack}/servers',[$ctrl, 'getServers']);
                    Route::get('racks/{rack}/status', [$ctrl, 'getStatus']);

                    Route::post('servers',            [$ctrl, 'createServer']);
                    Route::put('servers/{server}',    [$ctrl, 'updateServer']);
                    Route::delete('servers/{server}', [$ctrl, 'deleteServer']);

                    Route::post('nodes',              [$ctrl, 'createNode']);
                    Route::put('nodes/{node}',        [$ctrl, 'updateNode']);
                    Route::delete('nodes/{node}',     [$ctrl, 'deleteNode']);

                    Route::get('devices/search',      [$ctrl, 'searchDevices']);
                });
        }
    }
}

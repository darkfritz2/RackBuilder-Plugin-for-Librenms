<?php

namespace App\Plugins\RackBuilder;

use App\Plugins\Hooks\MenuEntryHook;

class Menu extends MenuEntryHook
{
    public string $view = 'resources.views.menu';

    public function authorize(\Illuminate\Contracts\Auth\Authenticatable $user, array $settings = []): bool
    {
        return $user->can('admin');
    }
}

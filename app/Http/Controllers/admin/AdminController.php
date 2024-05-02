<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $activeModuleCount = Module::where('is_active', true)->count();
        $activePermissionCount = Permission::where('is_active', true)->count();
        $activeRolesCount = Role::where('is_active', true)->count();
        $activeUsersCount = User::where('is_active', true)
            ->where('id', '!=', 1)
            ->count();

        return view(
            'content.admin.dashboard.index',
            compact('activeModuleCount', 'activePermissionCount', 'activeRolesCount', 'activeUsersCount')
        );
    }
}

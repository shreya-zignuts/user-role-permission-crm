<?php

namespace App\Http\Controllers\pages;

use App\Models\Role;
use App\Models\User;
use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePage extends Controller
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
      'content.pages.pages-home',
      compact('activeModuleCount', 'activePermissionCount', 'activeRolesCount', 'activeUsersCount')
    );
  }
}

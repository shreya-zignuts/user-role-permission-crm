<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
  public function index(Request $request)
  {
    $search = $request->search;
    $filter = $request->filter;

    $roles = Role::query()
      ->when($search, function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%');
      })
      ->when($filter && $filter !== 'all', function ($query) use ($filter) {
        $query->where('is_active', $filter === 'active');
      })
      ->get();

    if ($request->filled('toggle')) {
      $roleId = $request->role_id;
      $role = Role::where('id', $roleId)->firstOrFail();
      $role->is_active = !$role->is_active;

      if (!$role->is_active) {
        $role->update(['is_active' => false]);
      }

      $role->save();

      return redirect()->route('pages-roles');
    }

    return view('content.roles.index', compact('roles', 'filter'));
  }

  public function create()
  {
    $permissions = Permission::all();
    return view('content.roles.create', compact('permissions'));
  }
  public function store(Request $request)
  {
    dd($request->permissions);
    $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string|max:255',
      'permissions' => 'required|array',
      'permissions.*' => 'integer|exists:permissions,id',
    ]);

    $role = Role::create([
      'name' => $request->name,
      'description' => $request->description,
    ]);

    $role->permissions()->attach($request->permissions);

    return back()->with('success', 'Role created successfully.');
  }
}

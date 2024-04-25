<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
  /**
   * Display a listing of the roles.
   */
  public function index(Request $request)
  {
    $roles = Role::query()
      ->where(function ($query) use ($request) {
        // Search logic

        if ($request->input('search')) {
          $query->where('name', 'like', "%{$request->input('search')}%");
        }

        if ($request->input('filter') && $request->input('filter') !== 'all') {
          $query->where('is_active', $request->input('filter') === 'active' ? '1' : '0');
        }
      })
      ->paginate(5);

    $roles->appends(['search' => $request->input('search'), 'filter' => $request->input('filter')]);
    return view('content.admin.roles.index', compact('roles'));
  }

  /**
   * Show the form for creating a new role.
   */
  public function create()
  {
    $permissions = Permission::where('is_active', 1)->get();

    return view('content.admin.roles.create', compact('permissions'));
  }

  /**
   * Store a newly created role in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'name'          => 'required|string|max:255',
      'description'   => 'nullable|string|max:255',
      'permissions'   => 'required|array',
      'permissions.*' => 'integer|exists:permissions,id',
    ]);

    $role = Role::create([
      'name'        => $request->name,
      'description' => $request->description,
    ]);

    $role->permissions()->attach($request->permissions);

    return redirect()
      ->route('pages-roles')
      ->with('success', 'Role created successfully.');
  }

  /**
   * Toggle the status of the specified role.
   */
  public function toggleRoleStatus(Request $request, $id)
  {
    $role = Role::find($id);

    if (!$role) {
      return redirect()
        ->back()
        ->with('error', 'role not found');
    }

    $role->is_active = !$role->is_active;

    $role->save();

    return response()->json(['success' => 'Role status toggled successfully.']);
  }

  /**
   * Show the form for editing the specified role.
   */
  public function edit($id)
  {
    $role = Role::find($id);

    if (!$role) {
      return redirect()
        ->back()
        ->with('error', 'role not found');
    }
    $permissions = Permission::where('is_active', 1)->get();
    return view('content.admin.roles.edit-role', compact('role', 'permissions'));
  }

  /**
   * Update the specified role in storage.
   */
  public function update(Request $request, $id)
  {
    $data = $request->validate([
      'name'          => 'required|string|max:255',
      'description'   => 'nullable|string|max:255',
      'permissions'   => 'required|array',
      'permissions.*' => 'integer|exists:permissions,id',
    ]);

    $role = Role::find($id);

    if (!$role) {
      return redirect()
        ->back()
        ->with('error', 'role not found');
    }

    $role->update($data);

    $permissions = $request->input('permissions', []);

    $role->permissions()->sync($permissions);

    return redirect()
      ->route('pages-roles')
      ->with('success', 'Role updated successfully.');
  }

  /**
   * Remove the specified role from storage.
   */
  public function delete($id)
  {
    $role = Role::find($id);

    if (!$role) {
      return redirect()
        ->back()
        ->with('error', 'role not found');
    }
    $role->delete();

    return response()->json(['success' => 'Role deleted successfully.']);
  }
}

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
    $search = $request->search;
    $filter = $request->input('filter', 'all');

    // $roles = Role::query()
    //   ->when($search, function ($query) use ($search) {
    //     $query->where('name', 'like', '%' . $search . '%');
    //   })
    //   ->when($filter && $filter !== 'all', function ($query) use ($filter) {
    //     $query->where('is_active', $filter === 'active');
    //   })
    //   ->paginate(5);

    $roles = Role::query()
      ->when($search, function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%');
      })
      ->when($filter && $filter !== 'all', function ($query) use ($filter) {
        $query->where('is_active', $filter === 'active');
      })
      ->paginate(5);

    // Append the search and filter parameters to the pagination links
    $roles->appends(['search' => $search, 'filter' => $filter]);

    return view('content.admin.roles.index', compact('roles', 'filter'));
  }

  /**
   * Show the form for creating a new role.
   */
  public function create()
  {
    $permissions = Permission::all();
    return view('content.admin.roles.create', compact('permissions'));
  }

  /**
   * Store a newly created role in storage.
   */
  public function store(Request $request)
  {
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

    // return redirect()
    //   ->back()
    //   ->with('success', 'User status toggled successfully.');
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
    $permissions = Permission::all();
    return view('content.admin.roles.edit-role', compact('role', 'permissions'));
  }

  /**
   * Update the specified role in storage.
   */
  public function update(Request $request, $id)
  {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string|max:255',
      'permissions' => 'required|array',
      'permissions.*' => 'integer|exists:permissions,id',
    ]);

    $role = Role::find($id);

    if (!$role) {
      return redirect()
        ->back()
        ->with('error', 'role not found');
    }

    $role->update($data);

    $roles = $request->input('roles', []);

    $role->permissions()->sync($roles);

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

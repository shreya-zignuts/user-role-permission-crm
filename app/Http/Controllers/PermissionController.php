<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
  /**
   * Display a listing of the permissions.
   */
  public function index(Request $request)
  {
    $search = $request->search;
    $filter = $request->input('filter', 'all');

    $permissions = Permission::query()
      ->when($search, function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%');
      })
      ->when($filter && $filter !== 'all', function ($query) use ($filter) {
        $query->where('is_active', $filter === 'active');
      })
      ->paginate(5);

    return view('content.permissions.index', compact('permissions', 'filter'));
  }

  /**
   * Show the form for creating a new permission.
   */
  public function create()
  {
    $modules = Module::whereNull('parent_code')
      ->with('submodules')
      ->get();

    return view('content.permissions.create', compact('modules'));
  }

  /**
   * Store a newly created permission in storage.
   */
  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required|string',
      'description' => 'nullable|string',
    ]);

    $permission = Permission::create([$data]);

    $permissions = $request->input('permissions', []);
    $permission->modules()->attach($permissions);

    // $modules = Module::all();

    // foreach ($modules as $module) {
    //   $moduleCode = $module->code;
    //   $permission->modules()->attach($moduleCode, [
    //     'add_access' => $request->has('add_access_' . $moduleCode),
    //     'view_access' => $request->has('view_access_' . $moduleCode),
    //     'edit_access' => $request->has('edit_access_' . $moduleCode),
    //     'delete_access' => $request->has('delete_access_' . $moduleCode),
    //   ]);
    // }

    return redirect()
      ->route('pages-permissions')
      ->with('success', 'Permission created successfully');
  }

  /**
   * Toggle the status of the specified permission.
   */
  public function togglePermissionStatus(Request $request)
  {
    $permissionId = $request->permission_id;

    $permission = Permission::findOrFail($permissionId);

    $permission->is_active = !$permission->is_active;

    $permission->save();

    return redirect()
      ->back()
      ->with('success', 'Permission status toggled successfully.');
  }

  /**
   * Show the form for editing the specified permission.
   */
  public function edit($id)
  {
    $permission = Permission::findOrFail($id);
    $modules = Module::whereNull('parent_code')
      ->with('submodules')
      ->get();

    return view('content.permissions.edit-permission', compact('modules', 'permission'));
  }

  /**
   * Update the specified permission in storage.
   */
  public function update(Request $request, $id)
  {
    $data = $request->validate([
      'name' => 'required|string',
      'description' => 'nullable|string',
    ]);
    // dd($request->all());

    $permission = Permission::findOrFail($id);

    $data = $request->validate([
      'name' => 'required|string',
      'description' => 'nullable|string',
    ]);

    $permission = Permission::findOrFail($id);

    $permission->modules()->attach($permissions);

    return redirect()
      ->route('pages-permissions')
      ->with('success', 'Permission updated successfully');

    return redirect()
      ->back()
      ->with('error', 'Your error message here');
  }

  /**
   * Remove the specified permission from storage.
   */
  public function delete($id)
  {
    $permission = Permission::findOrFail($id);
    $permission->delete();

    return redirect()
      ->route('pages-permissions')
      ->with('success', 'Permission deleted successfully');
  }
}

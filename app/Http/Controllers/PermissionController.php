<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
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

  public function create()
  {
    $modules = Module::whereNull('parent_code')
      ->with('submodules')
      ->get();

    return view('content.permissions.create', compact('modules'));
  }
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string',
      'description' => 'nullable|string',
    ]);

    $permission = Permission::create([
      'name' => $request->name,
      'description' => $request->description,
    ]);

    $modules = Module::all();

    foreach ($modules as $module) {
      $moduleCode = $module->code;
      $permission->modules()->attach($moduleCode, [
        'add_access' => $request->has('add_access_' . $moduleCode),
        'view_access' => $request->has('view_access_' . $moduleCode),
        'edit_access' => $request->has('edit_access_' . $moduleCode),
        'delete_access' => $request->has('delete_access_' . $moduleCode),
      ]);
    }

    return redirect()
      ->route('pages-permissions')
      ->with('success', 'Permission created successfully');
  }

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

  public function edit($id)
  {
    $permission = Permission::findOrFail($id);
    $modules = Module::whereNull('parent_code')
      ->with('submodules')
      ->get();

    return view('content.permissions.edit-permission', compact('modules', 'permission'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string',
      'description' => 'nullable|string',
    ]);
    // dd($request->all());

    $permission = Permission::findOrFail($id);

    $permission->name = $request->name;
    $permission->description = $request->description;

    $permission->save();

    $modules = Module::all();

    foreach ($modules as $module) {
      $moduleCode = $module->code;
      $permission->modules()->updateExistingPivot($moduleCode, [
        'add_access' => $request->has('add_access_' . $moduleCode),
        'view_access' => $request->has('view_access_' . $moduleCode),
        'edit_access' => $request->has('edit_access_' . $moduleCode),
        'delete_access' => $request->has('delete_access_' . $moduleCode),
      ]);
    }

    return redirect()
      ->route('pages-permissions')
      ->with('success', 'Permission updated successfully');

    return redirect()
      ->back()
      ->with('error', 'Your error message here');
  }

  public function delete($id)
  {
    $permission = Permission::findOrFail($id);
    $permission->delete();

    return redirect()
      ->route('pages-permissions')
      ->with('success', 'Permission deleted successfully');
  }
}
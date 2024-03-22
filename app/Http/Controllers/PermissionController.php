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
    $filter = $request->filter;

    $permissions = Permission::query()
      ->when($search, function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%');
      })
      ->when($filter && $filter !== 'all', function ($query) use ($filter) {
        $query->where('is_active', $filter === 'active');
      })
      ->get();

    if ($request->has('id')) {
      // Get the permission with the provided ID
      $permission = Permission::findOrFail($request->id);
      // Redirect to the edit page for the specified permission
      return redirect()->route('permissions.edit', ['id' => $permission->id]);
    }
    // Toggle action
    if ($request->filled('toggle')) {
      $permissionId = $request->permission_id;
      $permission = Permission::where('id', $permissionId)->firstOrFail();
      $permission->is_active = !$permission->is_active;

      if (!$permission->is_active) {
        $permission->update(['is_active' => false]);
      }

      $permission->save();

      return redirect()->route('pages-permissions');
    }

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

  // public function edit($id)
  // {
  //   $permission = Permission::findOrFail($id);
  //   $modules = Module::all();
  //   return view('content.permissions.edit-permission', compact('modules', 'permission'));
  // }
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

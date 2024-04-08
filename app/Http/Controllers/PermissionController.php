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

    return view('content.permissions.index', compact('permissions'));
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
    // dd($request->all());

    $data = $request->validate([
      'name' => 'required|string',
      'description' => 'nullable|string',
    ]);

    // dd($request->all());
    $permission = Permission::create($data);

    $permissions = $request->input('permissions', []);

    $permission->modules()->attach($permissions);

    return redirect()
      ->route('pages-permissions')
      ->with('success', 'Permission created successfully');
  }

  /**
   * Toggle the status of the specified permission.
   */
  public function togglePermissionStatus(Request $request, $id)
  {
    $permission = Permission::findOrFail($id);

    $permission->is_active = !$permission->is_active;

    $permission->save();

    return response()->json(['success' => 'Permission status toggled successfully.']);
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

    $permission->update($data);

    // $modules = $request->input('modules', []);

    // dd($request->all());
    $permissions = $request->input('permissions', []);

    // foreach ($modules as $module) {
    //   $moduleCode = $module->code;
    //   $permission->modules()->createOrUpdate($moduleCode, $permissions);
    // }

    // $modulesToAttach = Module::whereIn('id', $permissions)->get();

    // Sync the modules for the permission

    // dd($permission->modules()->sync($permissions));
    $permission->modules()->sync($permissions);
    // Permission::with('modules')->updateOrCreate($permissions);

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

    return response()->json(['success' => 'Permission deleted successfully.']);
  }
}

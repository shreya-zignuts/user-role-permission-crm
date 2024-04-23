<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

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
    $permissions = Permission::query()
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

    $permissions->appends(['search' => $request->input('search'), 'filter' => $request->input('filter')]);

    return view('content.admin.permissions.index', compact('permissions'));
  }

  /**
   * Show the form for creating a new permission.
   */
  public function create()
  {
    $modules = Module::whereNull('parent_code')
      ->with('submodules')
      ->get();

    return view('content.admin.permissions.create', compact('modules'));
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
      'permissions' => 'array',
      'permissions.*' => 'array|nullable',
      // 'modules' => 'array',
    ]);

    // dd($request->all());
    $permission = Permission::create($data);

    $permissions = $request->input('permissions', []);

    // dd($permissions);
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
    $permission = Permission::find($id);

    if (!$permission) {
      return redirect()
        ->back()
        ->with('error', 'permission not found');
    }

    // $permission->update(['is_active' => !$permission->is_active]);

    $permission->is_active = !$permission->is_active;
    // Assuming 'status' is either 1 or 0
    $permission->save();

    return response()->json(['success' => 'Permission status toggled successfully.']);
  }

  /**
   * Show the form for editing the specified permission.
   */
  public function edit($id)
  {
    $permission = Permission::find($id);

    if (!$permission) {
      return redirect()
        ->back()
        ->with('error', 'per not found');
    }
    $modules = Module::whereNull('parent_code')
      ->with('submodules')
      ->get();

    return view('content.admin.permissions.edit-permission', compact('modules', 'permission'));
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

    $permission = Permission::find($id);

    if (!$permission) {
      return redirect()
        ->back()
        ->with('error', 'module not found');
    }

    $permission->update($data);

    $permissions = $request->input('permissions', []);

    $permission->modules()->sync($permissions);

    return redirect()
      ->route('pages-permissions')
      ->with('success', 'Permission updated successfully');
  }

  /**
   * Remove the specified permission from storage.
   */
  public function delete($id)
  {
    $permission = Permission::find($id);

    if (!$permission) {
      return redirect()
        ->back()
        ->with('error', 'module not found');
    }
    $permission->delete();

    return response()->json(['success' => 'Permission deleted successfully.']);
  }
}

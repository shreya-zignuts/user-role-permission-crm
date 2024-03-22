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

    $permissions = Permission::create([
      'name' => $request->name,
      'description' => $request->description,
    ]);

    return redirect()
      ->route('pages-permissions', compact('permissions'))
      ->with('success', 'Permission created successfully!');
  }
}

<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
  /**
   * Display a listing of the modules.
   */
  public function index(Request $request)
  {
    $query = Module::query()->whereNull('parent_code');

    $filter = $request->input('filter', 'all');

    if ($request->filled('search')) {
      $searchQuery = $request->search;

      $query
        ->Where('name', 'like', '%' . $searchQuery . '%')
        ->orwhereHas('submodules', function ($subquery) use ($searchQuery) {
          $subquery->where('name', 'like', '%' . $searchQuery . '%');
        });
    }

    if ($filter === 'active') {
      $query->where('is_active', true);
    } elseif ($filter === 'inactive') {
      $query->where('is_active', false);
    }

    $modules = $query->with('submodules')->paginate(5);

    return view('content.modules.index', compact('filter', 'modules'));
  }

  /**
   * Show the form for editing the specified module.
   */
  public function edit($moduleId)
  {
    $module = Module::where('code', $moduleId)->firstOrFail();
    return view('content.modules.edit-module', compact('module'));
  }

  /**
   * Update the specified module in storage.
   */
  public function update(Request $request, $moduleId)
  {
    $module = Module::where('code', $moduleId)->firstOrFail();

    $module->update($request->all());

    return redirect()
      ->route('pages-modules')
      ->with('success', 'Module updated successfully.');
  }

  /**
   * Toggle the status of the specified module.
   */
  public function toggleModuleStatus(Request $request, $moduleId)
  {
    $module = Module::findOrFail($moduleId);
    
    $module->is_active = !$module->is_active;
    $module->save();

    if (!$module->is_active) {
      $module->submodules()->update(['is_active' => false]);
    }

    // return redirect()
    //   ->back()
    //   ->with('success', 'Module status toggled successfully.');
    return response()->json(['success' => 'Permission status toggled successfully.']);
  }
}

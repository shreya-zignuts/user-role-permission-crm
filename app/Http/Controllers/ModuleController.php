<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
  public function index(Request $request)
  {
    $query = Module::query()->whereNull('parent_code');

    // Filter by search query if provided
    if ($request->filled('search')) {
      $searchQuery = $request->search;

      // Search for submodules with the given name
      $query->whereHas('submodules', function ($subquery) use ($searchQuery) {
        $subquery->where('name', 'like', '%' . $searchQuery . '%');
      });

      // Include parent modules of the matching submodules
      $query->orWhere('name', 'like', '%' . $searchQuery . '%');
    }

    // Apply filter if provided
    if ($request->filled('filter')) {
      $filter = $request->filter;
      $query->where('is_active', $filter === 'active');
    }

    // Retrieve modules with their submodules
    $modules = $query->with('submodules')->get();

    // Handle toggle action
    if ($request->filled('toggle')) {
      $moduleCode = $request->module_code;
      $module = Module::where('code', $moduleCode)->firstOrFail();
      $module->is_active = !$module->is_active;

      // If module is deactivated, deactivate its submodules as well
      if (!$module->is_active) {
        $module->subModules()->update(['is_active' => false]);
      }

      $module->save();

      return redirect()->route('pages-modules');
    }

    return view('content.modules.modules', compact('modules'));
  }

  public function edit($moduleId)
  {
    $module = Module::where('code', $moduleId)->firstOrFail();
    return view('content.modules.edit-module', compact('module'));
  }

  public function update(Request $request, $moduleId)
  {
    $module = Module::where('code', $moduleId)->firstOrFail();

    $module->update($request->all());

    return redirect()
      ->route('pages-modules')
      ->with('success', 'Module updated successfully.');
  }
}

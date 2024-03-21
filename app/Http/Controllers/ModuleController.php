<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
  public function index(Request $request)
  {
    $query = Module::query()->whereNull('parent_code');

    $searchQuery = $request->search;

    if ($request->has('search')) {
      // Search for submodules with the given name
      $query->whereHas('submodules', function ($subquery) use ($searchQuery) {
        $subquery->where('name', 'like', '%' . $searchQuery . '%');
      });

      // Include parent modules of the matching submodules
      $query->orWhereHas('module', function ($parentQuery) use ($searchQuery) {
        $parentQuery->where('name', 'like', '%' . $searchQuery . '%');
      });
    }

    if ($request->has('filter')) {
      $filter = $request->filter;
      if ($filter === 'active') {
        $query->where('is_active', true);
      } elseif ($filter === 'inactive') {
        $query->where('is_active', false);
      }
    }

    $modules = $query->with('submodules')->get();

    if ($request->filled('toggle')) {
      $moduleCode = $request->module_code;
      $module = Module::where('code', $moduleCode)->firstOrFail();
      $module->is_active = !$module->is_active;

      if (!$module->is_active) {
        $module->subModules()->update(['is_active' => false]);
      }

      $module->save();
      return redirect()->route('pages-modules');
    }

    // if (!$modules->is_active) {
    //   $modules->subModules()->update(['is_active' => false]);
    // }

    return view('content.modules.modules', compact('modules'));
    // $modules = Module::with('submodules')
    //   ->whereNull('parent_code')
    //   ->get();

    // return view('content.modules.modules', compact('modules'));
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
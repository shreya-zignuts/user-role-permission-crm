<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
  public function index(Request $request)
  {
    $query = Module::query()->whereNull('parent_code');

    if ($request->filled('search')) {
      $searchQuery = $request->search;

      $query->whereHas('submodules', function ($subquery) use ($searchQuery) {
        $subquery->where('name', 'like', '%' . $searchQuery . '%');
      });

      $query->orWhere('name', 'like', '%' . $searchQuery . '%');
    }

    if ($request->filled('filter')) {
      $filter = $request->filter;
      $query->where('is_active', $filter === 'active');
    }

    $modules = $query->with('submodules')->get();

    $moduleCount = $modules->count();

    if ($request->filled('toggle')) {
      $moduleCode = $request->module_code;
      $module = Module::where('code', $moduleCode)->firstOrFail();
      $module->is_active = !$module->is_active;

      if (!$module->is_active) {
        $module->submodules()->update(['is_active' => false]);
      }

      $module->save();

      return redirect()->route('pages-modules');
    }

    return view('content.modules.modules', compact('modules', 'moduleCount'));
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

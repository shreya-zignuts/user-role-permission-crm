<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
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

  public function toggleModuleStatus(Request $request)
  {
    $moduleId = $request->module_code;

    $module = Module::findOrFail($moduleId);

    $module->is_active = !$module->is_active;

    $module->save();

    return redirect()
      ->back()
      ->with('success', 'Module status toggled successfully.');
  }
}

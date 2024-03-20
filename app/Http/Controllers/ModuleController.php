<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
  public function index(Request $request)
  {
    $query = Module::query()->whereNull('parent_code');

    if ($request->has('search')) {
      $searchQuery = $request->search;

      $query->where('name', 'like', '%' . $searchQuery . '%');

      $query->orWhereHas('submodules', function ($subquery) use ($searchQuery) {
        $subquery->where('name', 'like', '%' . $searchQuery . '%');
      });
    }

    if ($request->has('filter')) {
      $filter = $request->input('filter');
      if ($filter === 'active') {
        $query->where('is_active', true);
      } elseif ($filter === 'inactive') {
        $query->where('is_active', false);
        
      }
    }

    $modules = $query->with('submodules')->get();

    if ($request->filled('module_status') && $request->filled('module_code')) {
      $moduleCode = $request->module_code;
      $isActive = $request->module_status === 'active';
      $module = Module::where('code', $moduleCode)->firstOrFail();
      $module->is_active = $isActive;
      $module->save();
    }

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
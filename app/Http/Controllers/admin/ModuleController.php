<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

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

    if ($request->filled('search')) {
      $searchQuery = $request->search;

      $query
        ->Where('name', 'like', '%' . $searchQuery . '%')
        ->orwhereHas('submodules', function ($subquery) use ($searchQuery) {
          $subquery->where('name', 'like', '%' . $searchQuery . '%');
        });
    }

    // if ($request->input('filter') && $request->input('filter') !== 'all') {
    //   $query->where('is_active', $request->input('filter') === 'active' ? '1' : '0');
    // }

    // $modules = $query->with('submodules')->paginate(5);

    if ($request->input('filter') && $request->input('filter') !== 'all') {
      $isActive = $request->input('filter') === 'active' ? '1' : '0';

      // dd($isActive);
      $query->where('is_active', $isActive);

      $query->with([
        'submodules' => function ($query) use ($isActive) {
          $query->where('is_active', $isActive);
        },
      ]);
    }

    $modules = $query->get();

    return view('content.admin.modules.index', compact('modules'));
  }

  /**
   * Show the form for editing the specified module.
   */
  public function edit($moduleId)
  {
    $module = Module::where('code', $moduleId)->firstOrFail();
    return view('content.admin.modules.edit-module', compact('module'));
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
    $module = Module::find($moduleId);

    if (!$module) {
      return redirect()
        ->back()
        ->with('error', 'module not found');
    }

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

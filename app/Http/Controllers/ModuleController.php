<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
  public function index()
  {
    $modules = Module::with('submodules')
      ->whereNull('parent_code')
      ->get();

    return view('content.pages.modules', compact('modules'));
  }
}
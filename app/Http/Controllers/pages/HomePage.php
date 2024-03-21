<?php

namespace App\Http\Controllers\pages;

use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePage extends Controller
{
  public function index()
  {
    $activeModuleCount = Module::where('is_active', true)->count();
    return view('content.pages.pages-home', ['activeModuleCount' => $activeModuleCount]);
  }
}

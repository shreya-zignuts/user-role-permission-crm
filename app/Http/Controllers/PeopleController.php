<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeopleController extends Controller
{
  public function index()
  {
    $user = Auth::user();

    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

    $people = People::all();
    return view('content.userside.people.index', compact('user', 'people'));
  }

  public function create()
  {
    $user = Auth::user();
    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

    $people = People::all();
    return view('content.userside.people.create', compact('user', 'people'));
  }
}
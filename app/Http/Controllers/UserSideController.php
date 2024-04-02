<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserSideController extends Controller
{
  /**
   * Display the index page for the user side.
   */
  public function index()
  {
    return view('content.userside.index');
  }
}

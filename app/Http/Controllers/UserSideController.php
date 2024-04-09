<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSideController extends Controller
{
  /**
   * Display the index page for the user side.
   */
  public function index()
  {
    $user = Auth::user();
    return view('content.userside.index', compact('user'));
  }

  public function edit($id)
  {
    $user = User::findOrFail($id);
    return view('content.userside.edit-profile', compact('user'));
  }

  /**
   * Update the specified user in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'first_name' => 'required|string|max:64',
      'last_name' => 'nullable|string|max:64',
      'phone_number' => 'nullable|string|max:16',
      'address' => 'nullable|string|max:256',
    ]);

    $user = User::findOrFail($id);

    $user->update([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'phone_number' => $request->phone_number,
      'address' => $request->address,
    ]);

    return redirect()
      ->route('pages-userside')
      ->with('success', 'User updated successfully.');
  }

  public function resetPassword(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|string|min:8|confirmed',
    ]);

    $email = $request->email;

    $user = User::where('email', $email)->first();

    if (!$user) {
      return redirect()
        ->back()
        ->with('error', 'User not exists.');
    }

    $user->password = Hash::make($request->password);
    $user->save();

    Auth::login($user);

    return redirect()
      ->route('pages-userside')
      ->with('success', 'User successfully logged in');
  }

  public function showModules()
  {
    // $modules = Module::findOrFail($id);
    return view('content.userside.modules');
  }
}

<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\MenuServiceProvider;

class UserSideController extends Controller
{

  /**
   * Display the index page for the user side.
   */

  public function index(Request $request)
  {
    $user = Auth::user();

    // Check if the user is authenticated
    if (!$user) {
      return redirect()->route('login');
    }
    // dd($modules);
    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

    return view('content.userside.index', [
      'user' => $user,
    ]);
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

}

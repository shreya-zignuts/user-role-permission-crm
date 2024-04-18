<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Models\User;
use App\Models\Module;
use App\Helpers\Helpers;
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
    $user = Helpers::getUserData();

    // dd($user);

    return view('content.userside.dashboard.index', [
      'user' => $user,
    ]);
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
      ->route('user-dashboard')
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
      ->route('user-dashboard')
      ->with('success', 'Password Reset Successfull');
  }
}

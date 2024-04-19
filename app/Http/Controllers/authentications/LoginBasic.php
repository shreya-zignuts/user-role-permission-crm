<?php

namespace App\Http\Controllers\authentications;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class LoginBasic extends Controller
{
  public function index(Request $request)
  {
    $pageConfigs = ['myLayout' => 'blank'];

    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->remember;

    if (Auth::attempt($credentials, $remember)) {
      $user = Auth::user();

      $user->is_active = 1;
      $user->save();
      $token = $user->createToken('API Token')->plainTextToken;

      if ($remember) {
        $rememberToken = Str::random(60);
        $cookie = Cookie::forever('remember_token', $rememberToken);
        Cookie::queue('remember_email', $request->email, 60 * 24 * 30);
        Cookie::queue('remember_password', $request->password, 60 * 24 * 30);
        auth()
          ->user()
          ->update(['remember_token' => hash('sha256', $rememberToken)]);
      }

      if ($user->id === 1) {
        return redirect()
          ->route('admin-dashboard')
          ->with('success', 'Admin successfully logged in');
      } else {
        return redirect()
          ->route('user-dashboard')
          ->with('success', 'User successfully logged in');
      }
    }

    return back()->with('error', 'Wrong credentials');
  }

  public function logout()
  {
    if (Auth::check()) {
      $user = Auth::user();

      $user->tokens()->delete();
      // $user->update(['remember_token' => null]);
      Auth::logout();

      return redirect()
        ->route('login')
        ->with('success', 'Successfully logged out');
    }
  }
}

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
    $email = $request->cookie('remember_token')
      ? User::where('remember_token', $request->cookie('remember_token'))->value('email')
      : null;
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
      if ($user->id === 1 || $user->is_active == 1) {
        $user->is_active = 1;
        $user->save();
        $token = $user->createToken('API Token')->plainTextToken;
      } else {
        return redirect()
          ->route('login')
          ->withErrors(['error' => 'Your account is inactive. Please contact the administrator.']);
      }

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
          ->route('pages-home')
          ->with('success', 'Admin successfully logged in');
      } else {
        return redirect()
          ->route('pages-userside')
          ->with('success', 'User successfully logged in');
      }
    }

    return back()->with('error', 'Wrong credentials');
  }

  public function logout()
  {
    $user = Auth::user();
    $user->update(['remember_token' => null]);

    return redirect()
      ->route('login')
      ->with('success', 'Successfully logged out');
  }
}

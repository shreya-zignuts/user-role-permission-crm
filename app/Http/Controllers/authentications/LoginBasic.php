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

    $rememberChecked = session()->get('login.remember');

    return view('content.authentications.auth-login-basic', [
      'pageConfigs'     => $pageConfigs,
      'rememberChecked' => $rememberChecked ?? null,
    ]);
  }

  public function login(Request $request)
  {
    $request->validate([
      'email'     => 'required|email',
      'password'  => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    $rememberChecked = $request->has('remember') ? true : false;
    session(['login.remember' => $rememberChecked]);

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
      } else {
        Cookie::queue(Cookie::forget('remember_token'));
        Cookie::queue(Cookie::forget('remember_email'));
        Cookie::queue(Cookie::forget('remember_password'));
      }

      if ($user->id === 1) {
        return redirect()
          ->route('admin-dashboard')
          ->with('success', 'Admin successfully logged in');
      } else {
        return redirect()
          ->route('user-dashboard')
          ->with('success', 'WELCOME, logged in successfull');
      }
    }

    return back()->with('error', 'Wrong credentials');
  }

  public function logout()
  {
    if (Auth::check()) {
      $user = Auth::user();

      $user->tokens()->delete();
      Auth::logout();

      return redirect()
        ->route('login')
        ->with('success', 'Successfully logged out');
    }
  }
}

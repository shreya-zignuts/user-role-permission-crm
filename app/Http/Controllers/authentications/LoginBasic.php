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
    // $credentials = $request->only('email', 'password');

    // if (Auth::attempt($credentials)) {
    //   return redirect()
    //     ->intended('/')
    //     ->with('success', 'Logged In successfully.');
    // }

    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->remember;

    if (Auth::attempt($credentials, $remember)) {
      // Authentication was successful
      $user = Auth::user();
      $token = $user->createToken('API Token')->plainTextToken;

      if ($remember) {
        $rememberToken = Str::random(60);
        $cookie = cookie()->forever('remember_token', $rememberToken);

        Cookie::queue('remember_email', $request->input('email'), 60 * 24 * 30);
        Cookie::queue('remember_password', $request->input('password'), 60 * 24 * 30);
        auth()
          ->user()
          ->update(['remember_token' => hash('sha256', $rememberToken)]);
        return redirect()
          ->route('pages-home')
          ->with('success', 'successfully logged out')
          ->withCookie($cookie);
      }
      return redirect()
        ->route('pages-home')
        ->with('success', 'successfully logged out');
    }
    return redirect()
      ->route('pages-home')
      ->with('success', 'successfully logged out');
  }

  // private function associateTokenWithUser(User $user, string $token)
  // {
  //   $accessToken = PersonalAccessToken::findToken($token);

  //   if ($accessToken) {
  //     $accessToken
  //       ->forceFill([
  //         'tokenable_id' => $user->getKey(),
  //         'tokenable_type' => get_class($user),
  //       ])
  //       ->save();
  //   }
  // }

  // public function forceLogoutUser(Request $request)
  // {
  //   User::findOrFail($request->id)
  //     ->tokens()
  //     ->delete();

  //   return redirect()
  //     ->back()
  //     ->with('success', 'Logged In successfully.');
  //   // return response()->json(['error' => 'User not found'], 404);
  // }

  // public function logout()
  // {
  //   auth()
  //     ->user()
  //     ->tokens()
  //     ->delete();

  //   $cookie = cookie()->forget('token');

  //   return redirect()
  //     ->route('login')
  //     ->with('success', 'successfully logged out');
  // }
  public function logout()
  {
    auth()
      ->user()
      ->update(['remember_token' => null]);
    // Forget remember token cookie
    // Cookie::queue(Cookie::forget('remember_email'));
    // Cookie::queue(Cookie::forget('remember_password'));
    // $cookie = cookie()->forget('remember_token');

    // $cookie = cookie()->forget('remember_token');
    return redirect()
      ->route('login')
      ->with('success', 'successfully logged out');
  }
}

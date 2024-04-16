<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
  public function showForgotForm()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.forgot-password', ['pageConfigs' => $pageConfigs]);
  }

  /**
   * Send reset password link email to the user.
   */
  public function sendResetLinkEmail(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
    ]);

    $result = $this->sendResetLinkEmailToUser($request->email);

    if ($result['status'] === 'success') {
      return redirect()
        ->route('auth-login-basic')
        ->with('success', 'Link Sent Successfully');
    } else {
      return back()->withErrors(['email' => $result['message']]);
    }
  }

  /**
   * Send reset password link email to the user.
   */
  protected function sendResetLinkEmailToUser($email)
  {
    $user = User::where('email', $email)->first();

    if (!$user) {
      return ['status' => 'error', 'message' => 'User not found.'];
    }

    $existingToken = PasswordResetToken::where('email', $user->email)->first();

    if ($existingToken) {
      return ['status' => 'error', 'message' => 'Reset link already sent.'];
    }

    $token = Str::random(60);

    $passwordResetToken = new PasswordResetToken();
    $passwordResetToken->email = $user->email;
    $passwordResetToken->token = $token;
    $passwordResetToken->created_at = now();

    $passwordResetToken->save();

    $resetLink = url("password/reset/{$token}");

    Mail::to($user->email)->send(new ForgotPassword($user, $resetLink));

    return ['status' => 'success', 'message' => 'Password reset link sent successfully.'];
  }

  public function showResetForm(Request $request)
  {
    // Check if the token matches an invitation token for a user
    $email = $request->email;

    $existingToken = DB::table('password_reset_tokens')
      ->where('email', $email)
      ->first();

    // dd($existingToken);
    if ($existingToken) {
      $pageConfigs = ['myLayout' => 'blank'];
      return view('content.authentications.reset-forgot-password', compact('email', 'pageConfigs'));
    }

    $pageConfigs = ['myLayout' => 'blank'];

    Session::flash('success', 'Already sent link for reset password');
    return view('content.authentications.auth-login-basic', compact('pageConfigs'));
  }

  /**
   * Reset the user's password.
   */
  public function resetPassword(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|string|min:8|confirmed',
    ]);

    $email = $request->email;

    $user = User::where('email', $email)->first();

    if ($user) {
      // Check if there is an existing token
      $existingToken = DB::table('password_reset_tokens')
        ->where('email', $email)
        ->first();

      if ($existingToken) {
        // Delete the existing token
        DB::table('password_reset_tokens')
          ->where('email', $email)
          ->delete();
      }

      // Additional logic if needed after deleting the token
    } else {
      // User not found
      return ['status' => 'error', 'message' => 'User not found.'];
    }

    $user->password = Hash::make($request->password);
    $user->status = 'A';
    $user->save();

    Auth::login($user);

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
}
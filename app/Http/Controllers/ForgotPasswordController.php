<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
  /**
   * Display the forgot password form.
   */
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.forgot-password', ['pageConfigs' => $pageConfigs]);
  }

  /**
   * Send reset password link to the specified email.
   */
  public function sendResetLinkEmail(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
    ]);

    $result = $this->sendResetLinkEmailToUser($request->email);

    if ($result['status'] === 'success') {
      return redirect()
        ->route('login')
        ->with('status', $result['message']);
    } else {
      return back()->withErrors(['email' => $result['message']]);
    }
  }

  /**
   * Send reset password link to the user.
   */
  protected function sendResetLinkEmailToUser($email)
  {
    $user = User::where('email', $email)->first();

    if (!$user) {
      return ['status' => 'error', 'message' => 'User not found.'];
    }

    $token = Password::getRepository()->create($user);

    $resetLink = url("password/reset/{$token}");

    Mail::to($user->email)->send(new ForgotPassword($user, $resetLink));

    return ['status' => 'success', 'message' => 'Password reset link sent successfully.'];
  }

  /**
   * Show the password reset form.
   */
  public function showResetForm(Request $request)
  {
    $pageConfigs = ['myLayout' => 'blank'];

    $email = $request->query('email');

    return view('content.authentications.reset-password', compact('email', 'pageConfigs'));
  }

  /**
   * Reset user's password.
   */
  public function resetPassword(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::where('email', $request->email)->first();

    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()
      ->route('auth-login-basic')
      ->with('success', 'Password reset successfully. You can now log in.');
  }
}

<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ForgotPassword;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

use App\Mail\ResetPasswordInvitation;
use App\Mail\ResetPasswordNotification;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\HasApiTokens;

class UserController extends Controller
{
  /**
   * Display a listing of the users.
   */
  public function index(Request $request)
  {
    $search = $request->search;
    $filter = $request->filter;

    $users = User::query()
      ->when($search, function ($query) use ($search) {
        $query->where('first_name', 'like', '%' . $search . '%');
      })
      ->when($filter && $filter !== 'all', function ($query) use ($filter) {
        $query->where('is_active', $filter === 'active');
      })
      ->paginate(5);
    return view('content.users.index', compact('users', 'filter'));
  }

  /**
   * Show the form for creating a new user.
   */
  public function create()
  {
    $roles = Role::all();
    return view('content.users.create', compact('roles'));
  }

  /**
   * Store a newly created user in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'first_name' => 'required|string|max:64',
      'last_name' => 'nullable|string|max:64',
      'email' => 'required|string|email|max:128|unique:users,email',
      'phone_number' => 'nullable|string|max:16',
      'address' => 'nullable|string|max:256',
      'status' => [Rule::in(['I', 'A', 'R'])],
      'roles' => 'nullable|array',
    ]);

    $password = Str::random(10);

    $invitationToken = Str::random(60);

    $user = User::create([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' => $request->email,
      'phone_number' => $request->phone_number,
      'address' => $request->address,
      'password' => bcrypt($password),
      'status' => 'I',
      'invitation_token' => $invitationToken,
    ]);

    $user->roles()->attach($request->roles);

    $token = $user->createToken('API Token')->plainTextToken;

    $adminEmail = User::first()->email;

    if ($adminEmail) {
      Mail::to($user->email)->send(new ResetPasswordInvitation($user, $adminEmail, $password));
    }

    return redirect()
      ->route('pages-users')
      ->with('success', 'User created successfully.');
  }

  /**
   * Toggle the status of the specified user.
   */
  public function toggleStatus(Request $request)
  {
    $userId = $request->user_id;

    $user = User::findOrFail($userId);

    $user->is_active = !$user->is_active;

    $user->save();

    return redirect()
      ->back()
      ->with('success', 'Status toggled successfully.');
  }

  /**
   * Show the form for editing the specified user.
   */
  public function edit($id)
  {
    $user = User::findOrFail($id);
    $roles = Role::all();
    return view('content.users.edit-user', compact('user', 'roles'));
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
      'roles' => 'nullable|array',
    ]);

    $user = User::findOrFail($id);

    $user->update([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'phone_number' => $request->phone_number,
      'address' => $request->address,
    ]);

    $user->roles()->sync($request->roles);

    return redirect()
      ->route('pages-users')
      ->with('success', 'User updated successfully.');
  }

  /**
   * Remove the specified user from storage.
   */
  public function delete($id)
  {
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()
      ->route('pages-users')
      ->with('success', 'User deleted successfully');
  }

  /**
   * Reset password form.
   */
  public function resetPasswordForm(Request $request)
  {
    $request->validate([
      'id' => 'required|exists:users,id',
      'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::findOrFail($request->id);

    $password = $request->password;

    $user->password = Hash::make($password);
    $user->save();

    $adminEmail = User::first()->email;

    if ($adminEmail) {
      Mail::to($user->email)->send(new ResetPasswordNotification($user, $adminEmail, $password));
    }

    return redirect()
      ->back()
      ->with('success', 'Password reset successfully!');
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
   * Reset the user's password.
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

  /**
   * Show the forgot password form.
   */
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
        ->route('login')
        ->with('status', $result['message']);
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

    $token = Password::createToken($user);
    $resetLink = url("password/reset/{$token}");

    Mail::to($user->email)->send(new ForgotPassword($user, $resetLink));

    return ['status' => 'success', 'message' => 'Password reset link sent successfully.'];
  }

  /**
   * Force logout a user and deactivate their account.
   */
  public function forceLogoutUser(Request $request)
  {
    $user = User::find($request->id);
    if (!$user) {
      return back()->with('message', 'User not found');
    }
    // dd($user->tokens()->delete());
    $user->tokens()->delete();

    $user->is_active = 0;
    $user->save();

    return redirect()
      ->back()
      ->with('success', 'User Logged Out Forcefully.');
  }
}

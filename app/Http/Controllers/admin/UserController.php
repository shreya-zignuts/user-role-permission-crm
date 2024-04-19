<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordInvitation;
use App\Mail\ResetPasswordNotification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
  /**
   * Display a listing of the users.
   */
  public function index(Request $request)
  {
    $users = User::query()
      ->where(function ($query) use ($request) {
        // Search logic

        if ($request->input('search')) {
          $query
            ->where('first_name', 'like', "%{$request->input('search')}%")
            ->orWhere('last_name', 'like', "%{$request->input('search')}%");
        }

        if ($request->input('filter') && $request->input('filter') !== 'all') {
          $query->where('is_active', $request->input('filter') === 'active' ? '1' : '0');
        }
      })
      ->paginate(5);

    $users->appends(['search' => $request->input('search'), 'filter' => $request->input('filter')]);

    return view('content.admin.users.index', compact('users'));
  }

  /**
   * Show the form for creating a new user.
   */
  public function create()
  {
    $roles = Role::where('is_active', 1)->get();
    return view('content.admin.users.create', compact('roles'));
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
  public function toggleStatus(Request $request, $id)
  {
    $user = User::find($id);

    if (!$user) {
      return redirect()
        ->back()
        ->with('error', 'user not found');
    }

    $user->is_active = !$user->is_active;

    $user->save();

    // return redirect()
    //   ->back()
    //   ->with('success', 'User status toggled successfully.');

    return response()->json(['success' => 'User status toggled successfully.']);
  }

  /**
   * Show the form for editing the specified user.
   */
  public function edit($id)
  {
    $user = User::find($id);

    if (!$user) {
      return redirect()
        ->back()
        ->with('error', 'user not found');
    }
    $roles = Role::where('is_active', 1)->get();
    return view('content.admin.users.edit-user', compact('user', 'roles'));
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

    $user = User::find($id);

    if (!$user) {
      return redirect()
        ->back()
        ->with('error', 'user not found');
    }

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
    $user = User::find($id);

    if (!$user) {
      return redirect()
        ->back()
        ->with('error', 'user not found');
    }
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
    $user->tokens()->delete();
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
    $token = $request->token;

    // Check if the token matches an invitation token for a user
    $user = User::where('invitation_token', $token)->first();

    if ($user) {
      $email = $user->email; // Retrieve the email associated with the token

      if ($user->status === 'A' && $user->id !== 1) {
        $pageConfigs = ['myLayout' => 'blank'];

        Session::flash('success', 'Already set password');
        return view('content.authentications.auth-login-basic', compact('pageConfigs'));
      } else {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.authentications.reset-password', compact('token', 'email', 'pageConfigs'));
      }
    } else {
      return response()->view('errors.404', [], 404); // Example of a 404 error page
    }
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
        ->route('admin-dashboard')
        ->with('success', 'Admin successfully logged in');
    } else {
      return redirect()
        ->route('user-dashboard')
        ->with('success', 'User successfully logged in');
    }
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
    $user->tokens()->delete();
    // dd($user->tokens()->delete());

    return redirect()
      ->back()
      ->with('success', 'User Logged Out Forcefully.');
  }
}

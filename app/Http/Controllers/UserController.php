<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordInvitation;

class UserController extends Controller
{
  // public function index()
  // {
  //   $users = User::all();
  //   $roles = Role::all();
  //   return view('content.users.index', compact('users', 'roles'));
  // }

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
      ->get();

    return view('content.users.index', compact('users', 'filter'));
  }

  public function create()
  {
    $roles = Role::all();
    return view('content.users.create', compact('roles'));
  }

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

    if ($request->has('roles')) {
      $user->roles()->attach($request->roles);
    }

    $adminEmail = User::first()->email;

    if ($adminEmail) {
      Mail::to($user->email)->send(new ResetPasswordInvitation($user, $adminEmail, $password));
    }

    return redirect()
      ->route('pages-users')
      ->with('success', 'User created successfully.');
  }

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

  public function edit($id)
  {
    $user = User::findOrFail($id);
    $roles = Role::all();
    return view('content.users.edit-user', compact('user', 'roles'));
  }

  public function update(Request $request, $id)
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

    $user->roles()->sync($request->roles);

    return redirect()
      ->route('pages-users')
      ->with('success', 'User updated successfully.');
  }

  public function delete($id)
  {
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()
      ->route('pages-users')
      ->with('success', 'User deleted successfully');
  }

  public function resetPassword(Request $request, User $user)
  {
    // Generate a new random password
    $newPassword = Str::random(10);

    // Update the user's password in the database
    $user->password = Hash::make($newPassword);
    $user->save();

    // Send email notification with the new password to the user
    Mail::to($user->email)->send(new ResetPasswordInvitation($user, $newPassword));

    // Redirect back with success message
    return redirect()
      ->back()
      ->with('success', 'Password reset successfully. New password has been sent to the user.');
  }

  public function showresetPassword(User $user)
  {
    return view('content.users.reset-password', compact('user'));
  }

  public function resetPasswordForm(Request $request, User $user)
  {
    $request->validate([
      'password' => 'required|string|min:8|confirmed',
    ]);

    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()
      ->route('pages-users')
      ->with('success', 'Password reset successfully.');
  }
}

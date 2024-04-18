<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\People;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeopleController extends Controller
{
  public function index(Request $request)
  {
    $user = Helpers::getUserData();

    $moduleCode = 'PPL';
    $permissionsArray = Auth::user()->getModulePermissions($user, $moduleCode);

    $people = People::query()
      ->when($request->filled(['search', 'filter']), function ($query) use ($request) {
        // Apply search filter if search query is present
        if ($request->filled('search')) {
          $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Apply status filter if filter is selected
        if ($request->filled('filter') && $request->input('filter') !== 'all') {
          $query->where('is_active', $request->input('filter') === 'active' ? 1 : 0);
        }
      })
      ->paginate(5);

    $people->appends([$request->filled('search'), $request->filled('filter')]);

    return view('content.userside.people.index', compact('user', 'permissionsArray', 'people'));
  }

  public function create()
  {
    $userId = Auth::id();
    // dd($userId);
    $user = Helpers::getUserData();

    $people = People::all();

    return view('content.userside.people.create', compact('user', 'people', 'userId'));
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required|string|max:64',
      'designation' => 'string|max:64',
      'email' => 'required|string|email|max:128|unique:users,email',
      'phone_number' => 'nullable|string|max:16',
      'address' => 'nullable|string|max:256',
    ]);

    $data['user_id'] = auth()->user()->id;
    $user = People::create($data);

    return redirect()
      ->route('userside-people')
      ->with('success', 'User created successfully.');
  }

  public function edit($id)
  {
    $user = Helpers::getUserData();

    $userId = Auth::id();

    $people = People::find($id);

    if (!$people) {
      return redirect()
        ->back()
        ->with('error', 'people not found');
    }

    return view('content.userside.people.edit', compact('user', 'people', 'userId'));
  }

  /**
   * Update the specified user in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:64',
      'designation' => 'string|max:64',
      'email' => 'required|string|email|max:128|unique:users,email,' . $id,
      'phone_number' => 'nullable|string|max:16',
      'address' => 'nullable|string|max:256',
    ]);

    $people = People::find($id);

    if (!$people) {
      return redirect()
        ->back()
        ->with('error', 'people not found');
    }

    $people->update($request->only(['name', 'designation', 'email', 'phone_number', 'address']));

    return redirect()
      ->route('userside-people')
      ->with('success', 'User updated successfully.');
  }

  public function delete($id)
  {
    $people = People::find($id);

    if (!$people) {
      return redirect()
        ->back()
        ->with('error', 'people not found');
    }
    $people->delete();

    return redirect()
      ->route('userside-people')
      ->with('success', 'User deleted successfully');
  }

  public function toggleStatus(Request $request, $id)
  {
    $people = People::find($id);

    if (!$people) {
      return redirect()
        ->back()
        ->with('error', 'people not found');
    }

    $people->is_active = !$people->is_active;

    $people->save();

    // return redirect()
    //   ->back()
    //   ->with('success', 'User status toggled successfully.');

    return response()->json(['success' => 'User status toggled successfully.']);
  }
}

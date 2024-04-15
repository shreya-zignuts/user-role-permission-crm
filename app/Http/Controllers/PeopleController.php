<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeopleController extends Controller
{
  public function index(Request $request)
  {
    $user = Auth::user();

    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

    // $people = People::all();

    $search = $request->search;
    $filter = $request->filter;

    $people = People::query()
      ->when($search, function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%');
      })
      ->when($filter && $filter !== 'all', function ($query) use ($filter) {
        $query->where('is_active', $filter === 'active');
      })
      ->paginate(5);
    return view('content.userside.people.index', compact('user', 'people', 'filter'));
  }

  public function create()
  {
    $user = Auth::user();

    $userId = Auth::id();
    // dd($userId);
    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

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
    $user = Auth::user();

    // dd($userId);
    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

    $userId = Auth::id();

    $people = People::findOrFail($id);

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

    $people = People::findOrFail($id);

    $people->update($request->only(['name', 'designation', 'email', 'phone_number', 'address']));

    return redirect()
      ->route('userside-people')
      ->with('success', 'User updated successfully.');
  }

  public function delete($id)
  {
    $people = People::findOrFail($id);
    $people->delete();

    return redirect()
      ->route('userside-people')
      ->with('success', 'User deleted successfully');
  }

  public function toggleStatus(Request $request, $id)
  {
    $people = People::findOrFail($id);

    $people->is_active = !$people->is_active;

    $people->save();

    // return redirect()
    //   ->back()
    //   ->with('success', 'User status toggled successfully.');

    return response()->json(['success' => 'User status toggled successfully.']);
  }
}
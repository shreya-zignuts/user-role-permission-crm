<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
  public function index(Request $request)
  {
    $user = Auth::user();

    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

    // $people = People::all();

    $search = $request->search;
    $filter = $request->filter;

    $meetings = Meeting::query()
      ->when($search, function ($query) use ($search) {
        $query->where('title', 'like', '%' . $search . '%');
      })
      ->when($filter && $filter !== 'all', function ($query) use ($filter) {
        $query->where('is_active', $filter === 'active');
      })
      ->paginate(5);
    return view('content.userside.meetings.index', compact('user', 'meetings', 'filter'));
  }

  public function create()
  {
    $user = Auth::user();

    $userId = Auth::id();
    // dd($userId);
    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

    $meetings = Meeting::all();

    return view('content.userside.meetings.create', compact('user', 'meetings', 'userId'));
  }

  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'title' => 'required|string|max:64',
      'description' => 'string|max:256',
      'date' => 'required|date',
      'time' => 'required|date_format:H:i',
    ]);

    $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time);

    // Get the current date and time
    $now = Carbon::now();

    // Calculate is_active based on current date/time and meeting date/time
    $is_active = $dateTime->gt($now); // Check if meeting time is greater than current time

    $meeting = new Meeting([
      'title' => $request->title,
      'description' => $request->description,
      'date' => $request->date, // Store date separately
      'time' => $request->time, // Store time separately
      'user_id' => $request->user_id,
      'is_active' => $is_active,
    ]);

    $meeting->save();

    return redirect()
      ->route('userside-meetings')
      ->with('success', 'User created successfully.');
  }

  public function edit($id)
  {
    $user = Auth::user();

    // dd($userId);
    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

    $userId = Auth::id();

    $meetings = Meeting::findOrFail($id);

    return view('content.userside.meetings.edit', compact('user', 'meetings', 'userId'));
  }

  /**
   * Update the specified user in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'title' => 'required|string|max:64',
      'description' => 'string|max:256',
      'date' => 'required|date|after_or_equal:today',
      'time' => 'required|date_format:H:i',
    ]);

    $meetings = Meeting::findOrFail($id);

    $meetings->update($request->only(['title', 'description', 'date', 'time']));

    return redirect()
      ->route('userside-meetings')
      ->with('success', 'User updated successfully.');
  }

  public function delete($id)
  {
    $meetings = Meeting::findOrFail($id);
    $meetings->delete();

    return redirect()
      ->route('userside-notes')
      ->with('success', 'User deleted successfully');
  }

  public function toggleStatus(Request $request, $id)
  {
    $meetings = Meeting::findOrFail($id);

    $meetings->is_active = !$meetings->is_active;

    $meetings->save();

    // return redirect()
    //   ->back()
    //   ->with('success', 'User status toggled successfully.');

    return response()->json(['success' => 'User status toggled successfully.']);
  }
}

<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
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
      'date' => 'required|date|after_or_equal:today',
      'time' => 'required|date_format:H:i',
    ]);

    //convert in 24 hours format
    $time12 = $request->time;
    $time24 = date('H:i', strtotime($time12));

    $meeting = new Meeting([
      'title' => $request->title,
      'description' => $request->description,
      'date' => $request->date,
      'time' => $time24,
      'user_id' => $request->user_id,
    ]);

    $meeting->save();

    return redirect()
      ->route('userside-meetings')
      ->with('success', 'Meeting created successfully.');
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
      ->with('success', 'Meeting updated successfully.');
  }

  public function delete($id)
  {
    $meetings = Meeting::findOrFail($id);
    $meetings->delete();

    return redirect()
      ->route('userside-notes')
      ->with('success', 'Meeting deleted successfully');
  }

  public function toggleStatus(Request $request, $id)
  {
    // Find the meeting by ID
    $meeting = Meeting::findOrFail($id);

    // Update the meeting status based on the request
    $meeting->is_active = $request->input('is_active');
    $meeting->save();

    // You can return a response if needed, such as JSON response
    return response()->json(['message' => 'Meeting status updated successfully'], 200);
  }
}

<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;

use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use App\Models\Meeting;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
  public function index(Request $request)
  {
    $user = Helpers::getUserData();

    $moduleCode = 'MET';
    $permissionsArray = Auth::user()->getModulePermissions($user, $moduleCode);

    $meetings = Meeting::query()
      ->when($request->filled(['search', 'filter']), function ($query) use ($request) {
        // Apply search filter if search query is present
        if ($request->filled('search')) {
          $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        // Apply status filter if filter is selected
        if ($request->filled('filter') && $request->input('filter') !== 'all') {
          $query->where('status', $request->input('filter') === 'active' ? 1 : 0);
        }
      })
      ->paginate(5);

    $meetings->appends([$request->filled('search'), $request->filled('filter')]);
    return view('content.userside.meetings.index', compact('user', 'meetings', 'permissionsArray'));
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
    $user = Helpers::getUserData();

    $userId = Auth::id();

    $meetings = Meeting::find($id);

    if (!$meetings) {
      return redirect()
        ->back()
        ->with('error', 'Meeting not found');
    }

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

    $meetings = Meeting::find($id);

    if (!$meetings) {
      return redirect()
        ->back()
        ->with('error', 'Meeting not found');
    }

    $meetings['is_active'] = 1;

    $meetings->update($request->only(['title', 'description', 'date', 'time', 'is_active']));

    return redirect()
      ->route('userside-meetings')
      ->with('success', 'Meeting updated successfully.');
  }

  public function delete($id)
  {
    $meetings = Meeting::find($id);

    if (!$meetings) {
      return redirect()
        ->back()
        ->with('error', 'Meeting not found');
    }
    $meetings->delete();

    return redirect()
      ->route('userside-notes')
      ->with('success', 'Meeting deleted successfully');
  }

  public function toggleStatus(Request $request, $id)
  {
    // Assuming 'Meeting' is your model
    $meeting = Meeting::find($id);

    if (!$meeting) {
      return response()->json(['error' => 'Meeting not found'], 404);
    }

    // Update is_active status
    $meeting->is_active = $request->status;
    $meeting->save();

    return response()->json(['success' => 'Meeting status updated successfully']);
  }
}

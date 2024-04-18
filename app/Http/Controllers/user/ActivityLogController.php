<?php

namespace App\Http\Controllers\user;
use App\Models\Module;

use App\Helpers\Helpers;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
  public function index(Request $request)
  {
    $user = Helpers::getUserData();

    $moduleCode = 'ACT';
    $permissionsArray = Auth::user()->getModulePermissions($user, $moduleCode);

    // $search = $request->search;
    // $filter = $request->filter;

    // $activityLog = ActivityLog::query()
    //   ->when($search, function ($query) use ($search) {
    //     $query->where('title', 'like', '%' . $search . '%');
    //   })
    //   ->when($filter && $filter !== 'all', function ($query) use ($filter) {
    //     $query->where('is_active', $filter === 'active');
    //   })
    //   ->paginate(5);

    $activityLog = ActivityLog::query()
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

    $activityLog->appends([$request->filled('search'), $request->filled('filter')]);

    return view('content.userside.activityLogs.index', compact('user', 'permissionsArray', 'activityLog'));
  }

  public function create()
  {
    $userId = Auth::id();
    // dd($userId);
    $user = Helpers::getUserData();

    $activityLog = ActivityLog::all();

    return view('content.userside.activityLogs.create', compact('user', 'activityLog', 'userId'));
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'title' => 'required|string|max:64',
      'log' => 'nullable|string|max:256',
      'type' => 'required|in:C,M,P,V',
    ]);

    // dd($data);
    // $data['user_id'] = auth()->user()->id;
    // $activityLog = ActivityLog::create($data);

    $activityLog = ActivityLog::create([
      'title' => $request->title,
      'log' => $request->log,
      'type' => $request->type,
      'user_id' => auth()->user()->id,
    ]);

    // dd($activityLog);

    return redirect()
      ->route('userside-activityLogs')
      ->with('success', 'Activity Log created successfully.');
  }

  public function edit($id)
  {
    $user = Helpers::getUserData();

    $userId = Auth::id();

    $activityLog = ActivityLog::find($id);

    if (!$activityLog) {
      return redirect()
        ->back()
        ->with('error', 'Activity Log not found');
    }

    return view('content.userside.activityLogs.edit', compact('user', 'activityLog', 'userId'));
  }

  /**
   * Update the specified user in storage.
   */
  public function update(Request $request, $id)
  {
    // dd($request->all());
    $request->validate([
      'title' => 'required|string|max:64',
      'log' => 'nullable|string|max:256',
      'type' => 'required|in:C,M,P,V',
    ]);

    $activityLog = ActivityLog::find($id);

    if (!$activityLog) {
      return redirect()
        ->back()
        ->with('error', 'Activity Log not found');
    }

    $activityLog->update($request->only(['title', 'log', 'type']));

    return redirect()
      ->route('userside-activityLogs')
      ->with('success', 'Activity Log updated successfully.');
  }

  public function delete($id)
  {
    $activityLog = ActivityLog::find($id);

    if (!$activityLog) {
      return redirect()
        ->back()
        ->with('error', 'Activity Log not found');
    }

    $activityLog->delete();

    return redirect()
      ->route('userside-activityLogs')
      ->with('success', 'Activity Log deleted successfully');
  }

  public function toggleStatus(Request $request, $id)
  {
    $activityLog = ActivityLog::find($id);

    if (!$activityLog) {
      return redirect()
        ->back()
        ->with('error', 'Activity Log not found');
    }

    $activityLog->is_active = !$activityLog->is_active;

    $activityLog->save();

    // return redirect()
    //   ->back()
    //   ->with('success', 'User status toggled successfully.');

    return response()->json(['success' => 'Activity Log status toggled successfully.']);
  }
}

<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;

use App\Helpers\Helpers;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
  public function index(Request $request)
  {
    $user = Helpers::getUserData();

    $moduleCode = 'CMP';
    $module = $user->modules->where('code', $moduleCode)->first();

    $permissions = $module
      ? $module
        ->permissions()
        ->withPivot('view_access', 'add_access', 'edit_access', 'delete_access')
        ->get()
      : null;

    // Prepare permissions array for the view
    $permissionsArray = [
      'view' => $permissions->where('pivot.view_access', true)->isNotEmpty(),
      'add' => $permissions->where('pivot.add_access', true)->isNotEmpty(),
      'edit' => $permissions->where('pivot.edit_access', true)->isNotEmpty(),
      'delete' => $permissions->where('pivot.delete_access', true)->isNotEmpty(),
    ];

    $search = $request->search;
    $filter = $request->filter;

    $activityLog = ActivityLog::query()
      ->when($search, function ($query) use ($search) {
        $query->where('title', 'like', '%' . $search . '%');
      })
      ->when($filter && $filter !== 'all', function ($query) use ($filter) {
        $query->where('is_active', $filter === 'active');
      })
      ->paginate(5);
    return view('content.userside.activityLogs.index', compact('user', 'permissionsArray', 'activityLog', 'filter'));
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

    $activityLog = ActivityLog::findOrFail($id);

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

    $activityLog = ActivityLog::findOrFail($id);

    $activityLog->update($request->only(['title', 'log', 'type']));

    return redirect()
      ->route('userside-activityLogs')
      ->with('success', 'Activity Log updated successfully.');
  }

  public function delete($id)
  {
    $activityLog = ActivityLog::findOrFail($id);
    $activityLog->delete();

    return redirect()
      ->route('userside-activityLogs')
      ->with('success', 'Activity Log deleted successfully');
  }

  public function toggleStatus(Request $request, $id)
  {
    $activityLog = ActivityLog::findOrFail($id);

    $activityLog->is_active = !$activityLog->is_active;

    $activityLog->save();

    // return redirect()
    //   ->back()
    //   ->with('success', 'User status toggled successfully.');

    return response()->json(['success' => 'Activity Log status toggled successfully.']);
  }
}

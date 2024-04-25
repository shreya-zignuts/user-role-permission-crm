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
    /**
    * Display a listing of the activity logs.
    */
    public function index(Request $request)
    {
        $user = Helpers::getUserData();

        $moduleCode = 'ACT';
        $permissionsArray = Auth::user()->getModulePermissions($user, $moduleCode);

        $activityLog = ActivityLog::query()
            ->where(function ($query) use ($request) {
                if ($request->input('search')) {
                    $query->where('title', 'like', "%{$request->input('search')}%");
                }

                if ($request->input('filter') && $request->input('filter') !== 'all') {
                    $query->where('is_active', $request->input('filter') === 'active' ? '1' : '0');
                }
            })
            ->paginate(5);

        $activityLog->appends(['search' => $request->input('search'), 'filter' => $request->input('filter')]);

        return view('content.userside.activityLogs.index', compact('user', 'permissionsArray', 'activityLog'));
    }

    /**
     * Show the form for creating a new activity log.
     */
    public function create()
    {
        $user = Helpers::getUserData();

        $activityLog = ActivityLog::all();

        return view('content.userside.activityLogs.create', compact('user', 'activityLog'));
    }

    /**
     * Store a newly created activity log in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:64',
            'log'   => 'nullable|string|max:256',
            'type'  => 'required|in:C,M,P,V',
        ]);

        $data['user_id'] = auth()->user()->id;
        $activityLog = ActivityLog::create($data);

        return redirect()->route('userside-activityLogs')->with('success', 'Activity Log created successfully.');
    }

    /**
     * Show the form for editing the specified activity log.
     */
    public function edit($id)
    {
        $user = Helpers::getUserData();

        $activityLog = ActivityLog::find($id);

        if (!$activityLog) {
            return redirect()->back()->with('error', 'Activity Log not found');
        }

        return view('content.userside.activityLogs.edit', compact('user', 'activityLog'));
    }

    /**
     * Update the specified activity log in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:64',
            'log'   => 'nullable|string|max:256',
            'type'  => 'required|in:C,M,P,V',
        ]);

        $activityLog = ActivityLog::find($id);

        if (!$activityLog) {
            return redirect()->back()->with('error', 'Activity Log not found');
        }

        $activityLog->update($request->all());

        return redirect()->route('userside-activityLogs')->with('success', 'Activity Log updated successfully.');
    }

    /**
     * Remove the specified activity log from storage.
     */
    public function delete($id)
    {
        $activityLog = ActivityLog::find($id);

        if (!$activityLog) {
            return redirect()->back()->with('error', 'Activity Log not found');
        }

        $activityLog->delete();

        return redirect()->route('userside-activityLogs')->with('success', 'Activity Log deleted successfully');
    }

    /**
     * Toggle the status of the specified activity log.
     */
    public function toggleStatus(Request $request, $id)
    {
        $activityLog = ActivityLog::find($id);

        if (!$activityLog) {
            return redirect()->back()->with('error', 'Activity Log not found');
        }

        $activityLog->is_active = !$activityLog->is_active;

        $activityLog->save();

        return response()->json(['success' => 'Activity Log status toggled successfully.']);
    }
}

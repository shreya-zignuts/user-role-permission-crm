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
    /**
     * Display a listing of the meetings.
     */
    public function index(Request $request)
    {
        $user = Helpers::getUserData();

        $moduleCode = 'MET';
        $permissionsArray = Auth::user()->getModulePermissions($user, $moduleCode);

        $meetings = Meeting::query()
            ->where(function ($query) use ($request) {
                if ($request->input('search')) {
                    $query->where('title', 'like', "%{$request->input('search')}%");
                }

                if ($request->input('filter') && $request->input('filter') !== 'all') {
                    $query->where('is_active', $request->input('filter') === 'active' ? '1' : '0');
                }
            })
            ->paginate(5);

        $meetings->appends(['search' => $request->input('search'), 'filter' => $request->input('filter')]);
        return view('content.userside.meetings.index', compact('user', 'meetings', 'permissionsArray'));
    }

    /**
     * Show the form for creating a new meeting.
     */
    public function create()
    {
        $user = Helpers::getUserData();

        $meetings = Meeting::all();

        return view('content.userside.meetings.create', compact('user', 'meetings'));
    }

    /**
     * Store a newly created meeting in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|max:64',
            'description' => 'string|max:256',
            'date'        => 'required|date|after_or_equal:today',
            'time'        => 'required|date_format:H:i',
        ]);

        //convert in 24 hours format
        $time12 = $request->time;
        $time24 = date('H:i', strtotime($time12));

        $meeting = new Meeting([
            'title'       => $request->title,
            'description' => $request->description,
            'date'        => $request->date,
            'time'        => $time24,
            'user_id'     => $request->user_id,
        ]);

        $meeting->save();

        return redirect()->route('userside-meetings')->with('success', 'Meeting created successfully.');
    }

    /**
     * Show the form for editing the specified meeting.
     */
    public function edit($id)
    {
        $user = Helpers::getUserData();

        $meetings = Meeting::find($id);

        if (!$meetings) {
            return redirect()->back()->with('error', 'Meeting not found');
        }

        return view('content.userside.meetings.edit', compact('user', 'meetings'));
    }

    /**
     * Update the specified meeting in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:64',
            'description' => 'string|max:256',
            'date'        => 'required|date|after_or_equal:today',
            'time'        => 'required|date_format:H:i',
        ]);

        $meetings = Meeting::find($id);

        if (!$meetings) {
            return redirect()->back()->with('error', 'Meeting not found');
        }

        $meetings->update($request->all());

        return redirect()->route('userside-meetings')->with('success', 'Meeting updated successfully.');
    }

    /**
     * Remove the specified meeting from storage.
     */
    public function delete($id)
    {
        $meetings = Meeting::find($id);

        if (!$meetings) {
            return redirect()->back()->with('error', 'Meeting not found');
        }
        $meetings->delete();

        return redirect()->route('userside-notes')->with('success', 'Meeting deleted successfully');
    }

    /**
     * Toggle the status of the specified meeting.
     */
    public function toggleStatus(Request $request, $id)
    {
        $meeting = Meeting::find($id);

        if (!$meeting) {
            return response()->json(['error' => 'Meeting not found'], 404);
        }

        $meeting->is_active = $request->status;
        $meeting->save();

        return response()->json(['success' => 'Meeting status updated successfully']);
    }
}
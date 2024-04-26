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
    /**
     * Display a listing of the peoples.
     */
    public function index(Request $request)
    {
        $user = Helpers::getUserData();

        $moduleCode = 'PPL';
        $permissionsArray = Auth::user()->getModulePermissions($user, $moduleCode);

        $people = People::query()
            ->where(function ($query) use ($request) {
                if ($request->input('search')) {
                    $query->where('name', 'like', "%{$request->input('search')}%");
                }

                if ($request->input('filter') && $request->input('filter') !== 'all') {
                    $query->where('is_active', $request->input('filter') === 'active' ? '1' : '0');
                }
            })
            ->paginate(5);

        $people->appends(['search' => $request->input('search'), 'filter' => $request->input('filter')]);

        return view('content.userside.people.index', compact('user', 'permissionsArray', 'people'));
    }

    /**
     * Show the form for creating a new people.
     */
    public function create()
    {
        $user = Helpers::getUserData();

        $people = People::all();

        return view('content.userside.people.create', compact('user', 'people'));
    }

    /**
     * Store a newly created people in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:64',
            'designation'   => 'string|max:64',
            'email'         => 'required|string|email|max:128|unique:users,email',
            'phone_number'  => 'nullable|string|max:16',
            'address'       => 'nullable|string|max:256',
        ]);

        $data['user_id'] = auth()->user()->id;
        $user = People::create($data);

        return redirect()->route('userside-people')->with('success', 'People created successfully.');
    }

    /**
     * Show the form for editing the specified people.
     */
    public function edit($id)
    {
        $user = Helpers::getUserData();

        $people = People::find($id);

        if (!$people) {
            return redirect()->back()->with('error', 'people not found');
        }

        return view('content.userside.people.edit', compact('user', 'people'));
    }

    /**
     * Update the specified people in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string|max:64',
            'designation'   => 'string|max:64',
            'email'         => 'required|string|email|max:128|unique:users,email,' . $id,
            'phone_number'  => 'nullable|string|max:16',
            'address'       => 'nullable|string|max:256',
        ]);

        $people = People::find($id);

        if (!$people) {
            return redirect()->back()->with('error', 'people not found');
        }

        $people->update($request->all());

        return redirect()->route('userside-people')->with('success', 'People updated successfully.');
    }

    /**
     * Remove the specified people from storage.
     */
    public function delete($id)
    {
        $people = People::find($id);

        if (!$people) {
            return redirect()->back()->with('error', 'people not found');
        }
        $people->delete();

        return redirect()->route('userside-people')->with('success', 'People deleted successfully');
    }

    /**
     * Toggle the status of the specified people.
     */
    public function toggleStatus(Request $request, $id)
    {
        $people = People::find($id);

        if (!$people) {
            return redirect()->back()->with('error', 'people not found');
        }

        $people->is_active = !$people->is_active;

        $people->save();

        return response()->json(['success' => 'People status toggled successfully.']);
    }
}

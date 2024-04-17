<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;

use App\Models\Note;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
  public function index(Request $request)
  {
    $user = Helpers::getUserData();


    $moduleCode = 'NTS';
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

    $notes = Note::query()
      ->when($search, function ($query) use ($search) {
        $query->where('title', 'like', '%' . $search . '%');
      })
      ->paginate(5);
    return view('content.userside.notes.index', compact('user', 'permissionsArray', 'notes', 'filter'));
  }

  public function create()
  {
    $userId = Auth::id();
    // dd($userId);
    $user = Helpers::getUserData();

    $notes = Note::all();

    return view('content.userside.notes.create', compact('user', 'notes', 'userId'));
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'title' => 'required|string|max:64',
      'description' => 'string|max:256',
    ]);

    $data['user_id'] = auth()->user()->id;
    $notes = Note::create($data);

    return redirect()
      ->route('userside-notes')
      ->with('success', 'User created successfully.');
  }

  public function edit($id)
  {
    $user = Helpers::getUserData();

    $userId = Auth::id();

    $notes = Note::findOrFail($id);

    return view('content.userside.notes.edit', compact('user', 'notes', 'userId'));
  }

  /**
   * Update the specified user in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'title' => 'required|string|max:64',
      'description' => 'string|max:256',
    ]);

    $notes = Note::findOrFail($id);

    $notes->update($request->only(['title', 'description']));

    return redirect()
      ->route('userside-notes')
      ->with('success', 'User updated successfully.');
  }

  public function delete($id)
  {
    $notes = Note::findOrFail($id);
    $notes->delete();

    return redirect()
      ->route('userside-notes')
      ->with('success', 'User deleted successfully');
  }
}
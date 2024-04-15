<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
  public function index(Request $request)
  {
    $user = Auth::user();

    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

    // $people = People::all();

    $search = $request->search;
    $filter = $request->filter;

    $notes = Note::query()
      ->when($search, function ($query) use ($search) {
        $query->where('title', 'like', '%' . $search . '%');
      })
      ->when($filter && $filter !== 'all', function ($query) use ($filter) {
        $query->where('is_active', $filter === 'active');
      })
      ->paginate(5);
    return view('content.userside.notes.index', compact('user', 'notes', 'filter'));
  }

  public function create()
  {
    $user = Auth::user();

    $userId = Auth::id();
    // dd($userId);
    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

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
    $user = Auth::user();

    // dd($userId);
    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

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

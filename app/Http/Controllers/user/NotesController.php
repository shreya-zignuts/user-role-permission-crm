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
    $permissionsArray = Auth::user()->getModulePermissions($user, $moduleCode);

    $notes = Note::query()
      ->when($request->filled(['search']), function ($query) use ($request) {
        // Apply search filter if search query is present
        if ($request->filled('search')) {
          $query->where('title', 'like', '%' . $request->input('search') . '%');
        }
      })
      ->paginate(10);

    $notes->appends([$request->filled('search'), $request->filled('filter')]);

    return view('content.userside.notes.index', compact('user', 'permissionsArray', 'notes'));
  }

  public function create()
  {
    $user = Helpers::getUserData();

    $notes = Note::all();

    return view('content.userside.notes.create', compact('user', 'notes'));
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
      ->with('success', 'Note created successfully.');
  }

  public function edit($id)
  {
    $user = Helpers::getUserData();

    $notes = Note::find($id);

    if (!$notes) {
      return redirect()
        ->back()
        ->with('error', 'Note not found');
    }

    return view('content.userside.notes.edit', compact('user', 'notes'));
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

    $notes = Note::find($id);

    if (!$notes) {
      return redirect()
        ->back()
        ->with('error', 'Note not found');
    }

    $notes->update($request->only(['title', 'description']));

    return redirect()
      ->route('userside-notes')
      ->with('success', 'Note updated successfully.');
  }

  public function delete($id)
  {
    $notes = Note::find($id);

    if (!$notes) {
      return redirect()
        ->back()
        ->with('error', 'Note not found');
    }
    $notes->delete();

    return redirect()
      ->route('userside-notes')
      ->with('success', 'Note deleted successfully');
  }
}

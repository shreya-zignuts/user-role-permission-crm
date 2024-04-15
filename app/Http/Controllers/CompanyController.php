<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
  public function index(Request $request)
  {
    $user = Auth::user();

    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

    // $people = People::all();

    $search = $request->search;
    $filter = $request->filter;

    $company = Company::query()
      ->when($search, function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%');
      })
      ->when($filter && $filter !== 'all', function ($query) use ($filter) {
        $query->where('is_active', $filter === 'active');
      })
      ->paginate(5);
    return view('content.userside.company.index', compact('user', 'company', 'filter'));
  }

  public function create()
  {
    $user = Auth::user();

    $userId = Auth::id();
    // dd($userId);
    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

    $company = Company::all();

    return view('content.userside.company.create', compact('user', 'company', 'userId'));
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required|string|max:64',
      'owner_name' => 'string|max:64',
      'industry' => 'string|max:64',
    ]);

    $data['user_id'] = auth()->user()->id;
    $company = Company::create($data);

    return redirect()
      ->route('userside-company')
      ->with('success', 'User created successfully.');
  }

  public function edit($id)
  {
    $user = Auth::user();

    // dd($userId);
    $modules = $user->getModulesWithPermissions();

    $user->modules = $modules;

    $userId = Auth::id();

    $company = Company::findOrFail($id);

    return view('content.userside.company.edit', compact('user', 'company', 'userId'));
  }

  /**
   * Update the specified user in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:64',
      'owner_name' => 'string|max:64',
      'industry' => 'string|max:64',
    ]);

    $company = Company::findOrFail($id);

    $company->update($request->only(['name', 'owner_name', 'industry']));

    return redirect()
      ->route('userside-company')
      ->with('success', 'User updated successfully.');
  }

  public function delete($id)
  {
    $company = Company::findOrFail($id);
    $company->delete();

    return redirect()
      ->route('userside-company')
      ->with('success', 'User deleted successfully');
  }
}

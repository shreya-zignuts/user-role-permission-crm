<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;

use App\Models\Company;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
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

    $company = Company::query()
      ->when($search, function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%');
      })
      ->paginate(5);
    return view('content.userside.company.index', compact('user', 'company', 'permissionsArray', 'filter'));
  }

  public function create()
  {
    $userId = Auth::id();
    // dd($userId);
    $user = Helpers::getUserData();

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
    $user = Helpers::getUserData();

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

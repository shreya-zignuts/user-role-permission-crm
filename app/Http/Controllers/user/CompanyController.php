<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;

use App\Models\Company;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies.
     */
    public function index(Request $request)
    {
        $user = Helpers::getUserData();

        $moduleCode = 'CMP';
        $permissionsArray = Auth::user()->getModulePermissions($user, $moduleCode);

        $company = Company::query()
            ->when($request->filled(['search']), function ($query) use ($request) {
                if ($request->filled('search')) {
                    $query->where('name', 'like', '%' . $request->input('search') . '%');
                }
            })
            ->paginate(5);

        $company->appends([$request->filled('search'), $request->filled('filter')]);

        return view('content.userside.company.index', compact('user', 'company', 'permissionsArray'));
    }

    /**
     * Show the form for creating a new company.
     */
    public function create()
    {
        $user = Helpers::getUserData();

        $company = Company::all();

        return view('content.userside.company.create', compact('user', 'company'));
    }

    /**
     * Store a newly created company in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:64',
            'owner_name'  => 'string|max:64',
            'industry'    => 'string|max:64',
            'address'     => 'string|nullable',
        ]);

        $data['user_id'] = auth()->user()->id;
        $company = Company::create($data);

        return redirect()->route('userside-company')->with('success', 'Company created successfully.');
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit($id)
    {
        $user = Helpers::getUserData();

        $company = Company::find($id);

        if (!$company) {
            return redirect()->back()->with('error', 'Company not found');
        }

        return view('content.userside.company.edit', compact('user', 'company'));
    }

    /**
     * Update the specified company in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:64',
            'owner_name'  => 'string|max:64',
            'industry'    => 'string|max:64',
            'address'     => 'string|nullable',
        ]);

        $company = Company::find($id);

        if (!$company) {
            return redirect()->back()->with('error', 'Company not found');
        }

        $company->update($request->all());

        return redirect()->route('userside-company')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified company from storage.
     */
    public function delete($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return redirect()->back()->with('error', 'Company not found');
        }
        $company->delete();

        return redirect()->route('userside-company')->with('success', 'Company deleted successfully');
    }
}

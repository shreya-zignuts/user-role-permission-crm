@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Roles - Apps')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>

<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/app-access-roles.js')}}"></script>
<script src="{{asset('assets/js/modal-add-role.js')}}"></script>
@endsection

@section('content')

<div class="row justify-content-center mt-3">
  <div class="col-md-4">
    <form method="GET" action="{{ route('pages-permissions') }}">
        @csrf
        <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
          <div class="input-wrapper mb-3 input-group input-group-md input-group-merge" >
              <span class="input-group-text" id="basic-addon1"><i class="ti ti-search"></i></span>
              <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search" aria-describedby="basic-addon1" />
              <button type="submit" class="btn btn-primary">Search</button>
          </div>
      </div>

    </form>
</div>
  <div class="col-md-1">
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Filter
        </button>
        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
            <li><a class="dropdown-item" href="{{ route('pages-permissions') }}">All</a></li>
            <li><a class="dropdown-item" href="{{ route('pages-permissions', ['filter' => 'active']) }}">Active</a></li>
            <li><a class="dropdown-item" href="{{ route('pages-permissions', ['filter' => 'inactive']) }}">Inactive</a></li>
        </ul>
    </div>
</div>

  <div class="col-md-2">
      <a href="{{ route('pages-permissions') }}" class="btn btn-dark">Reset</a>
  </div>
</div>

<div class="card w-100 mt-5">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Permissions</h5>
    <div class="card-body text-end">
      <a href="{{ route('create-permission') }}" class="btn btn-primary">Add New Role</a>
    </div>
  </div>
  <table class="table" style="text-align: center">
    <thead style="background: linear-gradient(to right, rgb(209, 191, 230), #D3CCED); color: white;">
        <tr>
            <th></th>
            <th>Name</th>
            <th>Description</th>
            <th>Is Active</th>
            <th colspan="2">Action</th>
        </tr>
    </thead>
    @foreach ($permissions as $permission)
    <tbody>
      <tr>
        <td></td>
            <td>{{ $permission->name }}</td>
            <td>{{ $permission->description }}</td>
            <td>
              {{-- <form method="GET" action="{{ route('pages-permissions') }}">
                @csrf
                <input type="hidden" name="permission_id" value="{{ $permission->id }}">
                <input type="hidden" name="toggle" value="{{ $permission->is_active ? 'false' : 'true' }}">
                <label class="switch">
                    <input type="checkbox" class="switch-input" name="toggle" {{ $permission->is_active ? 'checked' : '' }} onchange="this.form.submit()">
                    <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                    </span>
                </label>
            </form> --}}

            <form method="GET" action="{{ route('pages-permissions') }}">
              @csrf
              <input type="hidden" name="permission_id" value="{{ $permission->id }}">
              <input type="hidden" name="toggle" value="true">
              <label class="switch">
                  <input type="checkbox" class="switch-input" name="toggle"
                      {{ $permission->is_active ? 'checked' : '' }} onchange="submit()">
                  <span class="switch-toggle-slider">
                      <span class="switch-on"></span>
                      <span class="switch-off"></span>
                  </span>
              </label>
          </form>



            </td>
            <td>edit</td>
            <td>delete</td>
      </tr>
    </tbody>
    @endforeach
</table>
</div>





@endsection

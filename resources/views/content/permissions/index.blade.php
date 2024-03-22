@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Roles - Apps')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/app-access-roles.js') }}"></script>
    <script src="{{ asset('assets/js/modal-add-role.js') }}"></script>
    <script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>
@endsection

@section('content')

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        <script>
            setTimeout(function() {
                document.querySelector('.alert.alert-danger').remove();
            }, 2000); // Remove after 2 seconds
        </script>
    @endif

    @if (session('success'))
        <div class="alert alert-primary">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                document.querySelector('.alert.alert-primary').remove();
            }, 2000); // Remove after 2 seconds
        </script>
    @endif

    <div class="row justify-content-center mt-3">
        <div class="col-md-4">
            <form method="GET" action="{{ route('pages-permissions') }}">
                @csrf
                <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
                    <div class="input-wrapper mb-3 input-group input-group-md input-group-merge">
                        <span class="input-group-text" id="basic-addon1"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search"
                            aria-describedby="basic-addon1" />
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-1">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Filter
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="{{ route('pages-permissions') }}">All</a></li>
                    <li><a class="dropdown-item" href="{{ route('pages-permissions', ['filter' => 'active']) }}">Active</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('pages-permissions', ['filter' => 'inactive']) }}">Inactive</a></li>
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
            <div class="card-body text-end mt-4">
                <a href="{{ route('create-permission') }}" class="btn btn-primary">Add New Permission</a>
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

            @if ($permissions->isEmpty())
                <td colspan="5" class="text-center font-weight-bold">No permission found..</td>
            @else
            <tbody>
                @foreach ($permissions as $permission)

                        <tr>
                            <td></td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->description }}</td>
                            <td>
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
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            href="{{ route('edit-permission', ['id' => $permission->id]) }}"><i
                                                class="ti ti-pencil me-1"></i> Edit</a>
                                        <form id="deletePermissionForm{{ $permission->id }}" method="POST"
                                            action="{{ route('delete-permission', ['id' => $permission->id]) }}">
                                            @csrf
                                            <!-- Delete button trigger modal -->
                                            <button href="#" class="dropdown-item btn btn-submit"
                                                onclick="return confirm('Are you sure you want to delete this permission?')">
                                                <i class="ti ti-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                @endforeach
              </tbody>
            @endif
          </div>
        </div>
  @endsection

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
            <form method="GET" action="{{ route('pages-roles') }}">
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
        <div class="col-md-1 text-center">
          <a href="{{ route('pages-roles') }}" class="btn btn-secondary">Reset</a>
      </div>
      <div class="col-md-4">
          <form action="{{ route('pages-roles') }}" method="GET">
              <div class="input-group">

                  <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon"
                      name="filter">
                      <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All </option>
                      <option value="active" {{ $filter == 'active' ? 'selected' : '' }}>Active</option>
                      <option value="inactive" {{ $filter == 'inactive' ? 'selected' : '' }}>Inactive
                      </option>
                  </select>
                  <button class="btn btn-primary" type="submit">Filter</button>
              </div>
          </form>
      </div>
    </div>

    <div class="card w-100 mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Roles <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="mb-1"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                    <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                </svg></h5>
            <div class="card-body text-end mt-4">
                <a href="{{ route('create-role') }}" class="btn btn-primary">Add New Role</a>
            </div>
        </div>
        <table class="table" style="text-align: center">
            <thead
                style="background: linear-gradient(to right, rgb(209, 191, 230), #D3CCED); color: white; text-align: center">
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Is Active</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            @if ($roles->isEmpty())
                <td colspan="5" class="text-center font-weight-bold" style="color: red">No roles found..</td>
            @else
                <tbody style="text-align: center">
                    @foreach ($roles as $role)
                        <tr>
                            <td></td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->description }}</td>
                            <td>
                                <form action="{{ route('role-status') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="role_id" value="{{ $role->id }}">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" name="is_active" onchange="submit()"
                                            {{ $role->is_active ? 'checked' : '' }}>
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
                                        <a class="dropdown-item" href="{{ route('edit-role', ['id' => $role->id]) }}"><i
                                                class="ti ti-pencil me-1"></i> Edit</a>
                                        <form id="deleteRoleForm{{ $role->id }}" method="POST"
                                            action="{{ route('delete-role', ['id' => $role->id]) }}">
                                            @csrf
                                            <!-- Delete button trigger modal -->
                                            <button class="dropdown-item"
                                                onclick="return confirm('Are you sure you want to delete this role?')">
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
        </table>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Pagination links -->
            {{ $roles->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

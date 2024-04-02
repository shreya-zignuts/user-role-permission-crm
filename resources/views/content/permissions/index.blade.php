@extends('layouts/layoutMaster')

@section('title', 'Selects and tags - Forms')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
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
        <div class="col-md-1 text-center">
          <a href="{{ route('pages-permissions') }}" class="btn btn-secondary">Reset</a>
      </div>
      <div class="col-md-4">
          <form action="{{ route('pages-permissions') }}" method="GET">
              <div class="input-group">

                  <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon"
                      name="filter">
                      <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Permissions</option>
                      <option value="active" {{ $filter == 'active' ? 'selected' : '' }}>Active Permissions</option>
                      <option value="inactive" {{ $filter == 'inactive' ? 'selected' : '' }}>Inactive Permissions
                      </option>
                  </select>
                  <button class="btn btn-primary" type="submit">Filter</button>
              </div>
          </form>
      </div>
    </div>

    <div class="card w-100 mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Permissions <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="mb-1"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                    <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                    <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                </svg></h5>
            <div class="card-body text-end mt-4">
                <a href="{{ route('create-permission') }}" class="btn btn-primary">Add New Permission</a>
            </div>
        </div>
        <table class="table" style="text-align: center">
            <thead style="background: linear-gradient(to right, #9e96f2 22.16%, rgba(133, 123, 245, 0.7) 76.47%);">
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Is Active</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>

            @if ($permissions->isEmpty())
                <td colspan="5" class="text-center font-weight-bold" style="color: red">No permission found..</td>
            @else
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td></td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->description }}</td>
                            <td>
                                <form method="POST" action="{{ route('per-status') }}">
                                    @csrf
                                    <input type="hidden" name="permission_id" value="{{ $permission->id }}">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" name="is_active"
                                            onchange="this.form.submit()" {{ $permission->is_active ? 'checked' : '' }}>
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
                                            <button class="dropdown-item"
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
        </table>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Pagination links -->
            {{ $permissions->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection

@extends('layouts/layoutMaster')

@section('title', 'Selects and tags - Forms')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
    <script src="{{asset('assets/js/app-access-roles.js')}}"></script>
    <script src="{{asset('assets/js/modal-add-role.js')}}"></script>
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
      <form method="GET" action="{{ route('pages-users') }}">
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
              <li><a class="dropdown-item" href="{{ route('pages-users') }}">All</a></li>
              <li><a class="dropdown-item" href="{{ route('pages-users', ['filter' => 'active']) }}">Active</a>
              </li>
              <li><a class="dropdown-item"
                      href="{{ route('pages-users', ['filter' => 'inactive']) }}">Inactive</a></li>
          </ul>
      </div>
  </div>
  <div class="col-md-2">
      <a href="{{ route('pages-users') }}" class="btn btn-dark">Reset</a>
  </div>
</div>
    <div class="card w-100 mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Users</h5>
            <div class="card-body text-end mt-4">
                <a href="{{ route('create-user') }}" class="btn btn-primary">Add New User</a>
            </div>
        </div>
        <table class="table" style="text-align: center">
            <thead
                style="background: linear-gradient(to right, rgb(209, 191, 230), #D3CCED); color: white; text-align: center">
                <tr>
                    <th>Name</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $userCount = 0; @endphp
                @foreach ($users as $user)
                    {{-- Exclude the admin user --}}
                    @if ($user->id !== 1)
                        @php $userCount++; @endphp
                        <tr>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>
                                @if ($user->roles->count() <= 2)
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                @else
                                    @foreach ($user->roles->take(2) as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                    +{{ $user->roles->count() - 2 }}
                                @endif
                            </td>
                            <td>
                              <form action="{{ route('toggle-status') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" name="is_active" onchange="submit()" {{ $user->is_active ? 'checked' : '' }}>
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
                                        href="{{ route('edit-user', ['id' => $user->id]) }}"><i
                                            class="ti ti-pencil me-1"></i> Edit</a>
                                    <form id="deleteRoleForm{{ $user->id }}" method="POST"
                                        action="{{ route('delete-user', ['id' => $user->id]) }}">
                                        @csrf
                                        <!-- Delete button trigger modal -->
                                        <button type="submit" class="dropdown-item text-left"
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="ti ti-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                    {{$user->id}}
                                    <a href="{{ route('reset-password', ['user_id' => $user->id]) }}" data-bs-target="#addRoleModal" data-bs-toggle="modal" class="btn mb-2 text-nowrap dropdown-item"><img src="https://cdn-icons-png.flaticon.com/128/10480/10480728.png" width="20px" alt="">&nbsp; New Password</a>
                                </div>
                            </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                @if ($userCount === 0)
                    <tr>
                        <td colspan="6" class="text-center font-weight-bold" style="color: red">No data found..</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>


    {{-- <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
          <div class="modal-content p-3 p-md-5">
              <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                  <div class="text-center mb-4">
                      <h3 class="role-title mb-2">Set New Password</h3>
                      <p class="text-muted">Set role permissions</p>
                  </div>
                  <form method="POST" action="{{ route('reset-password', $user) }}">
                      @csrf
                      <div class="form-group row">
                          <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
                          <div class="col-md-6">
                              <input id="password" type="password" class="form-control" name="password" required
                                  autocomplete="new-password">
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm
                              Password</label>
                          <div class="col-md-6">
                              <input id="password-confirm" type="password" class="form-control"
                                  name="password_confirmation" required autocomplete="new-password">
                          </div>
                      </div>
                      <div class="form-group row mb-0">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">Reset Password</button>
                          </div>
                      </div>
                  </form>
                  <!--/ Add role form -->
              </div>
          </div>
      </div> --}}
      {{-- <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="role-title mb-2">Set New Password</h3>
                        <p class="text-muted">Set role permissions</p>
                    </div>
                    <form method="POST" action="{{ route('reset-password', $user) }}">
                        @csrf
                        <div class="mb-3 form-password-toggle">
                          <label class="form-label" for="email">for email</label>
                          <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                              required autofocus readonly
                              style="border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem; line-height: 1.5; background-color: #e9ecef; opacity: 1;">
                      </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input id="password" type="password" class="form-control" name="password" required
                                autocomplete="new-password">
                        </div>
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </div>
                    </form>
                    <!--/ Add role form -->
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Set Password Modal for each user -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
      <div class="modal-content p-3 p-md-5">
          <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body">
              <div class="text-center mb-4">
                  <h3 class="role-title mb-2">Set New Password</h3>
                  <p class="text-muted">Set role permissions</p>
              </div>
              <form method="POST" action="{{ route('reset-password', ['user_id' => $user->id]) }}">
                  @csrf
                  {{-- <input type="hidden" name="id" value="{{ $user->id }}" class="form-control">
                  <div class="mb-3 form-password-toggle">
                      <label class="form-label" for="email">for email</label>
                      <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                          required autofocus readonly
                          style="border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem; line-height: 1.5; background-color: #e9ecef; opacity: 1;">
                  </div> --}}
                  <input type="hidden" name="user_id" value="{{ $user->id }}">
                  <div class="mb-3">
                      <label for="password" class="form-label">New Password</label>
                      <input id="password" type="password" class="form-control" name="password" required
                          autocomplete="new-password">
                  </div>
                  <div class="mb-3">
                      <label for="password-confirm" class="form-label">Confirm Password</label>
                      <input id="password-confirm" type="password" class="form-control"
                          name="password_confirmation" required autocomplete="new-password">
                  </div>
                  <div class="text-center">
                      <button type="submit" class="btn btn-primary">Reset Password</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>


  </div>

@endsection

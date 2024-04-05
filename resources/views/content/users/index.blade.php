@extends('layouts/layoutMaster')

@section('title', 'Selects and tags - Forms')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
    <script src="{{ asset('assets/js/app-access-roles.js') }}"></script>
    <script src="{{ asset('assets/js/modal-add-role.js') }}"></script>
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

    @if ($errors && $errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
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
        <div class="col-md-1 text-center">
            <a href="{{ route('pages-users') }}" class="btn btn-secondary">Reset</a>
        </div>
        <div class="col-md-4">
            <form action="{{ route('pages-users') }}" method="GET">
                <div class="input-group">

                    <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon"
                        name="filter">
                        <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Users</option>
                        <option value="active" {{ $filter == 'active' ? 'selected' : '' }}>Active Users</option>
                        <option value="inactive" {{ $filter == 'inactive' ? 'selected' : '' }}>Inactive Users
                        </option>
                    </select>
                    <button class="btn btn-primary" type="submit">Filter</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card w-100 mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Users <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    class="mb-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                </svg></h5>
            <div class="card-body text-end mt-4">
                <a href="{{ route('create-user') }}" class="btn btn-primary">Add New User</a>
            </div>
        </div>
        <table class="table" style="text-align: center">
            <thead
                style="background: linear-gradient(to right, #9e96f2 22.16%, rgba(133, 123, 245, 0.7) 76.47%); text-align: center">
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
                              <form method="get" action="{{ route('per-status', ['id' => $user->id]) }}">
                                @csrf
                                <label class="switch">
                                    <input data-id="{{$user->id}}" class="switch-input" type="checkbox" data-toggle="toggle"
                                    data-onstyle="success" {{$user->is_active?'checked':''}}>
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
                                        <a class="dropdown-item" href="{{ route('edit-user', ['id' => $user->id]) }}"><i
                                                class="ti ti-pencil me-1"></i> Edit</a>
                                        <form id="deleteRoleForm{{ $user->id }}" method="POST"
                                            action="{{ route('delete-user', ['id' => $user->id]) }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-left"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="ti ti-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                        <a href="#" data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                            class="btn text-nowrap dropdown-item reset-password-btn"
                                            data-user-email="{{ $user->email }}"
                                            onclick="setUserDetails('{{ $user->id }}', '{{ $user->email }}')">
                                            <img src="https://cdn-icons-png.flaticon.com/128/10480/10480728.png"
                                                width="20px" alt="">
                                            &nbsp; New Password
                                        </a>
                                        @auth
                                            <form action="{{ route('logout.user', ['id' => $user->id]) }}" method="post">
                                                @csrf

                                                <button type="submit" class="dropdown-item text-left"><img
                                                        src="https://cdn-icons-png.flaticon.com/128/3889/3889524.png"
                                                        width="16px" alt="">&nbsp; Force Logout</button>
                                            </form>
                                        @endauth
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
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="role-title mb-2">Set New Password</h3>
                        <p class="text-muted">Set password for user</p>
                    </div>
                    <form method="POST" action="{{ route('reset-password') }}">
                        @csrf
                        <input type="hidden" name="id" id="userId" class="form-control">
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="userEmail" class="form-control" required autofocus
                                readonly
                                style="border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem; line-height: 1.5; background-color: #e9ecef; opacity: 1;">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Reset Password Mail</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Pagination links -->
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <script>
        function setUserDetails(userId, userEmail) {
            document.getElementById('userId').value = userId;
            document.getElementById('userEmail').value = userEmail;
        }
    </script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>

      $('.switch-input').change(function() {

          var status = $(this).prop('checked') == true ? 1 : 0;
          var id = $(this).data('id');
          $.ajax({

              type: "GET",
              dataType: "json",
              url: "/users/change-status/" + id,
              data: {
                  'status': status,
                  'id': id
              },

              success: function(data) {
                  console.log(data.success)

              }
          });
      })
  </script>
@endsection

@extends('layouts/layoutMaster')

@section('title', 'User - Dashboard')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />

@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/app-access-roles.js') }}"></script>
    <script src="{{ asset('assets/js/modal-add-role.js') }}"></script>
    <script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/ui-toasts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function setUserDetails(userId, userEmail) {
            document.getElementById('userId').value = userId;
            document.getElementById('userEmail').value = userEmail;
        }
    </script>

    {{-- script for toggle switch --}}
    <script>
        $('.switch-input').change(function() {

            var status = $(this).prop('checked') == true ? 1 : 0;
            var id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, toggle it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({

                        type: "GET",
                        dataType: "json",
                        url: "/admin/users/change-status/" + id,
                        data: {
                            'status': status,
                            'id': id
                        },

                        success: function(data) {
                            console.log(data.success)

                            Swal.fire({
                                icon: 'success',
                                title: 'Changed!',
                                text: 'Toggle status for user is changed',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            }).then(function() {
                                window.location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    });
                }
            });


        })
    </script>

    {{-- script for delete sweet alert --}}
    <script>
        $(document).ready(function() {
            $('.delete-user').click(function(e) {
                e.preventDefault();

                var form = $(this).closest('form');
                var id = $(this).data('id');

                // Use SweetAlert for delete confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            data: form.serialize(),
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Your user has been deleted.',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                }).then(function() {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

    {{-- script for force logout user --}}

    <script>
        $(document).ready(function() {
            $('.logout-user').click(function(e) {
                e.preventDefault();

                var form = $(this).closest('form');
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, do it!',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            data: form.serialize(),
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Forcefully Logout !!',
                                    text: 'User has been successfully logged out.',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                }).then(function() {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection

@section('content')

    @if (session('error'))
        <div class="bs-toast toast toast-ex animate__animated animate__tada my-2" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="2000"
            style="position: fixed; top: 20px; right: 20px; width: 300px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="toast-header bg-danger text-white"
                style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <i class="ti ti-bell ti-xs me-2"></i>
                <div class="me-auto fw-semibold">Error</div>
                <?php
                date_default_timezone_set('Asia/Kolkata');
                ?>
                <small class="text-muted"><?= date('h:i A') ?></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" style="padding: 10px; color: #333;">
                {{ session('error') }}
            </div>
        </div>

        <script>
            // Show toast message
            document.addEventListener('DOMContentLoaded', function() {
                var toastEl = document.querySelector('.toast');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        </script>
    @endif

    @if (session('success'))
        <div class="bs-toast toast toast-ex animate__animated animate__tada my-2" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="2000"
            style="position: fixed; top: 20px; right: 20px; width: 300px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="toast-header bg-success text-white"
                style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <i class="ti ti-bell ti-xs me-2"></i>
                <div class="me-auto fw-semibold">Success</div>
                <?php
                date_default_timezone_set('Asia/Kolkata');
                ?>
                <small class="text-muted"><?= date(' h:i A') ?></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" style="padding: 10px; color: #333;">
                {{ session('success') }}
            </div>
        </div>

        <script>
            // Show toast message
            document.addEventListener('DOMContentLoaded', function() {
                var toastEl = document.querySelector('.toast');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
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
        <div class="col-md-6">
            <form method="GET" action="{{ route('pages-users') }}">
                @csrf
                <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
                    <div class="input-wrapper mb-3 input-group input-group-md input-group-merge">
                        <span class="input-group-text" id="basic-addon1"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search"
                            aria-describedby="basic-addon1" value="{{ request()->input('search') }}" />
                        <select class="form-select" id="inputGroupSelect04" name="filter">
                            <option value="all" {{ request()->input('filter') == 'all' ? 'selected' : '' }}>All
                                User</option>
                            <option value="active" {{ request()->input('filter') == 'active' ? 'selected' : '' }}>Active
                                User</option>
                            <option value="inactive" {{ request()->input('filter') == 'inactive' ? 'selected' : '' }}>
                                Inactive User</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Search & Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-1 text-center">
            <form method="GET" action="{{ route('pages-users') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">Reset</button>
            </form>
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
                                    <form method="get" action="{{ route('user-status', ['id' => $user->id]) }}">
                                        @csrf
                                        <label class="switch">
                                            <input data-id="{{ $user->id }}" class="switch-input" type="checkbox"
                                                data-toggle="toggle" data-onstyle="success"
                                                {{ $user->is_active ? 'checked' : '' }}>
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
                                            <form id="deleteUserForm{{ $user->id }}" method="POST"
                                                action="{{ route('delete-user', ['id' => $user->id]) }}">
                                                @csrf
                                                <!-- Delete button trigger modal -->
                                                <button class="dropdown-item delete-user" data-id="{{ $user->id }}">
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

                                            <form id="forceLogoutForm"
                                                action="{{ route('logout.user', ['id' => $user->id]) }}" method="post">
                                                @csrf
                                                <button type="button" class="dropdown-item text-left logout-user">
                                                    <img src="https://cdn-icons-png.flaticon.com/128/3889/3889524.png"
                                                        width="16px" alt="">
                                                    &nbsp; Force Logout
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @if ($userCount === 0)
                        <tr>
                            <td colspan="6" class="text-center font-weight-bold" style="color: red">No data found..
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <!-- Pagination links -->
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
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
                                disabled />
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
                        <div class="pt-4 text-center">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Reset Password Mail</button>
                            <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                                aria-label="Close"><a href="{{ route('pages-users') }}">Cancel</a></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'ActivityLog - Dashboard')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset('assets/js/app-access-roles.js') }}"></script>
    <script src="{{ asset('assets/js/modal-add-role.js') }}"></script>
    <script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/ui-toasts.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    {{-- script for toggle switch --}}
    <script>
        function handleCheckboxChange(id) {
            var checkbox = document.getElementById('toggleSwitch' + id);
            var status = checkbox.checked ? 1 : 0;

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
                        url: "/userside/modules/activityLogs/change-status/" + id,
                        data: {
                            'status': status,
                            'id': id
                        },
                        success: function(data) {
                            console.log(data.success);
                            Swal.fire({
                                icon: 'success',
                                title: 'Changed!',
                                text: 'Toggle status for people is changed',
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
        }

        @foreach ($activityLog as $activity)
            document.getElementById('toggleSwitch{{ $activity->id }}').addEventListener('change', function() {
                handleCheckboxChange({{ $activity->id }});
            });
        @endforeach
    </script>

    {{-- script for delete sweet alert --}}
    <script>
        $(document).ready(function() {
            $('.delete-activityLog').click(function(e) {
                e.preventDefault();

                var form = $(this).closest('form');
                var id = $(this).data('id');

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
                                    text: 'Your activity log has been deleted.',
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

    {{-- Error message using toast --}}
    @if (session('error'))
        <div class="bs-toast toast toast-ex animate__animated animate__tada my-2" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="2000">
            <div class="toast-header">
                <i class="ti ti-bell text-danger ti-xs me-2"></i>
                <div class="me-autofw-semibold">Error</div>
                <small class="text-muted">
                    <?php
                    date_default_timezone_set('Asia/Kolkata');
                    ?>
                    <small class="text-muted"><?= date('h:i A') ?></small>
                </small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
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

    {{-- Success message using toast --}}
    @if (session('success'))
        <div class="bs-toast toast toast-ex animate__animated animate__tada my-2" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="2000">
            <div class="toast-header">
                <i class="ti ti-bell text-success ti-xs me-2"></i>
                <div class="me-auto fw-semibold">Success</div>
                <small class="text-muted">
                    <?php
                    date_default_timezone_set('Asia/Kolkata');
                    ?>
                    <small class="text-muted"><?= date('h:i A') ?></small>
                </small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
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

    {{-- Blade file for activity logs section --}}
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('userside-activityLogs') }}">
                @csrf
                <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
                    <div class="input-wrapper mb-3 input-group input-group-md input-group-merge">
                        <span class="input-group-text" id="basic-addon1"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search"
                            aria-describedby="basic-addon1" value="{{ request()->input('search') }}" />
                        <select class="form-select" id="inputGroupSelect04" name="filter">
                            <option value="all" {{ request()->input('filter') == 'all' ? 'selected' : '' }}>All
                                activityLogs</option>
                            <option value="active" {{ request()->input('filter') == 'active' ? 'selected' : '' }}>Active
                                activityLogs</option>
                            <option value="inactive" {{ request()->input('filter') == 'inactive' ? 'selected' : '' }}>
                                Inactive activityLogs</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Search & Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-1 text-center">
            <form method="GET" action="{{ route('userside-activityLogs') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>
    <div class="card w-100 mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Activity Logs <svg xmlns="http://www.w3.org/2000/svg" class="mb-1" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-notes">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                    <path d="M9 7l6 0" />
                    <path d="M9 11l6 0" />
                    <path d="M9 15l4 0" />
                </svg></h5>
            <div class="card-body text-end mt-4">
                {{-- @dd($peopleModule->pivot->add_access) --}}

                @if ($permissionsArray['add'])
                    <a href="{{ route('create-activityLogs') }}" class="btn btn-primary">Add Activity Log</a>
                @endif
            </div>
        </div>
        <table class="table" style="text-align: center">
            <thead
                style="background: linear-gradient(to right, #9e96f2 22.16%, rgba(133, 123, 245, 0.7) 76.47%); text-align: center">
                <tr>
                    <th>Name</th>
                    <th>Log</th>
                    <th>Status</th>
                    @if ($permissionsArray['edit'] || $permissionsArray['delete'])
                        <th>Actions</th>
                    @else
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($activityLog->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">No data available...</td>
                    </tr>
                @else
                    @foreach ($activityLog as $activity)
                        <tr>
                            <td>{{ $activity->title }}</td>
                            <td data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="tooltip-primary"
                                @if (strlen($activity->log) > 20) title="{{ $activity->log }}" @endif>
                                {{ \Illuminate\Support\Str::limit($activity->log, 20) }}
                            </td>
                            <td>
                                <form method="get"
                                    action="{{ route('activityLogs-status', ['id' => $activity->id]) }}">
                                    @csrf
                                    <label class="switch">
                                        <input data-id="{{ $activity->id }}" id="toggleSwitch{{ $activity->id }}"
                                            class="switch-input" type="checkbox" data-toggle="toggle"
                                            data-onstyle="success" {{ $activity->is_active ? 'checked' : '' }}>
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>
                                </form>
                            </td>
                            <td>
                                @if ($permissionsArray['edit'] || $permissionsArray['delete'])
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <!-- Edit Button based on Access -->
                                            @if ($permissionsArray['edit'])
                                                <a class="dropdown-item"
                                                    href="{{ route('edit-activityLogs', ['id' => $activity->id]) }}">
                                                    <i class="ti ti-pencil me-1"></i> Edit
                                                </a>
                                            @endif
                                            <!-- Delete Button based on Access -->
                                            @if ($permissionsArray['delete'])
                                                <form id="deleteActivityLogForm{{ $activity->id }}" method="POST"
                                                    action="{{ route('delete-activityLogs', ['id' => $activity->id]) }}">
                                                    @csrf
                                                    <!-- Delete button trigger modal -->
                                                    <button class="dropdown-item delete-activityLog"
                                                        data-id="{{ $activity->id }}">
                                                        <i class="ti ti-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <!-- Pagination links -->
            {{ $activityLog->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection

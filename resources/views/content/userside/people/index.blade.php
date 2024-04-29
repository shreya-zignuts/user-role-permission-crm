@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'People - Dashboard')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>

@endsection

@section('page-script')
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
                        url: "/userside/modules/people/change-status/" + id,
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

        @foreach ($people as $person)
            document.getElementById('toggleSwitch{{ $person->id }}').addEventListener('change', function() {
                handleCheckboxChange({{ $person->id }});
            });
        @endforeach
    </script>

    {{-- script for delete sweet alert --}}
    <script>
        $(document).ready(function() {
            $('.delete-person').click(function(e) {
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
                                    text: 'Your people has been deleted.',
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
                <div class="me-auto fw-semibold">Error</div>
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

    {{-- Blade file for people section --}}
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('userside-people') }}">
                @csrf
                <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
                    <div class="input-wrapper mb-3 input-group input-group-md input-group-merge">
                        <span class="input-group-text" id="basic-addon1"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search"
                            aria-describedby="basic-addon1" value="{{ request()->query('search') }}" />
                        <select class="form-select" id="inputGroupSelect04" name="filter">
                            <option value="all" {{ request()->query('filter') == 'all' ? 'selected' : '' }}>All people
                            </option>
                            <option value="active" {{ request()->query('filter') == 'active' ? 'selected' : '' }}>Active
                                people</option>
                            <option value="inactive" {{ request()->query('filter') == 'inactive' ? 'selected' : '' }}>
                                Inactive people</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Search & Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-1 text-center">
            <form method="GET" action="{{ route('userside-people') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>

    <div class="card w-100 mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">People <svg class="mb-1" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                </svg></h5>
            <div class="card-body text-end mt-4">

                @if ($permissionsArray['add'])
                    <a href="{{ route('create-people') }}" class="btn btn-primary">Add People</a>
                @endif
            </div>
        </div>
        <table class="table" style="text-align: center">
            <thead
                style="background: linear-gradient(to right, #9e96f2 22.16%, rgba(133, 123, 245, 0.7) 76.47%); text-align: center">
                <tr>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Address</th>
                    <th>Status</th>
                    @if ($permissionsArray['edit'] || $permissionsArray['delete'])
                        <th>Actions</th>
                    @else
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($people->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">No data available..</td>
                    </tr>
                @else
                    @foreach ($people as $person)
                        <tr>
                            <td>{{ $person->name }}</td>
                            <td>{{ $person->designation }}</td>
                            <td data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="tooltip-primary"
                                @if (strlen($person->address) > 20) title="{{ $person->address }}" @endif>
                                {{ \Illuminate\Support\Str::limit($person->address, 20) }}
                            </td>
                            <td>
                                <form method="get" id="toggleSwitch{{ $person->id }}"
                                    action="{{ route('people-status', ['id' => $person->id]) }}">
                                    @csrf
                                    <label class="switch">
                                        <input data-id="{{ $person->id }}" class="switch-input" type="checkbox"
                                            data-toggle="toggle" data-onstyle="success"
                                            {{ $person->is_active ? 'checked' : '' }}>
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>
                                </form>
                            </td>
                            <td class="text-center">

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
                                                    href="{{ route('edit-people', ['id' => $person->id]) }}">
                                                    <i class="ti ti-pencil me-1"></i> Edit
                                                </a>
                                            @endif
                                            <!-- Delete Button based on Access -->
                                            @if ($permissionsArray['delete'])
                                                <form id="deletePersonForm{{ $person->id }}" method="POST"
                                                    action="{{ route('delete-people', ['id' => $person->id]) }}">
                                                    @csrf
                                                    <!-- Delete button trigger modal -->
                                                    <button class="dropdown-item delete-person"
                                                        data-id="{{ $person->id }}">
                                                        <i class="ti ti-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
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
            {{ $people->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection

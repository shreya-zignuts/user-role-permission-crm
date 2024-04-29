@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Company - Dashboard')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/ui-toasts.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- script for delete sweet alert --}}
    <script>
        $(document).ready(function() {
            $('.delete-company').click(function(e) {
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
                                    text: 'Your company has been deleted.',
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

    {{-- Blade file for company section --}}
    <div class="row justify-content-center mt-3">
        <div class="col-md-4">
            <form method="GET" action="{{ route('userside-company') }}">
                @csrf
                <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
                    <div class="input-wrapper mb-3 input-group input-group-md input-group-merge">
                        <span class="input-group-text" id="basic-addon1"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search"
                            aria-describedby="basic-addon1" value="{{ request()->query('search') }}" />
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-2 text-center">
            <form method="GET" action="{{ route('userside-company') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>

    <div class="card w-100 mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Company <svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-building-factory-2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 21h18" />
                    <path d="M5 21v-12l5 4v-4l5 4h4" />
                    <path d="M19 21v-8l-1.436 -9.574a.5 .5 0 0 0 -.495 -.426h-1.145a.5 .5 0 0 0 -.494 .418l-1.43 8.582" />
                    <path d="M9 17h1" />
                    <path d="M14 17h1" />
                </svg></h5>
            <div class="card-body text-end mt-4">

                @if ($permissionsArray['add'])
                    <a href="{{ route('create-company') }}" class="btn btn-primary">Add Company</a>
                @endif
            </div>
        </div>
        <table class="table" style="text-align: center">
            <thead
                style="background: linear-gradient(to right, #9e96f2 22.16%, rgba(133, 123, 245, 0.7) 76.47%); text-align: center">
                <tr>
                    <th>Name</th>
                    <th>Owner Name</th>
                    <th>Industry</th>
                    <th>Address</th>
                    @if ($permissionsArray['edit'] || $permissionsArray['delete'])
                        <th>Actions</th>
                    @else
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($company->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">No data available..</td>
                    </tr>
                @else
                    @foreach ($company as $comp)
                        <tr>
                            <td>{{ $comp->name }}</td>
                            <td>{{ $comp->owner_name }}</td>
                            <td>{{ $comp->industry }}</td>
                            <td data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="tooltip-primary"
                                @if (strlen($comp->address) > 20) title="{{ $comp->address }}" @endif>
                                {{ \Illuminate\Support\Str::limit($comp->address, 20) }}
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
                                                    href="{{ route('edit-company', ['id' => $comp->id]) }}">
                                                    <i class="ti ti-pencil me-1"></i> Edit
                                                </a>
                                            @endif
                                            <!-- Delete Button based on Access -->
                                            @if ($permissionsArray['delete'])
                                                <form id="deleteCompanyForm{{ $comp->id }}" method="POST"
                                                    action="{{ route('delete-company', ['id' => $comp->id]) }}">
                                                    @csrf
                                                    <!-- Delete button trigger modal -->
                                                    <button class="dropdown-item delete-company"
                                                        data-id="{{ $comp->id }}">
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
            {{ $company->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection

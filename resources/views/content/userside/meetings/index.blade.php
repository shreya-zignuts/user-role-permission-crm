@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Meeting - Dashboard')

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

    {{-- toast message for meeting is over --}}
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
            This Meeting is over, cannot be edited.
        </div>
    </div>

    {{-- script for toast message - for meeting --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.edit-inactive-meeting').click(function(e) {
                e.preventDefault();

                $('.bs-toast').fadeIn();

                setTimeout(function() {
                    $('.bs-toast').fadeOut();
                }, 2500);
            });
        });
    </script>

    {{-- script for delete sweet alert --}}
    <script>
        $(document).ready(function() {
            $('.delete-meeting').click(function(e) {
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
                                    text: 'Your meeting has been deleted.',
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

    {{-- script for toggle switch --}}
    <script>
        $(document).ready(function() {
            $('.switch-input').each(function() {
                var toggleSwitch = $(this);
                var id = $(this).data('id');
                var meetingDate = new Date(toggleSwitch.data('date') + 'T' + toggleSwitch.data('time'));
                var isChecked = toggleSwitch.prop('checked');

                if (meetingDate < new Date() && isChecked) {
                    // Meeting is past and switch is checked, deactivate it
                    toggleSwitch.prop('checked', false); // Uncheck the toggle switch
                    $.ajax({
                        type: "get",
                        dataType: "json",
                        url: toggleSwitch.data('route'),
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'status': '0',
                            'id': id
                        }
                    });
                }

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

    {{-- Blade file for meeting section --}}
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('userside-meetings') }}">
                @csrf
                <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
                    <div class="input-wrapper mb-3 input-group input-group-md input-group-merge">
                        <span class="input-group-text" id="basic-addon1"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search"
                            aria-describedby="basic-addon1" value="{{ request()->query('search') }}" />
                        <select class="form-select" id="inputGroupSelect04" name="filter">
                            <option value="all" {{ request()->query('filter') == 'all' ? 'selected' : '' }}>All meetings
                            </option>
                            <option value="active" {{ request()->query('filter') == 'active' ? 'selected' : '' }}>Active
                                meetings</option>
                            <option value="inactive" {{ request()->query('filter') == 'inactive' ? 'selected' : '' }}>
                                Inactive meetings</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Search & Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-1 text-center">
            <form method="GET" action="{{ route('userside-meetings') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>

    <div class="card w-100 mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Meetings <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
                @if ($permissionsArray['add'])
                    <a href="{{ route('create-meetings') }}" class="btn btn-primary">Add Meeting</a>
                @endif
            </div>
        </div>
        <table class="table" style="text-align: center">
            <thead
                style="background: linear-gradient(to right, #9e96f2 22.16%, rgba(133, 123, 245, 0.7) 76.47%); text-align: center">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    @if ($permissionsArray['edit'] || $permissionsArray['delete'])
                        <th>Actions</th>
                    @else
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($meetings->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No data available...</td>
                    </tr>
                @else
                    @foreach ($meetings as $meeting)
                        <tr>
                            <td>{{ $meeting->title }}</td>
                            <td data-bs-toggle="tooltip" data-bs-placement="bottom"
                                data-bs-custom-class="tooltip-primary"
                                @if (strlen($meeting->description) > 20) title="{{ $meeting->description }}" @endif>
                                {{ \Illuminate\Support\Str::limit($meeting->description, 20) }}
                            </td>
                            <td>{{ $meeting->date }}</td>
                            <td>{{ $meeting->time }}</td>
                            <td>

                                <label class="switch">
                                    <input type="checkbox" class="switch-input" data-id="{{ $meeting->id }}"
                                        {{ $meeting->is_active ? 'checked' : '' }} data-date="{{ $meeting->date }}"
                                        data-time="{{ $meeting->time }}"
                                        data-route="{{ route('meetings-status', ['id' => $meeting->id]) }}"
                                        data-toggle="toggle">
                                    <span class="switch-toggle-slider">
                                        <span class="meetingDate d-none">{{ $meeting->date }}</span>
                                        <span class="meetingTime d-none">{{ $meeting->time }}</span>
                                    </span>
                                </label>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @if ($permissionsArray['edit'] && $meeting->is_active)
                                            <a class="dropdown-item"
                                                href="{{ route('edit-meetings', ['id' => $meeting->id]) }}">
                                                <i class="ti ti-pencil me-1"></i> Edit
                                            </a>
                                        @elseif(!$meeting->is_active)
                                            <div class="dropdown-item edit-inactive-meeting"
                                                data-meeting-id="{{ $meeting->id }}">
                                                <i class="ti ti-pencil me-1"></i> Edit
                                            </div>
                                        @endif
                                        @if ($permissionsArray['delete'])
                                            <form id="deleteMeetingForm{{ $meeting->id }}" method="POST"
                                                action="{{ route('delete-meetings', ['id' => $meeting->id]) }}">
                                                @csrf
                                                <button class="dropdown-item delete-meeting"
                                                    data-id="{{ $meeting->id }}">
                                                    <i class="ti ti-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            {{ $meetings->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection

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
@endsection

@section('content')

@php
            date_default_timezone_set('Asia/Kolkata');
            $toastTime = date('h:i A');
        @endphp

@if (session('error'))
<div class="bs-toast toast toast-ex animate animate__tada my-2" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" style="position: fixed; top: 20px; right: 20px; width: 300px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
  <div class="toast-header bg-danger text-white" style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
      <i class="ti ti-bell ti-xs me-2"></i>
      <div class="me-auto fw-semibold">Error</div>
      <?php
        date_default_timezone_set('Asia/Kolkata');
        ?>
      <small class="text-muted"><?= date('h:i A'); ?></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body" style="padding: 10px; color: #333;">
    {{ session('error') }}
  </div>
</div>

<script>
    // Show toast message
    document.addEventListener('DOMContentLoaded', function () {
        var toastEl = document.querySelector('.toast');
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    });
</script>
@endif

@if (session('success'))
<div class="bs-toast toast toast-ex animate animate__tada my-2" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" style="position: fixed; top: 20px; right: 20px; width: 300px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
  <div class="toast-header bg-success text-white" style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
      <i class="ti ti-bell ti-xs me-2"></i>
      <div class="me-auto fw-semibold">Success</div>
      <?php
        date_default_timezone_set('Asia/Kolkata');
        ?>
      <small class="text-muted"><?= date(' h:i A'); ?></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body" style="padding: 10px; color: #333;">
    {{ session('success') }}
  </div>
</div>

<script>
    // Show toast message
    document.addEventListener('DOMContentLoaded', function () {
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
        <div class="col-md-4">
            <form method="GET" action="{{ route('userside-meetings') }}">
                @csrf
                <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
                    <div class="input-wrapper mb-3 input-group input-group-md input-group-merge">
                        <span class="input-group-text" id="basic-addon1"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search"
                            aria-describedby="basic-addon1" value="{{ request()->input('search') }}"/>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
                <input type="hidden" name="filter" value="{{ request()->input('filter') }}">
            </form>
        </div>
        <div class="col-md-1 text-center">
            <a href="{{ route('userside-meetings') }}" class="btn btn-secondary">Reset</a>
        </div>
        <div class="col-md-4">
            <form action="{{ route('userside-meetings') }}" method="GET">
                <div class="input-group">
                    <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon"
                        name="filter">
                        <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Users</option>
                        <option value="active" {{ $filter == 'active' ? 'selected' : '' }}>Active Users</option>
                        <option value="inactive" {{ $filter == 'inactive' ? 'selected' : '' }}>Inactive Users</option>
                    </select>
                    <button class="btn btn-primary" type="submit">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add New Button based on Access -->
    @php
        $peopleModule = $user->modules->where('code', 'MET')->first();
    @endphp

    <div class="card w-100 mt-5">
      <div class="d-flex justify-content-between align-items-center">
          <h5 class="card-header">People <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
            @if ($peopleModule->pivot->add_access)
            <a href="{{ route('create-meetings')}}" class="btn btn-primary">Add Meeting</a>
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
                                @if($peopleModule->pivot->delete_access || $peopleModule->pivot->edit_access)
                                <th>Actions</th>
                                @else
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meetings as $meeting)
                                <tr>
                                    <td>{{ $meeting->title }}</td>
                                    <td>{{ $meeting->description }}</td>
                                    <td>{{ $meeting->date }}</td>
                                    <td>{{ $meeting->time }}</td>
                                    <td>
                                      <form method="get" action="{{ route('meetings-status', ['id' => $meeting->id]) }}">
                                        @csrf
                                        <label class="switch">
                                            <input data-id="{{$meeting->id}}" class="switch-input" type="checkbox" data-toggle="toggle"
                                            data-onstyle="success" {{$meeting->is_active?'checked':''}}>
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                    </form>
                                    </td>
                                    <td>
                                @if($peopleModule->pivot->delete_access || $peopleModule->pivot->edit_access)
                                      <div class="dropdown">
                                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                              <i class="ti ti-dots-vertical"></i>
                                          </button>
                                          <div class="dropdown-menu">
                                              <!-- Edit Button based on Access -->
                                              @if ($peopleModule->pivot->edit_access)
                                                  <a class="dropdown-item" href="{{ route('edit-meetings', ['id' => $meeting->id]) }}">
                                                      <i class="ti ti-pencil me-1"></i> Edit
                                                  </a>
                                              @endif
                                              <!-- Delete Button based on Access -->
                                              @if ($peopleModule->pivot->delete_access)
                                              <form id="deleteMeetingForm{{ $meeting->id }}" method="POST"
                                                action="{{ route('delete-meetings', ['id' => $meeting->id]) }}">
                                                @csrf
                                                <!-- Delete button trigger modal -->
                                                <button class="dropdown-item delete-meeting" data-id="{{ $meeting->id }}">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
      $(document).ready(function() {
    // Function to update toggle switches based on meeting time
    function updateToggleSwitches() {
        var currentTime = new Date(); // Get current time
        var meetings = {!! json_encode($meetings) !!}; // Meetings data from Blade

        meetings.forEach(function(meeting) {
            var meetingDateTime = new Date(meeting.date + 'T' + meeting.time); // Combine date and time

            // Check if current time is greater than meeting time
            if (currentTime > meetingDateTime) {
                // Update toggle switch to off position visually
                $('[data-id="' + meeting.id + '"].switch-input').prop('checked', false);

                // Send AJAX request to update is_active in the database
                updateMeetingStatus(meeting.id, 0); // Set is_active to 0
            }
        });
    }

    // Call the function when the page loads
    updateToggleSwitches();

    // Add event listener to toggle switches
    $('.switch-input').change(function() {
        var meetingId = $(this).data('id');
        var isActive = $(this).prop('checked') ? 1 : 0; // 1 for checked (active), 0 for unchecked (inactive)

        updateMeetingStatus(meetingId, isActive);
    });

    // Function to update meeting status via AJAX
    function updateMeetingStatus(meetingId, isActive) {
        $.ajax({
            url: '{{ route("meetings-status", ["id" => "__meetingId__"]) }}'.replace('__meetingId__', meetingId),
            method: 'POST',
            data: {
                id: meetingId,
                is_active: isActive,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Meeting status updated successfully.');
            },
            error: function(xhr, status, error) {
                console.error('Error updating meeting status:', error);
            }
        });
    }
});

  </script>
@endsection

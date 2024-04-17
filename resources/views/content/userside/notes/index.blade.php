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
            <form method="GET" action="{{ route('userside-notes') }}">
                @csrf
                <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
                    <div class="input-wrapper mb-3 input-group input-group-md input-group-merge">
                        <span class="input-group-text" id="basic-addon1"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search"
                            aria-describedby="basic-addon1" value="{{ request()->input('search') }}"/>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-1 text-center">
            <a href="{{ route('userside-notes') }}" class="btn btn-secondary">Reset</a>
        </div>
    </div>

    <div class="card w-100 mt-5">
      <div class="d-flex justify-content-between align-items-center">
          <h5 class="card-header">Activity Logs <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
            {{-- @dd($peopleModule->pivot->add_access) --}}

            @if ($permissionsArray['add'])
            <a href="{{ route('create-notes')}}" class="btn btn-primary">Add Notes</a>
        @endif
          </div>
      </div>
      <table class="table" style="text-align: center">
          <thead
              style="background: linear-gradient(to right, #9e96f2 22.16%, rgba(133, 123, 245, 0.7) 76.47%); text-align: center">
              <tr>
                                <th>Name</th>
                                <th>log</th>
                                @if($permissionsArray['edit'] || $permissionsArray['delete'])
                                <th>Actions</th>
                                @else
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notes as $note)
                                <tr>
                                    <td>{{ $note->title }}</td>
                                    <td>{{ $note->description }}</td>
                                    <td>
                                      @if($permissionsArray['edit'] || $permissionsArray['delete'])
                                      <div class="dropdown">
                                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                              <i class="ti ti-dots-vertical"></i>
                                          </button>
                                          <div class="dropdown-menu">
                                              <!-- Edit Button based on Access -->
                                              @if ($permissionsArray['edit'])
                                                  <a class="dropdown-item" href="{{ route('edit-notes', ['id' => $note->id]) }}">
                                                      <i class="ti ti-pencil me-1"></i> Edit
                                                  </a>
                                              @endif
                                              <!-- Delete Button based on Access -->
                                              @if ($permissionsArray['delete'])
                                              <form id="deleteNoteForm{{ $note->id }}" method="POST"
                                                action="{{ route('delete-notes', ['id' => $note->id]) }}">
                                                @csrf
                                                <!-- Delete button trigger modal -->
                                                <button class="dropdown-item delete-note" data-id="{{ $note->id }}">
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
                <div class="row justify-content-center">
                  <div class="col-md-6">
                      <!-- Pagination links -->
                      {{ $notes->links('pagination::bootstrap-5') }}
                  </div>
              </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.delete-note').click(function(e) {
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
                                    text: 'Your note has been deleted.',
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

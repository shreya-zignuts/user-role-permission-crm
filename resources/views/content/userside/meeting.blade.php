@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Page 2')

@section('content')
@extends('layouts/layoutMaster')

@section('title', 'Selects and tags - Forms')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
    <script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>

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


    <div class="row justify-content-center mt-3">
        <div class="col-md-4">
          <form method="GET" action="{{ route('pages-permissions') }}">
            @csrf
            <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
                <div class="input-wrapper mb-3 input-group input-group-md input-group-merge">
                    <span class="input-group-text" id="basic-addon1"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search"
                        aria-describedby="basic-addon1" value="{{ request()->input('search') }}" />
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
            <input type="hidden" name="filter" value="{{ request()->input('filter') }}">
        </form>

        </div>
        <div class="col-md-1 text-center">
            <a href="{{ route('pages-permissions') }}" class="btn btn-secondary">Reset</a>
        </div>
        <div class="col-md-4">
          <form action="{{ route('pages-permissions') }}" method="GET">
            <div class="input-group">
                <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon" name="filter">
                    <option value="all" {{ request()->input('filter') == 'all' ? 'selected' : '' }}>All Permissions</option>
                    <option value="active" {{ (request()->input('filter') == 'active' && request()->input('filter') != null) ? 'selected' : '' }}>Active Permissions</option>
                    <option value="inactive" {{ request()->input('filter') == 'inactive' ? 'selected' : '' }}>Inactive Permissions</option>
                </select>
                <button class="btn btn-primary" type="submit">Filter</button>
            </div>
        </form>

        </div>
    </div>

    <div class="card w-100 mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Permissions <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    class="mb-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-lock">
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
                    <th>Status</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>

                <tbody>
                        <tr>
                            <td></td>
                            <td>1</td>
                            <td>hello</td>
                            <td>hello
                            </td>
                            <td>hello
                            </td>
                        </tr>
                </tbody>
        </table>
    </div>

@endsection

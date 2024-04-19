@extends('layouts/layoutMaster')

@section('Title', 'Selects and tags - Forms')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
@endsection

@section('content')
    <div class="d-flex justify-content-center mt-3">
        <div class="modal-content p-3 p-md-5 w-75 align-content-center mt-5">
            <div class="modal-body">
                @if (session('success'))
                    <div class="bs-toast toast toast-ex animate animate__tada my-2" role="alert" aria-live="assertive"
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
                <h5 class="mt-2">Edit Company <img
                  src="https://cdn-icons-png.freepik.com/256/683/683305.png?semt=ais_hybrid"
                  width="25px" class="mb-1" alt=""></h5>
                <form class="mt-1" method="POST" action="{{ route('update-company', $company->id) }}">
                    @csrf
                    <div class="row g-3">
                        {{-- @dd($activityLog->name) --}}
                        <div class="col-md-12">
                            <label for="title" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control" name="name"
                                value="{{ old('log', $company->name) }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="owner_name" class="form-label">{{ __('Owner Name') }}</label>
                            <input id="owner_name" type="text" class="form-control" name="owner_name"
                                value="{{ old('log', $company->owner_name) }}">
                            @error('owner_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="industry">Industry</label>
                            <textarea id="industry" name="industry" class="form-control" placeholder="industry.. ">{{ old('log', $company->industry) }}</textarea>
                            @error('industry')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="123 Main St">{{ old('address', $company->address) }}</textarea>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                            <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                                aria-label="Close"><a href="{{ route('userside-company') }}">Cancel</a></button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('layouts/layoutMaster')

@section('title', 'Selects and tags - Forms')

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
                <div class="h4">Edit Meeting <img
                  src="https://cdn-icons-png.freepik.com/256/683/683305.png?semt=ais_hybrid"
                  width="25px" class="mb-1" alt=""></div>

                <form method="POST" action="{{ route('update-meetings', $meetings->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">{{ __('Title') }}</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" value="{{ old('title', $meetings->title) }}" required autocomplete="title"
                            autofocus>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"
                            rows="3">{{ old('description', $meetings->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">{{ __('Date') }}</label>
                            <input id="date" type="date" class="form-control @error('date') is-invalid @enderror"
                                name="date" value="{{ old('date', $meetings->date) }}" required>
                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="time" class="form-label">{{ __('Time') }}</label>
                            <input id="time" type="time" class="form-control @error('time') is-invalid @enderror"
                                name="time" value="{{ old('time', $meetings->time) }}" required>
                            @error('time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                            aria-label="Close"><a href="{{ route('userside-meetings') }}">Cancel</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script>
        $(function() {
            $("#date").datepicker({
                minDate: 0, // Restrict to today onwards
                dateFormat: 'yy-mm-dd', // Date format expected by Laravel
                autoclose: true // Optional: Close the datepicker when a date is selected
            });
        });
    </script>
@endsection

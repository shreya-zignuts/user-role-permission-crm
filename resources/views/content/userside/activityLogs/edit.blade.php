@extends('layouts/layoutMaster')

@section('title', 'Edit Activity Log')

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
                @if ($errors && $errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                <h5 class="mt-2">Edit Activity Log <img
                        src="https://cdn-icons-png.freepik.com/256/683/683305.png?semt=ais_hybrid" width="25px"
                        class="mb-1" alt=""></h5>

                <form class="mt-1" method="POST" action="{{ route('update-activityLogs', $activityLog->id) }}">
                    @csrf
                    <div class="row g-3">
                        {{-- @dd($activityLog->title) --}}
                        <div class="col-md-12">
                            <label for="title" class="form-label">Title</label>
                            <input id="title" type="text" class="form-control" name="title"
                                value="{{ old('title', $activityLog->title) }}">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="log">Log</label>
                            <textarea id="log" name="log" class="form-control" placeholder="Log Details..">{{ old('log', $activityLog->log) }}</textarea>
                            @error('log')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="row">
                        <!-- Basic -->
                        <div class="col-md-6 mt-3">
                            <label for="select2Basic" class="form-label">Type</label>
                            <select id="type" name="type" class="form-select" required>
                                <option value="C">Coding</option>
                                <option value="M">Meeting</option>
                                <option value="P">Playing</option>
                                <option value="V">Watching Video</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                        <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                            aria-label="Close"><a href="{{ route('userside-activityLogs') }}">Cancel</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

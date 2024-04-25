@extends('layouts/layoutMaster')

@section('title', 'Edit Meeting')

@section('page-script')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
                <div class="h4">Edit Meeting <img
                        src="https://cdn-icons-png.freepik.com/256/683/683305.png?semt=ais_hybrid" width="25px"
                        class="mb-1" alt=""></div>

                <form method="POST" action="{{ route('update-meetings', $meetings->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">{{ __('Title') }}</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" value="{{ old('title', $meetings->title) }}" autocomplete="title" autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"
                            rows="3">{{ old('description', $meetings->description) }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date</label>
                            <input id="date" type="text" class="form-control @error('date') is-invalid @enderror"
                                name="date" value="{{ old('date', $meetings->date) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="time" class="form-label">{{ __('Time') }}</label>
                            <input id="time" type="time" class="form-control @error('time') is-invalid @enderror"
                                name="time" value="{{ old('time', $meetings->time) }}">
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

    <script>
        $(function() {
            $("#date").datepicker({
                minDate: 0, // Restrict to today onwards
                dateFormat: 'yy-mm-dd', // Date format expected by Laravel
                autoclose: true, // Optional: Close the datepicker when a date is selected
                beforeShow: function(input, inst) {
                    // Display the date format as placeholder when the datepicker is shown
                    $(this).attr("placeholder", "YYYY-MM-DD");
                }
            });
        });
    </script>
@endsection

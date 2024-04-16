@extends('layouts/layoutMaster')

@section('title', 'Selects and tags - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
<script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bloodhound/bloodhound.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/forms-selects.js')}}"></script>
<script src="{{asset('assets/js/forms-tagify.js')}}"></script>
<script src="{{asset('assets/js/forms-typeahead.js')}}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@section('content')
<div class="d-flex justify-content-center mt-3">
  <div class="modal-content p-3 p-md-5 w-75 align-content-center mt-5">
      <div class="modal-body">
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
                    <div class="h4">Create Meeting</div>
                        <form method="POST" action="{{ route('store-meetings') }}">
                            @csrf
                            {{-- <input type="hidden" id="status" name="status" value="{{ old('status', '0') }}"> --}}
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus placeholder="title..">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="3" placeholder="description.."></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row mb-3">
                              <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input id="date" type="text" class="form-control @error('date') is-invalid @enderror" name="date" placeholder="YYYY-MM-DD" required>
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                                <div class="col-md-6">
                                    <label for="time" class="form-label">Time</label>
                                    <input id="time" type="time" class="form-control @error('time') is-invalid @enderror" name="time" value="{{ old('time') }}" required>
                                    @error('time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">{{ __('Save Activity Log') }}</button>
                                <a href="{{ route('userside-meetings') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
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
              autoclose: true, // Optional: Close the datepicker when a date is selected
              beforeShow: function(input, inst) {
                  // Display the date format as placeholder when the datepicker is shown
                  $(this).attr("placeholder", "YYYY-MM-DD");
              }
          });
      });
    </script>

@endsection

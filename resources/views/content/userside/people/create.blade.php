@extends('layouts.layoutMaster')

@section('title', 'Selects and tags - Forms')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
@endsection

@section('content')
    <div class="d-flex justify-content-center mt-3">
        <div class="modal-content p-3 p-md-5 w-75 align-content-center">
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                <div class="bs-toast toast toast-ex animate__animated my-2" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
                  <div class="toast-header">
                    <i class="ti ti-bell ti-xs me-2"></i>
                    <div class="me-auto fw-semibold">Bootstrap</div>
                    <small class="text-muted">11 mins ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                  <div class="toast-body">
                    {{ session('success') }}
                  </div>
                </div>
                @endif
                <h5 class="mt-2 h4">Create People</h5>
                <form class="mt-1" method="POST" action="{{ route('store-people') }}">
                    @csrf
                    <div class="row g-3">
                      <input type="hidden" id="user_id" name="user_id" value="{{ $userId }}">
                        <div class="col-md-6">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="John" />
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="designation">Designation</label>
                          <input type="text" id="designation" name="designation" class="form-control"
                              placeholder="John" />
                          @error('designation')
                              <div class="text-danger">{{ $message }}</div>
                          @enderror
                      </div>
                        <div class="col-md-12">
                            <label class="form-label" for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="123 Main St"></textarea>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-group input-group-merge">
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="john.doe" aria-label="john.doe" aria-describedby="emailSuffix" />
                                <span class="input-group-text" id="emailSuffix">@gmail.com</span>
                            </div>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="phone">Phone No</label>
                            <input type="text" id="phone" name="phone" class="form-control phone-mask"
                                placeholder="123-456-7890" aria-label="123-456-7890" />
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Create</button>
                        <a href="{{ route('userside-people') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

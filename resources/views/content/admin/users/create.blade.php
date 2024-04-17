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
                <h5 class="mt-2">User Management</h5>
                <form class="mt-1" method="POST" action="{{ route('store-user') }}">
                    @csrf
                    <input type="hidden" name="send_invitation_email" value="1">
                    {{-- User Personal Info --}}
                    <h6>User Personal Info</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control"
                                placeholder="John" />
                            @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Doe" />
                            @error('last_name')
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
                        <div class="col-md-12">
                            <label class="form-label" for="roles">Roles</label>
                            @php
                        $activeRolesExist = false;
                    @endphp
                            <select id="roles" name="roles[]" class="selectpicker w-100" data-style="btn-default"
                                multiple data-icon-base="ti" data-tick-icon="ti-check text-white">
                                @foreach ($roles as $role)
                                    @if ($role->is_active)
                                    @php $activeRolesExist = true; @endphp
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @elseif(!$role->is_active)
                                        @endif
                                @endforeach
                            </select>
                            @if (!$activeRolesExist)
                        <div class="alert alert-danger mt-2">
                          <li>No roles are active.</li>
                        </div>
                    @endif

                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Send Invite</button>
                        <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                              aria-label="Close"><a href="{{ route('pages-users')}}">Cancel</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

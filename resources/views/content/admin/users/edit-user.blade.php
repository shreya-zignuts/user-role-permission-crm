@extends('layouts.layoutMaster')

@section('title', 'Edit User')

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
                <h3>Edit User <img
                  src="https://cdn-icons-png.freepik.com/256/683/683305.png?semt=ais_hybrid"
                  width="25px" class="mb-1" alt=""></h3>

                <form method="POST" action="{{ route('update-user', $user->id) }}">
                    @csrf
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label class="form-label" for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="John"
                                value="{{ $user->first_name }}" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Doe"
                                value="{{ $user->last_name }}" />
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="123 Main St">{{ $user->address }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-group input-group-merge">
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="john.doe" aria-label="john.doe" aria-describedby="emailSuffix"
                                    value="{{ $user->email }}" disabled/>
                                <span class="input-group-text" id="emailSuffix">@gmail.com</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="phone">Phone No</label>
                            <input type="text" id="phone" name="phone" class="form-control phone-mask"
                                placeholder="123-456-7890" aria-label="123-456-7890" value="{{ $user->phone }}" />
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="roles">Roles</label>
                            <select id="roles" name="roles[]" class="selectpicker w-100" data-style="btn-default"
                                multiple data-icon-base="ti" data-tick-icon="ti-check text-white">
                                @foreach ($roles as $role)
                                    @if ($role->is_active)
                                        <option value="{{ $role->id }}"
                                            {{ $user->roles->contains($role->id) ? 'selected' : '' }}>{{ $role->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                        <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                            aria-label="Close"><a href="{{ route('pages-users') }}">Cancel</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

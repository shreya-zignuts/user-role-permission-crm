@extends('layouts/layoutMaster')

@section('title', 'Selects and tags - Forms')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/ui-toasts.js') }}"></script>
@endsection

@section('content')
    <div class="d-flex justify-content-center mt-3">
        <div class="modal-content p-3 p-md-5 align-content-center w-50">
            <div class="modal-body">
                <h3 class="text-center mb-4">Create Role <img
                  src="https://img.icons8.com/?size=80&id=lDBdGQL6CHlJ&format=png"
                  width="27px" class="mb-1" alt=""></h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('store-role') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="selectpickerMultiple" class="form-label">Permissions</label>
                        @php
                            $activePermissionsExist = false;
                        @endphp
                        <select id="selectpickerMultiple" name="permissions[]" class="selectpicker w-100"
                            data-style="btn-default" multiple data-icon-base="ti" data-tick-icon="ti-check text-white">
                            @foreach ($permissions as $permission)
                                @if ($permission->is_active)
                                    @php $activePermissionsExist = true; @endphp
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @if (!$activePermissionsExist)
                            <div class="alert alert-danger mt-2">
                                <li>No permissions are active.</li>
                            </div>
                        @endif
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light"
                            id="type-success">Create</button>
                        <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                            aria-label="Close"><a href="{{ route('pages-roles') }}">Cancel</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection

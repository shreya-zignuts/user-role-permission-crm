@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Role - Forms')

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

    <div class="modal-content p-3 p-md-5 w-75 align-content-center">
        <div class="modal-body">
            <h3>Edit Role</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('update-role', $role->id) }}" method="POST">
                @csrf
                <div class="col-md-6 mb-4">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ $role->description }}</textarea>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="selectpickerMultiple" class="form-label">Permissions</label>
                    <select id="selectpickerMultiple" name="permissions[]" class="selectpicker w-100"
                        data-style="btn-default" multiple data-icon-base="ti" data-tick-icon="ti-check text-white">
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission->id }}" {{ $role->permissions->contains($permission->id) ? 'selected' : '' }}>
                                {{ $permission->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Role</button>
            </form>

        </div>
    </div>
@endsection

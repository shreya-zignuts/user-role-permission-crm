<!-- edit-permission.blade.php -->
@extends('layouts.layoutMaster')

@section('title', 'Edit Permission')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>
@endsection


@section('content')
<div class="d-flex justify-content-center mt-3">
    <div class="modal-content p-3 p-md-5 w-75 align-content-center">
        <div class="modal-body">
          <h4 class="mt-1">Edit Permission <img class="mb-1"
            src="data:image/jpeg;base64,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"
            width="30px" alt=""></h4>
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            <form class="row g-3 mt-2" method="POST" action="{{ route('update-permission', ['id' => $permission->id]) }}">
                @csrf
                <div class="col-12 mb-4">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $permission->name }}"
                        placeholder="Enter Permission">
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description">{{ $permission->description }}</textarea>
                </div>
                <div class="col-12">
                    <h5>Module Permissions</h5>
                    <!-- Module permission table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Module / Submodule</th>
                                    <th>Add Access</th>
                                    <th>View Access</th>
                                    <th>Edit Access</th>
                                    <th>Delete Access</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modules as $module)
                                @if ($module->is_active)
                                    <tr>
                                        <td><strong>{{ $module->name }}</strong></td>
                                        <td>
                                            <input type="checkbox" name="add_access_{{ $module->code }}"
                                                value="{{ $module->code }}"
                                                {{ $permission->hasAccess($module->code, 'add') ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="view_access_{{ $module->code }}"
                                                value="{{ $module->code }}"
                                                {{ $permission->hasAccess($module->code, 'view') ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="edit_access_{{ $module->code }}"
                                                value="{{ $module->code }}"
                                                {{ $permission->hasAccess($module->code, 'edit') ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="delete_access_{{ $module->code }}"
                                                value="{{ $module->code }}"
                                                {{ $permission->hasAccess($module->code, 'delete') ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                    <!-- Submodule permissions -->
                                    @foreach ($module->submodules as $submodule)
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $submodule->name }}</td>
                                            <td>
                                                <input type="checkbox" name="add_access_{{ $submodule->code }}"
                                                    value="{{ $submodule->code }}"
                                                    {{ $permission->hasAccess($submodule->code, 'add') ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="view_access_{{ $submodule->code }}"
                                                    value="{{ $submodule->code }}"
                                                    {{ $permission->hasAccess($submodule->code, 'view') ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="edit_access_{{ $submodule->code }}"
                                                    value="{{ $submodule->code }}"
                                                    {{ $permission->hasAccess($submodule->code, 'edit') ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="delete_access_{{ $submodule->code }}"
                                                    value="{{ $submodule->code }}"
                                                    {{ $permission->hasAccess($submodule->code, 'delete') ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Permission table -->
                </div>
                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Update</button>
                    <a href="{{ route('pages-permissions') }}" class="btn btn-label-secondary waves-effect"
                        aria-label="Cancel">Cancel</a>
                </div>
            </form>
            <!-- End of form -->
        </div>
    </div>
</div>
@endsection

<!-- edit-permission.blade.php -->
@extends('layouts.layoutMaster')

@section('title', 'Edit Permission')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/extended-ui-sweetalert2.js')}}"></script>
@endsection


@section('content')
    <div class="modal-content p-3 p-md-5 w-75 align-content-center">
        <div class="modal-body">
            <!-- Form for editing permission -->
            <form class="row g-3" method="POST" action="{{ route('update-permission', ['id' => $permission->id]) }}">
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
                                    <tr>
                                        <td><strong>{{ $module->name }}</strong></td>
                                        <td>
                                            <input type="checkbox" name="add_access_{{ $module->code }}"
                                                value="{{ $module->code }}" {{ $permission->hasAccess($module->code, 'add') ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="view_access_{{ $module->code }}"
                                                value="{{ $module->code }}" {{ $permission->hasAccess($module->code, 'view') ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="edit_access_{{ $module->code }}"
                                                value="{{ $module->code }}" {{ $permission->hasAccess($module->code, 'edit') ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="delete_access_{{ $module->code }}"
                                                value="{{ $module->code }}" {{ $permission->hasAccess($module->code, 'delete') ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                    <!-- Submodule permissions -->
                                    @foreach ($module->submodules as $submodule)
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $submodule->name }}</td>
                                            <td>
                                                <input type="checkbox" name="add_access_{{ $submodule->code }}"
                                                    value="{{ $submodule->code }}" {{ $permission->hasAccess($submodule->code, 'add') ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="view_access_{{ $submodule->code }}"
                                                    value="{{ $submodule->code }}" {{ $permission->hasAccess($submodule->code, 'view') ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="edit_access_{{ $submodule->code }}"
                                                    value="{{ $submodule->code }}" {{ $permission->hasAccess($submodule->code, 'edit') ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="delete_access_{{ $submodule->code }}"
                                                    value="{{ $submodule->code }}" {{ $permission->hasAccess($submodule->code, 'delete') ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
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
@endsection

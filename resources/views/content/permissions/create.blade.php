@extends('layouts.layoutMaster')

@section('title', 'Create Permission')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}">
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/app-access-roles.js') }}"></script>
<script src="{{ asset('assets/js/modal-add-role.js') }}"></script>
@endsection

@section('content')

<div class="modal-content p-3 p-md-5 w-75 align-content-center">
    <div class="modal-body">
        <div class="text-center mb-4">
            <h3 class="role-title mb-2">Create Permission</h3>
            <p class="text-muted">Set permissions for modules</p>
        </div>
        <!-- Add role form -->
        <form class="row g-3" method="POST" action="{{ route('store-permission') }}">
            @csrf
            <div class="col-12 mb-4">
                <label class="form-label" for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Permission">
            </div>
            <div class="col-12 mb-4">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description"></textarea>
            </div>
            <div class="col-12">
                <h5>Permissions</h5>
                <!-- Permission table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Modules</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>View</th>
                                <th>Create</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modules as $module)
                            <tr>
                                <td>
                                    <strong>{{ $module->name }}</strong>
                                </td>
                                <td>
                                    <input type="checkbox" name="edit_{{ $module->code }}" value="edit">
                                </td>
                                <td>
                                    <input type="checkbox" name="delete_{{ $module->code }}" value="delete">
                                </td>
                                <td>
                                    <input type="checkbox" name="view_{{ $module->code }}" value="view">
                                </td>
                                <td>
                                    <input type="checkbox" name="create_{{ $module->code }}" value="create">
                                </td>
                            </tr>
                            @foreach($module->submodules as $submodule)
                            <tr>
                                <td>
                                    &nbsp;&nbsp;&nbsp;&nbsp;{{ $submodule->name }}
                                </td>
                                <td>
                                    <input type="checkbox" name="edit_{{ $submodule->id }}" value="edit">
                                </td>
                                <td>
                                    <input type="checkbox" name="delete_{{ $submodule->id }}" value="delete">
                                </td>
                                <td>
                                    <input type="checkbox" name="view_{{ $submodule->id }}" value="view">
                                </td>
                                <td>
                                    <input type="checkbox" name="create_{{ $submodule->id }}" value="create">
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
                <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Submit</button>
                <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </form>
        <!--/ Add role form -->
    </div>
</div>

@endsection

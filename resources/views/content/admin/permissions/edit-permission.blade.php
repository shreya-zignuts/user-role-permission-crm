@extends('layouts.layoutMaster')

@section('title', 'Edit Permission')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" /> --}}
@endsection

@section('vendor-script')
    {{-- <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script> --}}
@endsection

@section('page-script')
    {{-- <script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script> --}}
@endsection


@section('content')
    <div class="d-flex justify-content-center mt-3">
        <div class="modal-content p-3 p-md-5 w-75 align-content-center">
            <div class="modal-body">
                <h4 class="mt-1">Edit Permission <img
                        src="https://cdn-icons-png.freepik.com/256/683/683305.png?semt=ais_hybrid" width="25px"
                        class="mb-1" alt=""></h4>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                <form class="row g-3 mt-2" method="POST"
                    action="{{ route('update-permission', ['id' => $permission->id]) }}">
                    @csrf
                    <div class="col-12 mb-4">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $permission->name }}" placeholder="Enter Permission">
                    </div>
                    <div class="col-12 mb-4">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description">{{ $permission->description }}</textarea>
                    </div>
                    <div class="col-12">
                        <h5>Module Permissions</h5>
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
                                    <?php
                                    $permissionModules = $permission->modules;
                                    ?>
                                    @foreach ($modules as $module)
                                        <?php
                                        $currentModule = $permissionModules->where('code', $module->code)->first();
                                        $currentModulePermission = $currentModule->pivot;
                                        
                                        // dd($currentModulePermission);
                                        
                                        ?>
                                        <tr data-module-code="{{ $module->code }}">
                                            <td><strong>{{ $module->name }}</strong></td>
                                            <td>
                                                <input type="hidden" name="permissions[{{ $module->code }}][add_access]"
                                                    value="0">
                                                <input type="checkbox"
                                                    class="module-permission-checkbox add-permission-checkbox"
                                                    name="permissions[{{ $module->code }}][add_access]" value="1"
                                                    onclick="checkAccess(this, '{{ $module->code }}', 'add')"
                                                    {{ $currentModulePermission->add_access ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input type="hidden" name="permissions[{{ $module->code }}][view_access]"
                                                    value="0">
                                                <input type="checkbox"
                                                    class="module-permission-checkbox main-module-view-checkbox"
                                                    name="permissions[{{ $module->code }}][view_access]" value="1"
                                                    onclick="checkMainModuleView(this, '{{ $module->code }}', 'view')"
                                                    {{ $currentModulePermission->view_access ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input type="hidden" name="permissions[{{ $module->code }}][edit_access]"
                                                    value="0">
                                                <input type="checkbox"
                                                    class="module-permission-checkbox edit-permission-checkbox"
                                                    name="permissions[{{ $module->code }}][edit_access]" value="1"
                                                    onclick="checkAccess(this, '{{ $module->code }}', 'edit')"
                                                    {{ $currentModulePermission->edit_access ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input type="hidden"
                                                    name="permissions[{{ $module->code }}][delete_access]" value="0">
                                                <input type="checkbox"
                                                    class="module-permission-checkbox delete-permission-checkbox"
                                                    name="permissions[{{ $module->code }}][delete_access]" value="1"
                                                    onclick="checkAccess(this, '{{ $module->code }}', 'delete')"
                                                    {{ $currentModulePermission->delete_access ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                        <!-- Submodule permissions -->
                                        @foreach ($module->submodules as $submodule)
                                            <?php
                                            $currentSubModule = $permissionModules->where('code', $submodule->code)->first();
                                            $currentSubModulePermission = $currentSubModule->pivot;
                                            
                                            // dd($currentModule, $currentSubModule);
                                            
                                            ?>
                                            <tr>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $submodule->name }}</td>
                                                <td>
                                                    <input type="hidden"
                                                        name="permissions[{{ $submodule->code }}][add_access]"
                                                        value="0">
                                                    <input type="checkbox"
                                                        class="module-permission-checkbox add-permission-checkbox"
                                                        name="permissions[{{ $submodule->code }}][add_access]"
                                                        value="1"
                                                        {{ $currentSubModulePermission->add_access ? 'checked' : '' }}
                                                        onclick="checkAccess(this, '{{ $module->code }}', 'add')">
                                                </td>
                                                <td>
                                                    <input type="hidden"
                                                        name="permissions[{{ $submodule->code }}][view_access]"
                                                        value="0">
                                                    <input type="checkbox"
                                                        class="module-permission-checkbox main-module-view-checkbox"
                                                        name="permissions[{{ $submodule->code }}][view_access]"
                                                        value="1"
                                                        {{ $currentSubModulePermission->view_access ? 'checked' : '' }}
                                                        onclick="checkMainModuleView(this, '{{ $module->code }}', 'view')">
                                                </td>
                                                <td>
                                                    <input type="hidden"
                                                        name="permissions[{{ $submodule->code }}][edit_access]"
                                                        value="0">
                                                    <input type="checkbox"
                                                        class="module-permission-checkbox edit-permission-checkbox"
                                                        name="permissions[{{ $submodule->code }}][edit_access]"
                                                        value="1"
                                                        {{ $currentSubModulePermission->edit_access ? 'checked' : '' }}
                                                        onclick="checkAccess(this, '{{ $module->code }}', 'edit')">
                                                </td>
                                                <td>
                                                    <input type="hidden"
                                                        name="permissions[{{ $submodule->code }}][delete_access]"
                                                        value="0">
                                                    <input type="checkbox"
                                                        class="module-permission-checkbox delete-permission-checkbox"
                                                        name="permissions[{{ $submodule->code }}][delete_access]"
                                                        value="1"
                                                        {{ $currentSubModulePermission->delete_access ? 'checked' : '' }}
                                                        onclick="checkAccess(this, '{{ $module->code }}', 'delete')">
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
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light"
                            id="type-success">Update</button>
                        <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                            aria-label="Close"><a href="{{ route('pages-permissions') }}">Cancel</a></button>
                    </div>
                </form>
                <!-- End of form -->
            </div>
        </div>
    </div>

    <script>
        function checkAccess(checkbox, moduleCode, accessType) {
            let parentRow = checkbox.closest('tr');
            let mainModuleRow = parentRow.closest('tbody').querySelector(`[data-module-code="${moduleCode}"]`);
            let viewCheckbox = mainModuleRow.querySelector('.main-module-view-checkbox');
            let addCheckbox = mainModuleRow.querySelector('.add-permission-checkbox');
            let editCheckbox = mainModuleRow.querySelector('.edit-permission-checkbox');
            let deleteCheckbox = mainModuleRow.querySelector('.delete-permission-checkbox');

            let addCheckboxes = parentRow.querySelectorAll('.add-permission-checkbox:checked');
            let editCheckboxes = parentRow.querySelectorAll('.edit-permission-checkbox:checked');
            let deleteCheckboxes = parentRow.querySelectorAll('.delete-permission-checkbox:checked');

            viewCheckbox.checked = addCheckboxes.length > 0 || editCheckboxes.length > 0 || deleteCheckboxes.length > 0 ||
                viewCheckbox.checked;
            addCheckbox.checked = addCheckboxes.length > 0 || addCheckbox.checked;
            editCheckbox.checked = editCheckboxes.length > 0 || editCheckbox.checked;
            deleteCheckbox.checked = deleteCheckboxes.length > 0 || deleteCheckbox.checked;
        }

        function checkMainModuleView(checkbox, moduleCode, accessType) {
            let mainModuleRow = document.querySelector(`[data-module-code="${moduleCode}"]`);
            let viewCheckbox = mainModuleRow.querySelector('.main-module-view-checkbox');
            let addCheckbox = mainModuleRow.querySelector('.add-permission-checkbox');
            let editCheckbox = mainModuleRow.querySelector('.edit-permission-checkbox');
            let deleteCheckbox = mainModuleRow.querySelector('.delete-permission-checkbox');

            if (accessType === 'view') {
                if (checkbox.checked) {
                    viewCheckbox.checked = true;
                }
            } else if (accessType === 'add') {
                addCheckbox.checked = checkbox.checked;
            } else if (accessType === 'edit') {
                editCheckbox.checked = checkbox.checked;
            } else if (accessType === 'delete') {
                deleteCheckbox.checked = checkbox.checked;
            }
        }
    </script>

@endsection

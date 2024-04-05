@extends('layouts.layoutMaster')

@section('title', 'Create Permission')

@section('content')

    <div class="d-flex justify-content-center mt-3">
        <div class="modal-content p-3 p-md-5 w-75">
            <div class="modal-body">
                <h3 class="text-center">Create Permission</h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                <form class="row g-3" method="POST" action="{{ route('store-permission') }}">
                    @csrf
                    <div class="col-12 mb-4">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter Permission">
                    </div>
                    <div class="col-12 mb-4">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description"></textarea>
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
                                    @php $activeModules = false; @endphp
                                    @foreach ($modules as $module)
                                        @if ($module->is_active)
                                            @php $activeModules = true; @endphp
                                            <tr>
                                                <td><strong>{{ $module->name }}</strong></td>
                                                <td>
                                                  <input type="hidden" name="permissions[{{ $module->code }}][add_access]"
                                                        value="0">
                                                    <input type="checkbox" name="permissions[{{ $module->code }}][add_access]"
                                                        value="1">
                                                </td>
                                                <td>
                                                  <input type="hidden" name="permissions[{{ $module->code }}][view_access]"
                                                        value="0">
                                                    <input type="checkbox" name="permissions[{{ $module->code }}][view_access]"
                                                        value="1">
                                                </td>
                                                <td>
                                                  <input type="hidden" name="permissions[{{ $module->code }}][edit_access]"
                                                        value="0">
                                                    <input type="checkbox" name="permissions[{{ $module->code }}][edit_access]"
                                                        value="1">
                                                </td>
                                                <td>
                                                  <input type="hidden" name="permissions[{{ $module->code }}][delete_access]"
                                                        value="0">
                                                    <input type="checkbox" name="permissions[{{ $module->code }}][delete_access]"
                                                        value="1">
                                                </td>
                                            </tr>
                                            <!-- Submodule permissions -->
                                            @foreach ($module->submodules as $submodule)
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $submodule->name }}</td>
                                                    <td>
                                                      <input type="hidden" name="permissions[{{ $submodule->code }}][add_access]"
                                                        value="0">
                                                        <input type="checkbox" name="permissions[{{ $submodule->code }}][add_access]"
                                                            value="1">
                                                    </td>
                                                    <td>
                                                      <input type="hidden" name="permissions[{{ $submodule->code }}][view_access]"
                                                        value="0">
                                                        <input type="checkbox" name="permissions[{{ $submodule->code }}][view_access]"
                                                            value="1">
                                                    </td>
                                                    <td>
                                                      <input type="hidden" name="permissions[{{ $submodule->code }}][edit_access]"
                                                      value="0">
                                                      <input type="checkbox" name="permissions[{{ $submodule->code }}][edit_access]"
                                                          value="1">
                                                    </td>
                                                    <td>
                                                      <input type="hidden" name="permissions[{{ $submodule->code }}][delete_access]"
                                                      value="0">
                                                      <input type="checkbox" name="permissions[{{ $submodule->code }}][delete_access]"
                                                          value="1">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                    @if (!$activeModules)
                                        <tr>
                                            <td colspan="5" class="text-center">No modules are active</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light"
                            id="type-success">Create</button>
                        <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                            aria-label="Close"><a href="{{ route('pages-permissions') }}">Cancel</a></button>
                    </div>
                </form>
                <!-- End of form -->
            </div>
        </div>
    </div>

@endsection

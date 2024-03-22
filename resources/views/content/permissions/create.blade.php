<!-- create-permission.blade.php -->
@extends('layouts.layoutMaster')

@section('title', 'Create Permission')

@section('content')

<div class="modal-content p-3 p-md-5 w-75 align-content-center">
    <div class="modal-body">
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
                          @foreach($modules as $module)
                              @if($module->is_active)
                                  @php $activeModules = true; @endphp
                                  <tr>
                                      <td><strong>{{ $module->name }}</strong></td>
                                      <td>
                                          <input type="checkbox" name="add_access_{{ $module->code }}" value="{{ $module->code }}">
                                      </td>
                                      <td>
                                          <input type="checkbox" name="view_access_{{ $module->code }}" value="{{ $module->code }}">
                                      </td>
                                      <td>
                                          <input type="checkbox" name="edit_access_{{ $module->code }}" value="{{ $module->code }}">
                                      </td>
                                      <td>
                                          <input type="checkbox" name="delete_access_{{ $module->code }}" value="{{ $module->code }}">
                                      </td>
                                  </tr>
                                  <!-- Submodule permissions -->
                                  @foreach ($module->submodules as $submodule)
                                      <tr>
                                          <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $submodule->name }}</td>
                                          <td>
                                              <input type="checkbox" name="add_access_{{ $submodule->code }}" value="{{ $submodule->code }}">
                                          </td>
                                          <td>
                                              <input type="checkbox" name="view_access_{{ $submodule->code }}" value="{{ $submodule->code }}">
                                          </td>
                                          <td>
                                              <input type="checkbox" name="edit_access_{{ $submodule->code }}" value="{{ $submodule->code }}">
                                          </td>
                                          <td>
                                              <input type="checkbox" name="delete_access_{{ $submodule->code }}" value="{{ $submodule->code }}">
                                          </td>
                                      </tr>
                                  @endforeach
                              @endif
                          @endforeach
                          @if (!$activeModules)
                              <tr><td colspan="5" class="text-center">No modules are active</td></tr>
                          @endif
                      </tbody>
                  </table>
              </div>
              <!-- Permission table -->
          </div>

                <!-- Permission table -->
            </div>
            <div class="col-12 text-center mt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="type-success">Create</button>
                <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </form>
        <!-- End of form -->
    </div>
</div>
@endsection

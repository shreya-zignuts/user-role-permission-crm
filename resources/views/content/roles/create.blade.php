@extends('layouts/layoutMaster')

@section('title', 'Selects and tags - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
<script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bloodhound/bloodhound.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/forms-selects.js')}}"></script>
<script src="{{asset('assets/js/forms-tagify.js')}}"></script>
<script src="{{asset('assets/js/forms-typeahead.js')}}"></script>
@endsection

@section('content')

<div class="modal-content p-3 p-md-5 w-75 align-content-center">
    <div class="modal-body">
        <form class="row g-3" method="POST" action="{{ route('store-role') }}">
            @csrf
            <div class="col-12 mb-4">
                <label class="form-label" for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Permission">
            </div>
            <div class="col-12 mb-4">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description"></textarea>
            </div>
            </div>
            <div class="col-12">
                    <div class="col-md-6 mb-4">
                      <label for="select2Multiple" class="form-label">Select Permissions</label>
                        <select class="select2 form-select" name="permissions[]" multiple>
                            @foreach ($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
            {{-- <div class="col-12">
              <h5>Permissions</h5>
              <div class="table-responsive">
                <div class="col-12">
                  <h5>Permissions</h5>
                  <div class="table-responsive">
                    <div class="col-md-6 mb-4">
                        <label for="select2Multiple" class="form-label">Select Permissions</label>
                        <select class="select2 form-select" name="permissions[]" multiple>
                            @foreach ($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

              </div>

            </div>

            <div class="col-12 text-center mt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="type-success">Create</button>
                <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection

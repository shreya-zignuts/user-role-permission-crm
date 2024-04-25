@extends('layouts/layoutMaster')

@section('Title', 'Edit Company')

@section('content')
    <div class="d-flex justify-content-center mt-3">
        <div class="modal-content p-3 p-md-5 w-75 align-content-center mt-5">
            <div class="modal-body">
                @if ($errors && $errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                <h5 class="mt-2">Edit Company <img
                        src="https://cdn-icons-png.freepik.com/256/683/683305.png?semt=ais_hybrid" width="25px"
                        class="mb-1" alt=""></h5>
                <form class="mt-1" method="POST" action="{{ route('update-company', $company->id) }}">
                    @csrf
                    <div class="row g-3">
                        {{-- @dd($activityLog->name) --}}
                        <div class="col-md-12">
                            <label for="title" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control" name="name"
                                value="{{ old('log', $company->name) }}">
                        </div>
                        <div class="col-md-12">
                            <label for="owner_name" class="form-label">{{ __('Owner Name') }}</label>
                            <input id="owner_name" type="text" class="form-control" name="owner_name"
                                value="{{ old('log', $company->owner_name) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="industry">Industry</label>
                            <textarea id="industry" name="industry" class="form-control" placeholder="industry.. ">{{ old('log', $company->industry) }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="123 Main St">{{ old('address', $company->address) }}</textarea>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                            <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                                aria-label="Close"><a href="{{ route('userside-company') }}">Cancel</a></button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

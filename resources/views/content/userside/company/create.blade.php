@extends('layouts/layoutMaster')

@section('Title', 'Create Company')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="modal-content p-3 p-md-5 w-75 align-content-center mt-5">
            <div class="modal-body">

                @if ($errors && $errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                <h5 class="mt-2">Create Company <img src="https://img.icons8.com/?size=80&id=lDBdGQL6CHlJ&format=png"
                        width="27px" class="mb-1" alt=""></h5>
                <form class="mt-1" method="POST" action="{{ route('store-company') }}">
                    @csrf
                    <div class="row g-3">
                        {{-- @dd($activityLog->name) --}}
                        <div class="col-md-12">
                            <label for="title" class="form-label">Name</label>
                            <input id="name" type="text" class="form-control" name="name"
                                placeholder="Enter company name.. ">
                        </div>
                        <div class="col-md-12">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input id="owner_name" type="text" class="form-control" name="owner_name"
                                placeholder="owner name.. ">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="industry">Industry</label>
                            <textarea id="industry" name="industry" class="form-control" placeholder="industry.. "></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="123 Main St"></textarea>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Create</button>
                            <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                                aria-label="Close"><a href="{{ route('userside-company') }}">Cancel</a></button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

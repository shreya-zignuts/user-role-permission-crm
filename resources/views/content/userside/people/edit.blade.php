@extends('layouts.layoutMaster')

@section('title', 'Edit People')

@section('content')
    <div class="d-flex justify-content-center mt-3">
        <div class="modal-content p-3 p-md-5 w-75 align-content-center mt-5">
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h5 class="mt-2">Edit People <img src="https://cdn-icons-png.freepik.com/256/683/683305.png?semt=ais_hybrid"
                        width="25px" class="mb-1" alt=""></h5>
                <form class="mt-1" method="POST" action="{{ route('update-people', $people->id) }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="name">First Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="John"
                                value="{{ old('name', $people->name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="designation">Designation</label>
                            <input type="text" id="designation" name="designation" class="form-control"
                                placeholder="Designation" value="{{ old('designation', $people->designation) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="123 Main St">{{ old('address', $people->address) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-group input-group-merge">
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="john.doe" aria-label="john.doe" aria-describedby="emailSuffix"
                                    value="{{ old('email', $people->email) }}">
                                <span class="input-group-text" id="emailSuffix">@gmail.com</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="phone_number">Phone No</label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control phone-mask"
                                placeholder="123-456-7890" aria-label="123-456-7890"
                                value="{{ old('phone_number', $people->phone_number) }}">
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                        <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                            aria-label="Close"><a href="{{ route('userside-people') }}">Cancel</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

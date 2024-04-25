@extends('layouts.layoutMaster')

@section('title', 'Create People')

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

                <h5 class="mt-2 h4">Create People <img src="https://img.icons8.com/?size=80&id=lDBdGQL6CHlJ&format=png"
                        width="27px" class="mb-1" alt=""></h5>
                <form class="mt-1" method="POST" action="{{ route('store-people') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="John" />
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="designation">Designation</label>
                            <input type="text" id="designation" name="designation" class="form-control"
                                placeholder="John" />
                            @error('designation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="123 Main St"></textarea>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-group input-group-merge">
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="john.doe" aria-label="john.doe" aria-describedby="emailSuffix" />
                                <span class="input-group-text" id="emailSuffix">@gmail.com</span>
                            </div>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="phone">Phone No</label>
                            <input type="text" id="phone" name="phone" class="form-control phone-mask"
                                placeholder="123-456-7890" aria-label="123-456-7890" />
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Create</button>
                <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                    aria-label="Close"><a href="{{ route('userside-people') }}">Cancel</a></button>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection

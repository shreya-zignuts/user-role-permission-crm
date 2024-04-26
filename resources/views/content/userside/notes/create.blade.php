@extends('layouts/layoutMaster')

@section('title', 'Create Note')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="modal-content p-3 p-md-5 w-75 align-content-center mt-5">
            <div class="modal-body">
                @if ($errors && $errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                <h5 class="mt-2 h4">Create Note <img src="https://img.icons8.com/?size=80&id=lDBdGQL6CHlJ&format=png"
                        width="27px" class="mb-1" alt=""></h5>
                <form class="mt-1" method="POST" action="{{ route('store-notes') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="title" class="form-label">Title</label>
                            <input id="title" type="text" class="form-control" name="title" placeholder="Enter note..">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" placeholder="description.. "></textarea>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Create</button>
                            <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                                aria-label="Close"><a href="{{ route('userside-notes') }}">Cancel</a></button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

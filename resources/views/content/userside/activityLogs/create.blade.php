@extends('layouts/layoutMaster')

@section('title', 'Create Activity Log')

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
                <h5 class="mt-2">Create Activity Log <img src="https://img.icons8.com/?size=80&id=lDBdGQL6CHlJ&format=png"
                        width="27px" class="mb-1" alt=""></h5>
                <form class="mt-1" method="POST" action="{{ route('store-activityLogs') }}">
                    @csrf
                    <div class="row g-3">
                        {{-- @dd($activityLog->title) --}}
                        <div class="col-md-12">
                            <label for="title" class="form-label">Title</label>
                            <input id="title" type="text" class="form-control" name="title"
                                placeholder="Enter activity log..">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="log">Log</label>
                            <textarea id="log" name="log" class="form-control" placeholder="Log Details.."></textarea>
                        </div>

                    </div>
                    <div class="row mt-4">
                        <!-- Basic -->
                        <div class="col-md-6 mb-4 w-100">
                            <label for="select2Basic" class="form-label">Type</label>
                            <select id="type" name="type" class="form-select">
                                <option value="C">Coding</option>
                                <option value="M">Meeting</option>
                                <option value="P">Playing</option>
                                <option value="V">Watching Video</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Create</button>
                        <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                            aria-label="Close"><a href="{{ route('userside-activityLogs') }}">Cancel</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

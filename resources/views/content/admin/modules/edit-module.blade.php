@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Module')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
@endsection

@section('content')
<div class="container mt-5"> <!-- Added mt-5 for margin top -->
  <div class="row justify-content-center">
      <div class="col-md-8"> <!-- Adjusted column width to md-8 -->
          <div class="authentication-inner py-4">
              <div class="card w-100">
                  <div class="card-body">
                      <div class="app-brand mb-4 text-center"> <!-- Centered the brand -->
                          <h4 class="mb-1 pt-2">Edit Module <img
                                  src="https://cdn-icons-png.freepik.com/256/683/683305.png?semt=ais_hybrid"
                                  width="25px" class="mb-1" alt=""></h4>
                          @if ($errors->any())
                              <div class="alert alert-danger">
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </div>
                          @endif
                      </div>
                      <form action="{{ route('update-module', ['moduleId' => $module->code]) }}" method="POST">
                          @csrf
                          <div class="mb-3">
                              <label for="moduleName" class="form-label">Module Name</label>
                              <input type="text" class="form-control" id="moduleName" placeholder="Enter module name"
                                  name="name" value="{{ $module->name }}">
                          </div>
                          <div class="mb-3">
                              <label for="moduleDescription" class="form-label">Module Description</label>
                              <input type="text" class="form-control" id="moduleDescription" name="description"
                                  placeholder="Enter module description" value="{{ $module->description }}">
                          </div>
                          <div class="text-center mb-4 mt-0">
                              <button type="submit" id="update" name="update" class="btn btn-primary">Update</button>
                              <a href="{{ route('pages-modules') }}" class="btn btn-secondary">Cancel</a> <!-- Changed to anchor tag within button class -->
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>


@endsection

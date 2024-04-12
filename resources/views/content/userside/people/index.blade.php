{{-- <!-- Add New Permission Button -->
@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Page 2')

@section('content')
@extends('layouts/layoutMaster')

@section('title', 'Selects and tags - Forms')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
    <script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>

@endsection

@section('content')
    <h1>Welcome, {{ $user->name }}!</h1>

    @php
        $peopleModule = $user->modules->where('code', 'ppl')->first();
    @endphp
  {{-- @dd($user->modules->where('code', 'PPL')) --}}
    {{-- @if($peopleModule)
        <div class="module-buttons">
            @if($peopleModule->pivot->add_access)
                <button class="btn btn-primary">Add People</button>
            @endif

            @if($peopleModule->pivot->view_access)
                <button class="btn btn-info">View People</button>
            @endif

            @if($peopleModule->pivot->edit_access)
                <button class="btn btn-warning">Edit People</button>
            @endif

            @if($peopleModule->pivot->delete_access)
                <button class="btn btn-danger">Delete People</button>
            @endif
        </div>
    @else
        <p>You don't have access to the People module.</p>
    @endif
@endsection --}}


@extends('layouts/layoutMaster')

@section('title', 'Cards Statistics- UI elements')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-profile.css') }}" />
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/cards-statistics.js') }}"></script>
    <script src="{{ asset('assets/js/pages-profile.js') }}"></script>

@endsection

@section('content')

    @php
        $imageSrc =
            'https://media.istockphoto.com/id/899347890/vector/online-graphical-report-icon.jpg?s=612x612&w=0&k=20&c=hmd7aTt5jfYbKHXizrqwyq1Gz0VN4Fj-hjvz4_w24qU=';
    @endphp
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">User Profile /</span> Profile
    </h4>

    <!-- Header -->
    @php
    $peopleModule = $user->modules->where('code', 'PPL')->first();
@endphp

    <!-- Add New Button based on Access -->
    @if ($peopleModule->pivot->add_access)
        <a href="#" class="btn btn-primary">Add User</a>
    @endif

    <!-- Table to Display Users -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 w-100">
                <div class="card-body">
                    <table class="table" style="text-align: center">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach($people as $person) --}}
                                <tr>
                                    {{-- <td>{{ $person->name }}</td>
                                    <td>{{ $person->designation }}</td>
                                    <td>{{ $person->address }}</td>
                                    <td>{{ $person->is_active ? 'Active' : 'Inactive' }}</td> --}}
                                    <td>hello</td>
                                    <td>hello</td>
                                    <td>hello</td>
                                    <td>hello</td>
                                    <td>
                                        <!-- Edit Button based on Access -->
                                        @if ($peopleModule->pivot->edit_access)
                                            <a href="#" class="btn btn-primary">Edit Person</a>
                                        @endif
                                        <!-- Delete Button based on Access -->
                                        @if ($peopleModule->pivot->delete_access)
                                        <a href="#" class="btn btn-primary">Delete Person</a>
                                    @endif
                                    </td>
                                </tr>
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- @endforeach --}}

@endsection

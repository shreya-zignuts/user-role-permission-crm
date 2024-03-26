@extends('layouts/layoutMaster')

@section('title', 'Cards basic - UI elements')

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('content')
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@php
    $imageSrc = 'https://media.istockphoto.com/id/899347890/vector/online-graphical-report-icon.jpg?s=612x612&w=0&k=20&c=hmd7aTt5jfYbKHXizrqwyq1Gz0VN4Fj-hjvz4_w24qU=';
@endphp

<div class="row mb-5">
    <div class="col-md">
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                    <img class="card-img card-img-left" src="{{ $imageSrc }}" alt="Card image" />
                </div>
                <div class="col-md-8 main-cards">
                    <div class="card-body">
                        <h5 class="card-title">Modules Count</h5>
                        <div class="module-count-container">
                            <div class="module-count">
                                <span class="count">{{ $activeModuleCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md">
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-8 main-cards">
                    <div class="card-body">
                        <h5 class="card-title">Permission Count</h5>
                        <div class="module-count-container">
                            <div class="module-count">
                                <span class="count">{{ $activePermissionCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <img class="card-img card-img-right" src="{{ $imageSrc }}" alt="Card image" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md">
        <div class="card mb-3 ">
            <div class="row g-0">
                <div class="col-md-4">
                    <img class="card-img card-img-left" src="{{ $imageSrc }}" alt="Card image" />
                </div>
                <div class="col-md-8 main-cards">
                    <div class="card-body">
                        <h5 class="card-title">Roles Count</h5>
                        <div class="module-count-container">
                            <div class="module-count">
                                <span class="count">{{ $activeRolesCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md">
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-8 main-cards">
                    <div class="card-body">
                        <h5 class="card-title">Permission Count</h5>
                        <div class="module-count-container">
                            <div class="module-count">
                                <span class="count">{{ $activePermissionCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <img class="card-img card-img-right" src="{{ $imageSrc }}" alt="Card image" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

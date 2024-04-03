@extends('layouts/layoutMaster')

@section('title', 'Cards Statistics- UI elements')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/cards-statistics.js') }}"></script>
@endsection

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        <script>
            setTimeout(function() {
                document.querySelector('.alert.alert-danger').remove();
            }, 2000); // Remove after 2 seconds
        </script>
    @endif

    @if (session('success'))
        <div class="alert alert-primary">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                document.querySelector('.alert.alert-primary').remove();
            }, 2000); // Remove after 2 seconds
        </script>
    @endif

    @php
        $imageSrc =
            'https://media.istockphoto.com/id/899347890/vector/online-graphical-report-icon.jpg?s=612x612&w=0&k=20&c=hmd7aTt5jfYbKHXizrqwyq1Gz0VN4Fj-hjvz4_w24qU=';
    @endphp
    <div class="row">

        <div class="col-lg-6 col-sm-6 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body pb-0 ">
                    <div class="module-count-container d-flex flex-column align-items-center">
                        <h5 class="card-title mt-5 module-count">23</h5>
                        <div class="mt-2">Modules Count</div>
                    </div>
                </div>
                <div id="subscriberGained"></div>
            </div>
        </div>

        <!-- Quarterly Sales -->
        <div class="col-lg-6 col-sm-6 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body pb-0">
                    <div class="card-icon">
                        <div class="permission-count-container d-flex flex-column align-items-center">
                            <h5 class="card-title mt-5 permission-count">23</h5>
                            <div class="mt-2">Permissions Count</div>
                        </div>
                    </div>
                </div>
                <div id="quarterlySales"></div>
            </div>
        </div>

        <!-- Order Received -->
        <div class="col-lg-6 col-sm-6 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body pb-0">
                    <div class="card-icon">
                        <div class="roles-count-container d-flex flex-column align-items-center">
                            <h5 class="card-title mt-5 roles-count">23</h5>
                            <div class="mt-2">Roles Count</div>
                        </div>
                    </div>
                </div>
                <div id="orderReceived"></div>
            </div>
        </div>

        <!-- Revenue Generated -->
        <div class="col-lg-6 col-sm-6 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body pb-0">
                    <div class="card-icon">
                        <div class="user-count-container d-flex flex-column align-items-center">
                            <h5 class="card-title mt-5 user-count">32</h5>
                            <div class="mt-2">Users Count</div>
                        </div>
                    </div>
                </div>
                <div id="revenueGenerated"></div>
            </div>
        </div>
    </div>
@endsection

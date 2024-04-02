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
                <div class="card-body pb-0">
                    <div class="card-icon">
                        <div class="user-count-container d-flex flex-column align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-hexagons">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 18v-5l4 -2l4 2v5l-4 2z" />
                                <path d="M8 11v-5l4 -2l4 2v5" />
                                <path d="M12 13l4 -2l4 2v5l-4 2l-4 -2" />
                            </svg>


                            <div class="mt-2">Modules Count</div>
                            <h5 class="card-title module-count">{{ $activeModuleCount }}</h5>
                        </div>
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
                        <div class="user-count-container d-flex flex-column align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                                <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                            </svg>


                            <div class="mt-2">Permissions Count</div>
                            <h5 class="card-title permission-count">{{ $activePermissionCount }}</h5>
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
                        <div class="user-count-container d-flex flex-column align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                            </svg>

                            <div class="mt-2">Roles Count</div>
                            <h5 class="card-title roles-count">{{ $activeRolesCount }}</h5>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                            </svg>

                            <div class="mt-2">Users Count</div>
                            <h5 class="card-title user-count">{{ $activeUsersCount }}</h5>
                        </div>
                    </div>
                </div>
                <div id="revenueGenerated"></div>
            </div>
        </div>
    </div>
@endsection

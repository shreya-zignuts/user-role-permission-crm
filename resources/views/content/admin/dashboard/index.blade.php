@extends('layouts/layoutMaster')

@section('title', 'Admin - Dashboard')

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
        <div class="bs-toast toast toast-ex animate__animated animate__tada my-2" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="2000"
            style="position: fixed; top: 20px; right: 20px; width: 300px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="toast-header bg-danger text-white" style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <i class="ti ti-bell ti-xs me-2"></i>
                <div class="me-auto fw-semibold">Error</div>
                <?php
                date_default_timezone_set('Asia/Kolkata');
                ?>
                <small class="text-muted"><?= date('h:i A') ?></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" style="padding: 10px; color: #333;">
                {{ session('error') }}
            </div>
        </div>

        <script>
            // Show toast message
            document.addEventListener('DOMContentLoaded', function() {
                var toastEl = document.querySelector('.toast');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        </script>
    @endif

    @if (session('success'))
        <div class="bs-toast toast toast-ex animate__animated animate__tada my-2" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="2000"
            style="position: fixed; top: 20px; right: 20px; width: 300px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="toast-header bg-success text-white"
                style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <i class="ti ti-bell ti-xs me-2"></i>
                <div class="me-auto fw-semibold">Success</div>
                <?php
                date_default_timezone_set('Asia/Kolkata');
                ?>
                <small class="text-muted"><?= date(' h:i A') ?></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" style="padding: 10px; color: #333;">
                {{ session('success') }}
            </div>
        </div>

        <script>
            // Show toast message
            document.addEventListener('DOMContentLoaded', function() {
                var toastEl = document.querySelector('.toast');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        </script>
    @endif

    @php
        $imageSrc =
            'https://media.istockphoto.com/id/899347890/vector/online-graphical-report-icon.jpg?s=612x612&w=0&k=20&c=hmd7aTt5jfYbKHXizrqwyq1Gz0VN4Fj-hjvz4_w24qU=';
    @endphp

    <div class="row">
        <div class="col-lg-6 col-sm-6 mb-4">
            <div class="card h-px-250 text-center w-px-500">
                <div class="card-body pb-0 mt-4">
                    <div class="card-icon">
                        <div class="user-count-container d-flex flex-column align-items-center">
                            <span class="badge bg-label-primary rounded-pill p-2">
                                <i class='ti ti-hexagons ti-sm'></i>
                            </span>


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
            <div class="card h-px-250 text-center w-px-500">
                <div class="card-body pb-0 mt-4">
                    <div class="card-icon">
                        <div class="user-count-container d-flex flex-column align-items-center">
                            <span class="badge bg-label-danger rounded-pill p-2">
                                <i class='ti ti-lock ti-sm'></i>
                            </span>


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
            <div class="card h-px-250 text-center w-px-500">
                <div class="card-body pb-0 mt-3">
                    <div class="card-icon">
                        <div class="user-count-container d-flex flex-column align-items-center">
                            <span class="badge bg-label-warning rounded-pill p-2">
                                <i class='ti ti-user-circle ti-sm'></i>
                            </span>

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
            <div class="card h-px-250 text-center w-px-500">
                <div class="card-body pb-0 mt-3">
                    <div class="card-icon">
                        <div class="user-count-container d-flex flex-column align-items-center">
                            <span class="badge bg-label-success rounded-pill p-2">
                                <i class='ti ti-users ti-sm'></i>
                            </span>

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

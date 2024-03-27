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
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @php
        $imageSrc =
            'https://media.istockphoto.com/id/899347890/vector/online-graphical-report-icon.jpg?s=612x612&w=0&k=20&c=hmd7aTt5jfYbKHXizrqwyq1Gz0VN4Fj-hjvz4_w24qU=';
    @endphp

    {{-- <div class="row mb-5">
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
</div> --}}
    <div class="row">
        {{-- <div class="col-lg-6 col-sm-6 mb-4">
            <div class="card h-100 w-75 text-center">
                <div class="card-body pb-0 ">
                    <div class="module-count-container">
                        <h5 class="card-title mt-5 module-count">{{ $activeModuleCount }}</h5>
                    </div>
                    <div class="mt-10">Modules Count</div>
                </div>
                <div id="subscriberGained"></div>
            </div>
        </div> --}}
         <div class="col-lg-6 col-sm-6 mb-4">
          <div class="card h-100 text-center">
              <div class="card-body pb-0 ">
                  <div class="module-count-container d-flex flex-column align-items-center">
                      <h5 class="card-title mt-5 module-count">{{ $activeModuleCount }}</h5>
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
                        <h5 class="card-title mt-5 permission-count">{{ $activePermissionCount }}</h5>
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
                        <h5 class="card-title mt-5 roles-count">{{ $activeRolesCount }}</h5>
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
                        <h5 class="card-title mt-5 user-count">{{ $activeUsersCount }}</h5>
                        <div class="mt-2">Users Count</div>
                    </div>
                    </div>
                </div>
                <div id="revenueGenerated"></div>
            </div>
        </div>
    </div>
@endsection

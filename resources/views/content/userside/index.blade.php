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
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 w-100">
                <div class="user-profile-header-banner">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQalBxRsDShn2VxCkK0ReLHxKit4x1zN-Xw1a4SaOKMjw&s"
                        alt="Banner image" class="rounded-top">
                </div>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="https://www.pngitem.com/pimgs/m/248-2483089_ubud-monkey-forest-flat-design-flat-icon-person.png"
                            alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
                    </div>
                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div
                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info">
                                <h4>{{ $user->first_name }}</h4>
                                <ul
                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    <li class="list-inline-item">
                                        <i class='ti ti-color-swatch'></i> UX Designer
                                    </li>
                                    {{-- <li class="list-inline-item">
                      <i class='ti ti-map-pin'></i> {{ $user->address}}
                    </li> --}}

                                    <li class="list-inline-item">
                                        <i class='ti ti-calendar'></i> Joined April 2021
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <a href="{{ route('edit-user-profile', ['id' => $user->id]) }}" class="btn btn-primary">
                                    <i class='ti ti-edit me-1'></i>Edit Profile
                                </a>
                                {{-- <a href="{{ route('edit-user-profile', ['id' => $user->id]) }}" class="btn btn-primary">
                    <i class='ti ti-edit me-1'></i>Edit Password
                  </a> --}}
                                <a href="#" data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                    class="btn text-nowrap btn-primary reset-password-btn"
                                    data-user-email="{{ $user->email }}"
                                    onclick="setUserDetails('{{ $user->id }}', '{{ $user->email }}')">
                                    <i class='ti ti-edit me-1'></i>New Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
  <div class="col-xl-4 col-lg-5 col-md-5">
    <!-- About User -->
    <div class="card mb-4">
      <div class="card-body ">
        <small class="card-text text-uppercase">About</small>
        <ul class="list-unstyled mb-4 mt-3">
          <li class="d-flex align-items-center mb-3"><i class="ti ti-user"></i><span class="fw-bold mx-2">Full Name:</span> <span>{{ $user->first_name }} {{ $user->last_name }}</span></li>
          <li class="d-flex align-items-center mb-3"><i class="ti ti-check"></i><span class="fw-bold mx-2">Status:</span> <span>{{ $user->is_active}}</span></li>
          <li class="d-flex align-items-center mb-3"><i class="ti ti-crown"></i><span class="fw-bold mx-2">Role:</span> <span>Developer</span></li>
          <li class="d-flex align-items-center mb-3"><i class="ti ti-flag"></i><span class="fw-bold mx-2">Country:</span> <span>USA</span></li>
          <li class="d-flex align-items-center mb-3"><i class="ti ti-file-description"></i><span class="fw-bold mx-2">Languages:</span> <span>English</span></li>
        </ul>
        <small class="card-text text-uppercase">Contacts</small>
        <ul class="list-unstyled mb-4 mt-3">
          <li class="d-flex align-items-center mb-3"><i class="ti ti-phone-call"></i><span class="fw-bold mx-2">Contact:</span> <span>{{ $user->phone_number}}</span></li>
          <li class="d-flex align-items-center mb-3"><i class="ti ti-mail"></i><span class="fw-bold mx-2">Email:</span> <span>{{ $user->email}}</span></li>
        </ul>
        <small class="card-text text-uppercase">Teams</small>
        <ul class="list-unstyled mb-0 mt-3">
          <li class="d-flex align-items-center mb-3"><i class="ti ti-brand-angular text-danger me-2"></i>
            <div class="d-flex flex-wrap"><span class="fw-bold me-2">Backend Developer</span><span>(126 Members)</span></div>
          </li>
          <li class="d-flex align-items-center"><i class="ti ti-brand-react-native text-info me-2"></i>
            <div class="d-flex flex-wrap"><span class="fw-bold me-2">React Developer</span><span>(98 Members)</span></div>
          </li>
        </ul>
      </div>
    </div>
  </div>
    <div class="col-xl-8 col-lg-7 col-md-7">
      <!-- Activity Timeline -->
      <div class="card card-action mb-4">
        <div class="card-header align-items-center">
          <h5 class="card-action-title mb-0">Activity Timeline</h5>
          <div class="card-action-element">
            <div class="dropdown">
              <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical text-muted"></i></button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="javascript:void(0);">Share timeline</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card-body pb-0">
          <ul class="timeline ms-1 mb-0">
            <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point timeline-point-primary"></span>
              <div class="timeline-event">
                <div class="timeline-header">
                  <h6 class="mb-0">Client Meeting</h6>
                  <small class="text-muted">Today</small>
                </div>
                <p class="mb-2">Project meeting with john @10:15am</p>
                <div class="d-flex flex-wrap">
                  <div class="avatar me-2">
                    <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Avatar" class="rounded-circle" />
                  </div>
                  <div class="ms-1">
                    <h6 class="mb-0">Lester McCarthy (Client)</h6>
                    <span>CEO of Infibeam</span>
                  </div>
                </div>
              </div>
            </li>
            <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point timeline-point-success"></span>
              <div class="timeline-event">
                <div class="timeline-header">
                  <h6 class="mb-0">Create a new project for client</h6>
                  <small class="text-muted">2 Day Ago</small>
                </div>
                <p class="mb-0">Add files to new design folder</p>
              </div>
            </li>
            <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point timeline-point-danger"></span>
              <div class="timeline-event">
                <div class="timeline-header">
                  <h6 class="mb-0">Shared 2 New Project Files</h6>
                  <small class="text-muted">6 Day Ago</small>
                </div>
                <p class="mb-2">Sent by Mollie Dixon <img src="{{ asset('assets/img/avatars/4.png') }}" class="rounded-circle me-3" alt="avatar" height="24" width="24"></p>
                <div class="d-flex flex-wrap gap-2 pt-1">
                  <a href="javascript:void(0)" class="me-3">
                    <img src="{{asset('assets/img/icons/misc/doc.png') }}" alt="Document image" width="15" class="me-2">
                    <span class="fw-semibold text-heading">App Guidelines</span>
                  </a>
                  <a href="javascript:void(0)">
                    <img src="{{asset('assets/img/icons/misc/xls.png') }}" alt="Excel image" width="15" class="me-2">
                    <span class="fw-semibold text-heading">Testing Results</span>
                  </a>
                </div>
              </div>
            </li>
            <li class="timeline-item timeline-item-transparent border-0">
              <span class="timeline-point timeline-point-info"></span>
              <div class="timeline-event">
                <div class="timeline-header">
                  <h6 class="mb-0">Project status updated</h6>
                  <small class="text-muted">10 Day Ago</small>
                </div>
                <p class="mb-0">Woocommerce iOS App Completed</p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    </div>

    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="role-title mb-2">Set New Password</h3>
                        <p class="text-muted">Set password for user</p>
                    </div>
                    <form method="POST" action="{{ route('user-reset-password') }}">
                        @csrf
                        <input type="hidden" name="id" id="userId" class="form-control">
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="userEmail" class="form-control" required autofocus
                                readonly
                                style="border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem; line-height: 1.5; background-color: #e9ecef; opacity: 1;">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setUserDetails(userId, userEmail) {
            document.getElementById('userId').value = userId;
            document.getElementById('userEmail').value = userEmail;
        }
    </script>

@endsection

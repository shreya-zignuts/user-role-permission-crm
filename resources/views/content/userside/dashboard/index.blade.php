@extends('layouts/layoutMaster')

@section('title', 'User - Dashboard')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-profile.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('page-script')
    {{-- setting user details --}}
    <script>
        function setUserDetails(userId, userEmail) {
            document.getElementById('userId').value = userId;
            document.getElementById('userEmail').value = userEmail;
        }
    </script>

    {{-- UI for quotes --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quoteOverlay = document.getElementById('quoteOverlay');
            quoteOverlay.innerHTML = `<p class="quote-text">${randomQuote}</p>`;
        });
    </script>
@endsection

@section('content')

    {{-- Error message using toast --}}
    @if (session('error'))
        <div class="bs-toast toast toast-ex animate__animated animate__tada my-2" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="2000">
            <div class="toast-header">
                <i class="ti ti-bell text-danger ti-xs me-2"></i>
                <div class="me-auto fw-semibold">Error</div>
                <small class="text-muted">
                    <?php
                    date_default_timezone_set('Asia/Kolkata');
                    ?>
                    <small class="text-muted"><?= date('h:i A') ?></small>
                </small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
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

    {{-- Success message using toast --}}
    @if (session('success'))
        <div class="bs-toast toast toast-ex animate__animated animate__tada my-2" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="2000">
            <div class="toast-header">
                <i class="ti ti-bell text-success ti-xs me-2"></i>
                <div class="me-auto fw-semibold">Success</div>
                <small class="text-muted">
                    <?php
                    date_default_timezone_set('Asia/Kolkata');
                    ?>
                    <small class="text-muted"><?= date('h:i A') ?></small>
                </small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
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

    {{-- Blade file for dashboard --}}

    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card w-100 mt-4">

                <div class="user-profile-header-banner position-relative">
                    <img src="{{ asset('assets/img/pages/userbackground.webp') }}" alt="Banner image" class="rounded-top">
                    <div id="quoteOverlay" class="position-absolute top-50 start-50 translate-middle text-center"
                        style="font-size: 3rem; font-family: 'Segoe UI', sans-serif; color: #c5c3dc; text-shadow: 2px 2px 4px rgba(60, 46, 216, 0.71);">
                        <?php
                        $quotes = ['dream big', 'stay focused', 'never give up', 'work hard', 'believe', 'stay positive', 'keep smiling', 'keep going', 'you got this', 'fearless', 'take risks'];
                        
                        // Select a random quote from the array
                        $randomQuote = $quotes[array_rand($quotes)];
                        echo "<script>const randomQuote = \"$randomQuote\";</script>";
                        ?></div>
                </div>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-3">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="{{ asset('assets/img/avatars/9.png') }}" alt="user image"
                            class="d-block ms-0 ms-sm-4 rounded rounded-circle user-profile-img mt-5 mb-1" height="auto">
                    </div>
                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div
                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info mt-3">
                                <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                                <ul
                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    @php
                                        if ($user->is_active == 1) {
                                            echo '<li class="list-inline-item">
                                  <i class="ti ti-toggle-right mb-1"></i>
                                  <small class="h6"> Active</small></li>';
                                        } else {
                                            echo '<li class="list-inline-item">
                                  <i class="ti ti-toggle-left mb-1"></i> <small class="h6"> Deactive</small>
                              </li>';
                                        }
                                    @endphp

                                </ul>
                            </div>
                            <div>
                                <a href="" data-bs-target="#addProfileModal" data-bs-toggle="modal"
                                    class="btn text-nowrap btn-primary" data-user-email="{{ $user->email }}"
                                    onclick="setUserDetails('{{ $user->id }}', '{{ $user->email }}')">
                                    <i class='ti ti-edit me-1'></i>Edit Profile
                                </a>
                                <a href="" data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                    class="btn text-nowrap btn-primary reset-password-btn ms-2"
                                    data-user-email="{{ $user->email }}"
                                    onclick="setUserDetails('{{ $user->id }}', '{{ $user->email }}')">
                                    <i class='ti ti-lock me-1'></i>Change Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- About User -->
        <div class="col-md-6">
            <div class="card w-100 h-100 mt-2">
                <div class="card-body">
                    <small class="card-text text-uppercase">About</small>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3">
                            <i class="ti ti-user"></i>
                            <span class="fw-bold mx-2">Full Name:</span>
                            <span>{{ $user->first_name }} {{ $user->last_name }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="ti ti-check"></i>
                            <span class="fw-bold mx-2">Status:</span>
                            <span>
                                @if ($user->is_active === 1)
                                    <span class="badge bg-label-success">Active</span>
                                @else
                                    <span class="badge bg-label-danger">Deactive</span>
                                @endif
                            </span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="ti ti-crown"></i>
                            <span class="fw-bold mx-2">Role:</span>
                            <span>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span>{{ $role->name }}@if (!$loop->last)
                                                ,
                                            @endif </span>
                                    @endforeach
                                </td>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Contact User -->
        <div class="col-md-6">
            <div class="card w-100 h-100 mt-2">
                <div class="card-body">
                    <small class="card-text text-uppercase">Contacts</small>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3">
                            <i class="ti ti-phone-call"></i>
                            <span class="fw-bold mx-2">Contact:</span>
                            <span>{{ $user->phone_number }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="ti ti-mail"></i>
                            <span class="fw-bold mx-2">Email:</span>
                            <span>{{ $user->email }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="ti ti-home"></i>
                            <span class="fw-bold mx-2">Address:</span>
                            <span>{{ $user->address }}</span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-11">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="role-title mb-2">Set New Password 🔒</h3>
                        <p class="text-muted">Set your new password</p>
                    </div>
                    <form method="POST" action="{{ route('user-reset-password') }}">
                        @csrf
                        <input type="hidden" name="id" id="userId" class="form-control">
                        <div class="mb-3 form-password-toggle">
                            <input type="hidden" name="email" id="email" class="form-control"
                                value="{{ $user->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="current-password" class="form-label">Current Password</label>
                            <input id="current-password" type="password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                name="current_password" autocomplete="current-password">
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
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('forgot-password-form') }}">
                                <small class="text-decoration-underline mb-5">Forgot Password ??</small>
                            </a>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                            <a href="{{ route('user-dashboard') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addProfileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h3 class="text-center">Edit Proile <img
                            src="https://cdn-icons-png.freepik.com/256/683/683305.png?semt=ais_hybrid" width="25px"
                            class="mb-1" alt=""></h3>

                    <form method="POST" action="{{ route('update-user-profile', $user->id) }}">
                        @csrf
                        {{-- User Personal Info --}}
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="form-label" for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control"
                                    placeholder="John" value="{{ $user->first_name }}" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control"
                                    placeholder="Doe" value="{{ $user->last_name }}" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="address">Address</label>
                                <textarea id="address" name="address" class="form-control" placeholder="123 Main St">{{ $user->address }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <div class="input-group input-group-merge">
                                    <input type="email" id="EmailReadOnly" name="email" class="form-control"
                                        placeholder="john.doe" aria-label="john.doe" aria-describedby="emailSuffix"
                                        value="{{ $user->email }}" disabled />
                                    <span class="input-group-text" id="emailSuffix">@gmail.com</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">Phone No</label>
                                <input type="text" id="phone_number" name="phone_number"
                                    class="form-control phone-mask" placeholder="123-456-7890" aria-label="123-456-7890"
                                    value="{{ $user->phone_number }}" />
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <button class="btn btn-primary">Update</button>
                            <a href="{{ route('user-dashboard') }}" class="btn btn-label-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

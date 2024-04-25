@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
@endsection

@section('page-style')
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

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">


                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        @if (session('error'))
                            <div class="bs-toast toast toast-ex animate__animated animate__tada my-2" role="alert"
                                aria-live="assertive" aria-atomic="true" data-bs-delay="2000"
                                style="position: fixed; top: 20px; right: 20px; width: 300px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                <div class="toast-header bg-danger text-white"
                                    style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
                                    <i class="ti ti-bell ti-xs me-2"></i>
                                    <div class="me-auto fw-semibold">Error</div>
                                    <?php
                                    date_default_timezone_set('Asia/Kolkata');
                                    ?>
                                    <small class="text-muted"><?= date('h:i A') ?></small>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast"
                                        aria-label="Close"></button>
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
                            <div class="bs-toast toast toast-ex animate__animated animate__tada my-2" role="alert"
                                aria-live="assertive" aria-atomic="true" data-bs-delay="2000"
                                style="position: fixed; top: 20px; right: 20px; width: 300px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                <div class="toast-header bg-success text-white"
                                    style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
                                    <i class="ti ti-bell ti-xs me-2"></i>
                                    <div class="me-auto fw-semibold">Success</div>
                                    <?php
                                    date_default_timezone_set('Asia/Kolkata');
                                    ?>
                                    <small class="text-muted"><?= date(' h:i A') ?></small>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast"
                                        aria-label="Close"></button>
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

                        @if ($errors->any())
                            <div class="alert alert-danger text-center">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 20, 'withbg' => 'fill: #fff;'])</span>
                                <span
                                    class="app-brand-text demo text-body fw-bold ms-1">{{ config('variables.templateName') }}</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2">Welcome to {{ config('variables.templateName') }}! 👋</h4>
                        <p class="mb-4">Please sign-in to your account and start the adventure</p>

                        <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email or username" value="{{ Cookie::get('remember_email') }}"
                                    autofocus>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="{{ route('forgot-password-form') }}">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        value="{{ Cookie::get('remember_password') }}"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                        {{ $rememberChecked ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                        <!-- /Register -->
                    </div>
                </div>
            </div>


        @endsection

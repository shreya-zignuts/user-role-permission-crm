@extends('layouts/layoutMaster')

@section('title', 'Module - Dashboard')

@section('content')
    <!-- Search form -->

    @if (session('error'))
        <div class="bs-toast toast toast-ex animate animate__tada my-2" role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-delay="2000"
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
        <div class="bs-toast toast toast-ex animate animate__tada my-2" role="alert" aria-live="assertive"
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
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('pages-modules') }}">
                @csrf
                <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
                    <div class="input-wrapper mb-3 input-group input-group-md input-group-merge">
                        <span class="input-group-text" id="basic-addon1"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search"
                            aria-describedby="basic-addon1" value="{{ request()->query('search') }}" />
                        <select class="form-select" id="inputGroupSelect04" name="filter">
                            <option value="all" {{ request()->query('filter') == 'all' ? 'selected' : '' }}>All Modules
                            </option>
                            <option value="active" {{ request()->query('filter') == 'active' ? 'selected' : '' }}>Active
                                Modules</option>
                            <option value="inactive" {{ request()->query('filter') == 'inactive' ? 'selected' : '' }}>
                                Inactive Modules</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Search & Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-1 text-center">
            <form method="GET" action="{{ route('pages-modules') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>

    <div class="card w-100 mt-5">
        <h5 class="card-header">Modules <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="mb-1"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-hexagons">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 18v-5l4 -2l4 2v5l-4 2z" />
                <path d="M8 11v-5l4 -2l4 2v5" />
                <path d="M12 13l4 -2l4 2v5l-4 2l-4 -2" />
            </svg></h5>
        <div class="table-responsive text-nowrap">
            <table class="table" style="text-align: center">
                <thead style="background: linear-gradient(to right, #9e96f2 22.16%, rgba(133, 123, 245, 0.7) 76.47%);">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                @if ($modules->isEmpty())
                    <td colspan="5" class="text-center font-weight-bold" style="color: red">No modules found..</td>
                @else
                    @foreach ($modules as $module)
                        <tr>
                            <td>
                                <button class="btn btn-default btn-xs clickable" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#module_{{ $module->code }}" aria-expanded="false"
                                    aria-controls="module_{{ $module->code }}">
                                    <img src="https://cdn-icons-png.flaticon.com/128/8567/8567254.png" width="20px"
                                        alt="">
                                </button>
                            </td>
                            <td>{{ $module->name }}</td>
                            <td>{{ $module->description }}</td>
                            <td>
                                <form method="POST" action="{{ route('module-status', ['moduleId' => $module->code]) }}">
                                    @csrf
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" name="is_active"
                                            {{ $module->is_active ? 'checked' : '' }}>
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>
                                </form>
                            </td>
                            <td><a href="{{ route('edit-module', ['moduleId' => $module->code]) }}"><img
                                        src="https://cdn-icons-png.flaticon.com/512/6543/6543495.png" width="30px"
                                        alt=""></a></td>
                        </tr>

                        <tr>
                            <td colspan="5" class="collapse" id="module_{{ $module->code }}">
                                <table class="table">
                                    <thead class="table-active">
                                        <tr style="text-align: center">
                                            {{-- <th></th> --}}
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if ($module->is_active && $module->submodules->where('is_active', true)->isEmpty() && $module->submodules->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center font-weight-bold">No active submodules for this module.</td>
                    </tr>
                @endif
                                        @foreach ($module->submodules as $submodule)
                                            <tr style="text-align: center">
                                                <td>{{ $submodule->name }}</td>
                                                <td>{{ $submodule->description }}</td>
                                                <td>
                                                    <form method="get"
                                                        action="{{ route('module-status', ['moduleId' => $submodule->code]) }}">
                                                        @csrf
                                                        <label class="switch">
                                                            <input data-id="{{ $submodule->code }}"
                                                                class="toggle-class switch-input" type="checkbox"
                                                                name="is_active" data-toggle="toggle"
                                                                data-onstyle="success"
                                                                {{ $module->is_active && $submodule->is_active ? 'checked' : '' }}>
                                                            <span class="switch-toggle-slider">
                                                                <span class="switch-on"></span>
                                                                <span class="switch-off"></span>
                                                            </span>
                                                        </label>
                                                    </form>
                                                </td>
                                                <td><a
                                                        href="{{ route('edit-module', ['moduleId' => $submodule->code]) }}"><img
                                                            src="https://cdn-icons-png.flaticon.com/512/6543/6543495.png"
                                                            width="30px" alt=""></a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    {{-- script for toggle switch --}}
    <script>
        $('.switch-input').change(function() {
            var status = $(this).prop('checked') ? 1 : 0;
            var id = $(this).closest('form').attr('action').split('/')
                .pop(); // Get the module ID from the form action URL

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, toggle it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({

                        type: "GET",
                        dataType: "json",
                        url: "/admin/modules/change-status/" + id,
                        data: {
                            'is_active': status
                        },

                        success: function(data) {
                            console.log(data.success)

                            Swal.fire({
                                icon: 'success',
                                title: 'Changed!',
                                text: 'Toggle status for modules is changed',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            }).then(function() {
                                window.location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection

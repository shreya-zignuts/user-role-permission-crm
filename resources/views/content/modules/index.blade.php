@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')

@section('content')
    <!-- Search form -->

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

    <div class="row justify-content-center mt-3">
        <div class="col-md-4">
            <form method="GET" action="{{ route('pages-modules') }}">
                @csrf
                <div class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
                    <div class="input-wrapper mb-3 input-group input-group-md input-group-merge">
                        <span class="input-group-text" id="basic-addon1"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search"
                            aria-describedby="basic-addon1" />
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>

            </form>
        </div>
        <div class="col-md-1 text-center">
            <a href="{{ route('pages-modules') }}" class="btn btn-secondary">Reset</a>
        </div>
        <div class="col-md-4">
            <form action="{{ route('pages-modules') }}" method="GET">
                <div class="input-group">

                    <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon"
                        name="filter">
                        <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Modules</option>
                        <option value="active" {{ $filter == 'active' ? 'selected' : '' }}>Active Modules</option>
                        <option value="inactive" {{ $filter == 'inactive' ? 'selected' : '' }}>Inactive Modules
                        </option>
                    </select>
                    <button class="btn btn-primary" type="submit">Filter</button>
                </div>
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
                                <form method="POST" action="{{ route('module-status') }}">
                                    @csrf
                                    <input type="hidden" name="module_code" value="{{ $module->code }}">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" name="is_active"
                                            onchange="this.form.submit()" {{ $module->is_active ? 'checked' : '' }}>
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
                                        @foreach ($module->submodules as $submodule)
                                            <tr style="text-align: center">
                                                <td>{{ $submodule->name }}</td>
                                                <td>{{ $submodule->description }}</td>
                                                <td>
                                                    <form method="GET" action="{{ route('pages-modules') }}">
                                                        @csrf
                                                        <input type="hidden" name="module_code"
                                                            value="{{ $submodule->code }}">
                                                        <input type="hidden" name="toggle" value="true">
                                                        <label class="switch">
                                                            <input type="checkbox" class="switch-input" name="toggle"
                                                                {{ $module->is_active && $submodule->is_active ? 'checked' : '' }}
                                                                onchange="submit()">
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
    <div class="row justify-content-center">
        <div class="col-md-6">
            {{ $modules->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

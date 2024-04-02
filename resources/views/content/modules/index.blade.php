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
                <thead style="background: linear-gradient(to right, rgb(209, 191, 230), #D3CCED); color: white;">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Is Active</th>
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
                                        src="https://cdn-icons-png.flaticon.com/128/10336/10336582.png" width="30px"
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
                                            <th>Is Active</th>
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
                                                            src="data:image/jpeg;base64,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"
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

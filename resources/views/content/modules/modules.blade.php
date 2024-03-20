@extends('layouts/layoutMaster')

@section('title', 'Modules')

@section('content')
<!-- Search form -->
<div class="row justify-content-center mt-3">
    <div class="col-md-4">
        <form method="GET" action="{{ route('pages-modules') }}">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search...">
                <button type="submit" class="btn btn-dark">Search</button>
                <a href="{{ route('pages-modules') }}" class="btn btn-secondary">Reset</a> <!-- Reset button -->
            </div>
        </form>
    </div>
    <div class="col-md-4">
      <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              Filter
          </button>
          <ul class="dropdown-menu" aria-labelledby="filterDropdown">
              <li><a class="dropdown-item" href="{{ route('pages-modules') }}">All</a></li>
              <li><a class="dropdown-item" href="{{ route('pages-modules', ['filter' => 'active']) }}">Active</a></li>
              <li><a class="dropdown-item" href="{{ route('pages-modules', ['filter' => 'inactive']) }}">Inactive</a></li>
          </ul>
      </div>
  </div>
</div>
<div class="container text-center">
    <div class="col-md-12">
        <div class="panel panel-default mt-5">
            <div class="panel-body">
                <table class="table table-border">
                    <thead style="background: linear-gradient(to right, rgb(155, 147, 243), #CBB2E0); color: white;" class="p-2 bg-opacity-75">
                        <tr>
                          <th></th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modules as $module)
                            <tr data-bs-toggle="collapse" data-bs-target="#module_{{ $module->code }}"
                                aria-expanded="false" aria-controls="module_{{ $module->code }}">
                                <td><button class="btn btn-default btn-xs clickable"><img src="https://cdn-icons-png.flaticon.com/128/8567/8567254.png" width="20px" alt=""></button></td>
                                <td>{{ $module->name }}</td>
                                <td>{{ $module->description }}</td>
                                <td>
                                  <form method="get" action="{{ route('pages-modules') }}">
                                      @csrf
                                      <input type="hidden" name="module_code" value="{{ $module->code }}">
                                      <input type="hidden" name="module_status" value="{{ $module->is_active ? 'inactive' : 'active' }}">
                                      <div class="form-check form-switch">
                                          <input class="form-check-input" type="checkbox" id="activeSwitch_{{ $module->code }}"
                                                 name="is_active" {{ $module->is_active ? 'checked' : '' }} onchange="this.form.submit()">
                                          <label class="form-check-label" for="activeSwitch_{{ $module->code }}"></label>
                                      </div>
                                  </form>
                              </td>
                                <td><a href="{{ route('edit-module',['moduleId' => $module->code])}}"><img src="https://cdn-icons-png.flaticon.com/128/10336/10336582.png" width="30px" alt=""></a></td>

                            </tr>
                            <tr>
                                <td colspan="6" class="hiddenRow">
                                    <div class="accordian-body collapse" id="module_{{ $module->code }}">
                                        <table class="table">
                                            <thead style="background: linear-gradient(to right, rgb(209, 191, 230), #D3CCED); color: white;">
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th>Is Active</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($module->submodules as $submodule)
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ $submodule->name }}</td>
                                                        <td>{{ $submodule->description }}</td>
                                                        <td>
                                                            <form method="get" action="{{ route('pages-modules') }}">
                                                              @csrf
                                                              <input type="hidden" name="module_code" value="{{ $submodule->code }}">
                                                              <input type="hidden" name="module_status" value="{{ $submodule->is_active ? 'inactive' : 'active' }}">
                                                              <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="activeSwitch_{{ $submodule->code }}" name="is_active" {{ $submodule->is_active ? 'checked' : '' }} onchange="this.form.submit()">
                                                                <label class="form-check-label" for="activeSwitch_{{ $submodule->code }}"></label>
                                                              </div>
                                                          </form>
                                                      </td>
                                                        <td><a href="{{ route('edit-module',['moduleId' => $submodule->code])}}"><img src="https://cdn-icons-png.flaticon.com/128/10336/10336582.png" width="30px" alt=""></a></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

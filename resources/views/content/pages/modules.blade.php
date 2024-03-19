@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Modules')

@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="panel panel-default mt-5">
            <div class="panel-body">
                <table class="table table-border">
                    <thead style="background: linear-gradient(to right, rgb(155, 147, 243), #cbb2e0); color: white;" class="p-2 bg-opacity-75">
                        <tr>
                            <th></th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modules as $module)
                            <tr data-bs-toggle="collapse" data-bs-target="#module_{{ $module->id }}"
                                aria-expanded="false" aria-controls="module_{{ $module->id }}" class="accordion-toggle">
                                <td><button class="btn btn-default btn-xs"><span
                                            class="glyphicon glyphicon-eye-open"></span></button></td>
                                <td>{{ $module->code }}</td>
                                <td>{{ $module->name }}</td>
                                <td>{{ $module->description }}</td>
                                <td>{{ $module->is_active ? 'Yes' : 'No' }}</td>
                                <td>Edit</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="hiddenRow">
                                    <div class="accordian-body collapse" id="module_{{ $module->id }}">
                                        <table class="table table-striped">
                                            <thead style="background: linear-gradient(to right, rgb(209, 191, 230), #d3cced); color: white;">
                                                <tr>
                                                  <th colspan="2"></th>
                                                    <th>Code</th>
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
                                                      <td></td>
                                                        <td>{{ $submodule->code }}</td>
                                                        <td>{{ $submodule->name }}</td>
                                                        <td>{{ $submodule->description }}</td>
                                                        <td>{{ $submodule->is_active ? 'Yes' : 'No' }}</td>
                                                        <td>Edit</td>
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

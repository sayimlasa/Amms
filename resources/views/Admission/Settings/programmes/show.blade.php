@extends('layouts.admin')
@section('content')
<div class="col-sm-12">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <a href="{{route('programmes.index')}}" class="btn btn-info">Back</a>
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Programme Details</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        Iaa Code
                    </th>
                    <td>
                        {{ $programme->iaa_code }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Tcu Code
                    </th>
                    <td>
                        {{ $programme->tcu_code }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Nacte Code
                    </th>
                    <td>
                        {{ $programme->nacte_code }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Name
                    </th>
                    <td>
                        {{ $programme->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        short
                    </th>
                    <td>
                        {{ $programme->short }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Campuses
                    </th>
                    <td>
                    @if($programme->campuses->isNotEmpty())
                        @foreach($programme->campuses as $campus)
                        <!-- <span class="badge bg-success"> {{ $campus->name }}  {{ $campus->name }}{{ !$loop->last ? ', ' : '' }}</span> -->
                        <span class="badge bg-info"> {{ $campus->name }}</span>
                        @endforeach
                        @else
                        No campuses assigned
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>
                        Intakes
                    </th>
                    <td>
                    @if($programme->intakes->isNotEmpty())
                        @foreach($programme->intakes as $intake)
                        <!-- {{ $intake->name }}{{ !$loop->last ? ', ' : '' }} -->
                        <span class="badge bg-info"> {{ $intake->name  }}</span>
                        @endforeach
                        @else
                        No intakes assigned
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>
                        Level
                    </th>
                    <td>
                    {{ $programme->application_level->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Computing
                    </th>
                    <td>
                    <input type="checkbox" disabled="disabled" {{ $programme->computing ? 'checked' : '' }}>
                    </td>
                </tr>
                <tr>
                    <th>
                        Active
                    </th>
                    <td>
                        <input type="checkbox" disabled="disabled" {{ $programme->active ? 'checked' : '' }}>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
@parent
@endsection
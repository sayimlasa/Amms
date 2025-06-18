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
                <a href="{{route('application-windows.index')}}" class="btn btn-info">Back</a>
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Application Window Details</h6>
    </div>
    <div class="card-body">
    <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            Name
                        </th>
                        <td>
                            {{ $applicationWindow->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Level
                        </th>
                        <td>
                            {{ $applicationWindow->application_level->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Intake
                        </th>
                        <td>
                            {{ $applicationWindow->intake->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Academic Year
                        </th>
                        <td>
                            {{ $applicationWindow->academic_year->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Start At
                        </th>
                        <td>
                            {{ $applicationWindow->start_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            End At
                        </th>
                        <td>
                            {{ $applicationWindow->end_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Active
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $applicationWindow->active ? 'checked' : '' }}>
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
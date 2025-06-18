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
                <a href="{{route('campuses.index')}}" class="btn btn-info">Back</a>
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Campus Details</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        Name
                    </th>
                    <td>
                        {{ $campus->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Country
                    </th>
                    <td>
                        {{ $campus->country->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Region/State
                    </th>
                    <td>
                        {{ $campus->region_state->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        District
                    </th>
                    <td>
                        {{ $campus->district->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Active
                    </th>
                    <td>
                        <input type="checkbox" disabled="disabled" {{ $campus->active ? 'checked' : '' }}>
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
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
                <a href="{{route('admin.users.index')}}" class="btn btn-info">Back</a>
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">User Details</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        Name
                    </th>
                    <td>
                        {{ $user->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Email Address
                    </th>
                    <td>
                        {{ $user->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Mobile 
                    </th>
                    <td>
                        {{ $user->mobile }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Created At
                    </th>
                    <td>
                        {{ $user->created_at }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Active
                    </th>
                    <td>
                        <input type="checkbox" disabled="disabled" {{ $user->active ? 'checked' : '' }}>
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
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
                <a href="{{route('departments.create')}}" class="btn btn-success">Add Department</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Departments</h6>
    </div>
    <div class="card-body">
    <div class="table-responsive">
    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th>Na</th>
            <th>Faculty</th>
            <th>Departments</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $groupedDepartments = $departments->groupBy('faculty_id');
            $na = 1;
        @endphp

        @foreach($groupedDepartments as $facultyId => $facultyDepartments)
            @php $faculty = $facultyDepartments->first()->faculty; @endphp
            <tr>
                <td>{{ $na++ }}</td>
                <td>{{ $faculty->name ?? 'N/A' }}</td>
                <td>{{ $facultyDepartments->pluck('name')->implode(', ') }}</td>
                <td>
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <!-- <li>
                                <a class="dropdown-item view-item-btn" href="#">
                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                    View
                                </a>
                            </li> -->
                            <li>
                                <a class="dropdown-item edit-item-btn" href="{{ route('departments.edit', $facultyDepartments->first()->id) }}">
                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                    Edit
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


    </div>
    </div>
</div>


@endsection
@section('scripts')
@parent
@endsection
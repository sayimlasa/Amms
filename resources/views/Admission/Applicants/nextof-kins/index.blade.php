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
                <a href="{{route('nextof-kins.create')}}" class="btn btn-success">Add Kin</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Next Of Kins</h6>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle">
            @php $na = 1; @endphp
            <thead>
                <tr>
                    <th>Na</th>
                    <th style="display: none;">ID</th>
                    <th>Index Number</th>
                    <th>Full Name</th>
                    <th>Mobile</th>
                    <th>Place of Domicile</th>
                    <th>Physical Address</th>
                    <th>Relationship</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nextOfKins as $nextOfKin)
                <tr>
                    <td>{{ $na }}</td>
                    <td style="display: none;">{{ $nextOfKin->id ?? '' }}</td>
                    <td>{{ $nextOfKin->applicantUser->index_no ?? '' }}</td>
                    <td>{{ $nextOfKin->fname ?? '' }} {{ $nextOfKin->mname ?? '' }} {{ $nextOfKin->lname ?? '' }}</td>
                    <td>{{ $nextOfKin->mobile_no ?? '' }}</td>
                    <td>{{ $nextOfKin->country->name ?? '' }} {{ $nextOfKin->region->name ?? '' }} {{ $nextOfKin->district->name ?? '' }}</td>
                    <td>{{ $nextOfKin->physical_address ?? '' }}</td>
                    <td>{{ $nextOfKin->relationship->name ?? '' }}</td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('nextof-kins.show', $nextOfKin->id) }}">
                                        <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View 
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('nextof-kins.edit', $nextOfKin->id) }}">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @php $na++; @endphp
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
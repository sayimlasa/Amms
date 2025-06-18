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
                <a href="{{route('applicants-users.create')}}" class="btn btn-success">Add Applicant</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Applicants Accounts</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                @php $na = 1; @endphp
                <thead>
                    <tr>
                        <th>Na</th>
                        <th data-ordering="true" hidden> id</th>
                        <th data-ordering="true"> Index Number</th>
                        <th data-ordering="true"> Email</th>
                        <th data-ordering="true"> Mobile</th>
                        <th data-ordering="true"> Application Category</th>
                        <th data-ordering="true"> Campus</th>
                        <th data-ordering="true"> Academic Year</th>
                        <th data-ordering="true"> Active</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applicantsUsers as $applicantsUser)
                    <tr data-entry-id="{{ $applicantsUser->id }}">
                        <td>{{$na}}</td>
                        <td hidden>{{ $applicantsUser->id ?? '' }}</td>
                        <td>{{ $applicantsUser->index_no ?? '' }}</td>
                        <td>{{ $applicantsUser->email ?? '' }}</td>
                        <td>{{ $applicantsUser->mobile_no ?? '' }}</td>
                        <td>{{ $applicantsUser->application_category_name }}</td>
                        <td>{{ $applicantsUser->campus_name }}</td>
                        <td>{{ $applicantsUser->academic_year_name }}</td>
                        <td scope="row">
                            <div class="form-check">
                                <input class="form-check-input fs-15" type="checkbox" {{ $applicantsUser->active == 1 ? 'checked' : '' }} disabled>
                            </div>
                        </td>
                        <td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item view-item-btn" href="{{ route('applicants-users.show', $applicantsUser->id) }}">
                                            <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                            view
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item edit-item-btn" href="{{ route('applicants-users.edit', $applicantsUser->id) }}">
                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                            edit
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
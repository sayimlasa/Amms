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
                <!-- <a href="{{route('applicants-users.create')}}" class="btn btn-success">Add Applicant</a> -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Incomplete Applications</h6>
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
                        <th>More</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applicants as $applicant)
                    <tr data-entry-id="{{ $applicant->id }}">
                        <td>{{$na}}</td>
                        <td hidden>{{ $applicant->id ?? '' }}</td>
                        <td>{{ $applicant->index_no ?? '' }}</td>
                        <td>{{ $applicant->applicantUser->email ?? '' }}</td>
                        <td>{{ $applicant->applicantUser->mobile_no ?? '' }}</td>
                        <td>{{ $applicant->applicationCategory->name }}</td>
                        <td>
                            <a class="dropdown-item view-item-btn" href="{{ route('incomplete-applicant-info', ['applicant_user_id' => $applicant->applicant_user_id, 'index_no' => $applicant->index_no]) }}">
                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                more
                            </a>
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
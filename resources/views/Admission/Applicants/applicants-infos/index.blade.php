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
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Applicants Details</h6>
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
                    <th>Gender</th>
                    <th>Nationality</th>
                    <th>Physical Address</th>
                    <th>Disability</th>
                    <th>Employment</th>
                    <th>Campus</th>
                    <th>Intake</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applicantsInfos as $applicantsInfo)
                <tr>
                    <td>{{ $na }}</td>
                    <td style="display: none;">{{ $applicantsInfo->id ?? '' }}</td>
                    <td>{{ $applicantsInfo->applicantUser->index_no ?? '' }}</td>
                    <td>{{ $applicantsInfo->fname ?? '' }} {{ $applicantsInfo->mname ?? '' }} {{ $applicantsInfo->lname ?? '' }}</td>
                    <td>{{ $applicantsInfo->gender ?? '' }}</td>
                    <td>{{ $applicantsInfo->nationalit->name ?? '' }}</td>
                    <td>{{ $applicantsInfo->physical_address ?? '' }}</td>
                    <td>{{ $applicantsInfo->disability->name ?? '' }}</td>
                    <td>{{ $applicantsInfo->employmentStatus->name ?? '' }}</td>
                    <td>{{ $applicantsInfo->campus->name ?? '' }}</td>
                    <td>{{ $applicantsInfo->intake->name ?? '' }}</td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('applicants-infos.show', $applicantsInfo->id) }}">
                                        <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View Details
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('applicants-infos.edit', $applicantsInfo->id) }}">
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
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
                <a href="{{route('districts.index')}}" class="btn btn-info">Back</a>
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Applicant Details</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        Index Number
                    </th>
                    <td>
                    {{ $applicantsInfo->applicantUser->index_no ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Full Name
                    </th>
                    <td>
                    {{ $applicantsInfo->fname ?? '' }} {{ $applicantsInfo->mname ?? '' }} {{ $applicantsInfo->lname ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Gender
                    </th>
                    <td>
                    {{ $applicantsInfo->gender ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Mobile
                    </th>
                    <td>
                    {{ $applicantsInfo->applicantUser->mobile_no ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Date of Birth
                    </th>
                    <td>
                    {{ $applicantsInfo->birth_date ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Place of Birth
                    </th>
                    <td>
                    {{ $applicantsInfo->CountryOfBirth->name ?? '' }},
                    {{ $applicantsInfo->PlaceOfBirth->name ?? '' }},
                    {{ $applicantsInfo->DistrictOfBirth->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Nationality
                    </th>
                    <td>
                    {{ $applicantsInfo->nationalit->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Place of Domicile
                    </th>
                    <td>
                    {{ $applicantsInfo->Country->name ?? '' }},
                    {{ $applicantsInfo->Region->name ?? '' }},
                    {{ $applicantsInfo->District->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Physical Addres
                    </th>
                    <td>
                    {{ $applicantsInfo->physical_address ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Disability
                    </th>
                    <td>
                    {{ $applicantsInfo->disability->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                       Employment Status
                    </th>
                    <td>
                    {{ $applicantsInfo->employmentStatus->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                       Employer
                    </th>
                    <td>
                    {{ $applicantsInfo->employer->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                       Campus
                    </th>
                    <td>
                    {{ $applicantsInfo->campus->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                       Intake
                    </th>
                    <td>
                    {{ $applicantsInfo->intake->name ?? '' }}
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
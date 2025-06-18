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
            <a href="javascript:history.back()" class="btn btn-info">Back</a>
            </div>
        </div>
    </div>
</section>
<!-- Card 1 -->
<div class="row">
@if ($applicantInfos)
    <div class="col-md-6">
        <div class="card mb-2" id="expandableCard1">
            <div class="py-2 px-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0" style="font-size: 14px;">Personal Informations</h6>
                <div>
                    <button
                        type="button"
                        class="expand btn-xs btn-light p-1"
                        style="width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;"
                        onclick="toggleCard('expandableCard1')">
                        <i class="ri-arrow-up-s-line" style="font-size: 16px;"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" id="cardContent1" style="display: none;">
                <p style="margin-bottom: 5px;"><strong>Full Name:</strong> {{ optional($applicantInfos)->fname }} {{ optional($applicantInfos)->mname }} {{ optional($applicantInfos)->lname }}</p>
                <p style="margin-bottom: 5px;"><strong>Gender:</strong> {{ optional($applicantInfos)->gender }}</p>
                <p style="margin-bottom: 5px;"><strong>Date of Birth:</strong> {{ optional($applicantInfos)->birth_date }}</p>
                <p style="margin-bottom: 5px;"><strong>Disability:</strong> {{ optional($applicantInfos->disability)->name }}</p>
                <p style="margin-bottom: 5px;"><strong>Mobile:</strong> {{ optional($applicantInfos->applicantUser)->mobile_no }}</p>
                <p style="margin-bottom: 5px;"><strong>Email:</strong> {{ optional($applicantInfos->applicantUser)->email }}</p>
                <p style="margin-bottom: 5px;"><strong>Index Number:</strong> {{ optional($applicantInfos->applicantUser)->index_no }}</p>
                <p style="margin-bottom: 5px;"><strong>Place Of Birth:</strong> {{ optional($applicantInfos->countryOfBirth)->name }} {{ optional($applicantInfos->placeOfBirth)->name }} {{ optional($applicantInfos->districtOfBirth)->name }}</p>
                <p style="margin-bottom: 5px;"><strong>Place Of Domicile:</strong> {{ optional($applicantInfos->country)->name }} {{ optional($applicantInfos->region)->name }} {{ optional($applicantInfos->district)->name }}</p>
                <p style="margin-bottom: 5px;"><strong>Nationaliy:</strong> {{ optional($applicantInfos->nationalit)->name }}</p>
                <p style="margin-bottom: 5px;"><strong>Physical Address:</strong> {{ optional($applicantInfos)->physical_address }}</p>
                <p style="margin-bottom: 5px;"><strong>Marital Status:</strong> {{ optional($applicantInfos->maritalStatus)->name }}</p>
                @if ($applicantInfos->employment_status != null)
                <p style="margin-bottom: 5px;"><strong>Employment Status:</strong> {{ optional($applicantInfos->employmentStatus)->name }}</p>
                <p style="margin-bottom: 5px;"><strong>Employer:</strong> {{ optional($applicantInfos->employer)->name ?: 'Not Selected' }}</p>
                @endif
            </div>
        </div>
    </div>
@endif
    <!-- Card 2 -->
     
@if ($nextOfKin)
    <div class="col-md-6">
        <div class="card mb-2" id="expandableCard2">
            <div class="py-2 px-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0" style="font-size: 14px;">Next Of Kin Information</h6>
                <div>
                    <button
                        type="button"
                        class="expand btn-xs btn-light p-1"
                        style="width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;"
                        onclick="toggleCard('expandableCard2')">
                        <i class="ri-arrow-up-s-line" style="font-size: 16px;"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" id="cardContent2" style="display: none;">
                <p style="margin-bottom: 5px;"><strong>Full Name:</strong> {{ optional($nextOfKin)->fname }} {{ optional($nextOfKin)->mname }} {{ optional($nextOfKin)->lname }}</p>
                <p style="margin-bottom: 5px;"><strong>Mobile:</strong> {{ optional($nextOfKin)->mobile_no }}</p>
                <p style="margin-bottom: 5px;"><strong>Relationship:</strong> {{ optional($nextOfKin->relationship)->name }}</p>
                <p style="margin-bottom: 5px;"><strong>Place Of Domicile:</strong> {{ optional($nextOfKin->country)->name }} {{ optional($nextOfKin->region)->name }} {{ optional($nextOfKin->district)->name }}</p>
                <p style="margin-bottom: 5px;"><strong>Nationaliy:</strong> {{ optional($nextOfKin->nationalit)->name }}</p>
                <p style="margin-bottom: 5px;"><strong>Physical Address:</strong> {{ optional($nextOfKin)->physical_address }}</p>

            </div>
        </div>
    </div>
</div>
@endif

<!-- Card 3 -->
@if ($academics->isNotEmpty())
<div class="card mb-2" id="expandableCard3">
    <div class="py-2 px-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0" style="font-size: 14px;">Academic Information</h6>
        <div>
            <button
                type="button"
                class="expand btn-xs btn-light p-1"
                style="width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;"
                onclick="toggleCard('expandableCard3')">
                <i class="ri-arrow-up-s-line" style="font-size: 16px;"></i>
            </button>
        </div>
    </div>
    <div class="card-body" id="cardContent3" style="display: none;">
        <div class="row">
            @foreach ($academics as $academic)
            <div class="col-md-6">
                <div class="card">
                    <div class="py-2 px-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0" style="font-size: 14px;">{{ $academic->educationLevel->name ?? '' }}</h6>
                    </div>
                    <div class="card-body">
                        <p style="margin-bottom: 5px;"><strong>Course:</strong> {{ optional($academic)->course }}</p>
                        <p style="margin-bottom: 5px;"><strong>Qualification Number:</strong> {{ optional($academic)->qualification_no }}</p>
                        <p style="margin-bottom: 5px;"><strong>GPA/Division:</strong> {{ optional($academic)->gpa_divission }}</p>
                        <p style="margin-bottom: 5px;"><strong>Year of Completion:</strong> {{ optional($academic)->yoc }}</p>
                        <p style="margin-bottom: 5px;"><strong>Center Name:</strong> {{ optional($academic)->center_name }}</p>
                        <p style="margin-bottom: 5px;"><strong>Center Location:</strong>
                            {{ optional($academic->country)->name }}
                            {{ optional($academic->region)->name }}
                            {{ optional($academic->district)->name }}
                        </p>

                        {{-- Display Results in Table --}}
                        @if (Str::contains(strtolower($academic->educationLevel->name), 'four'))
                        <h6>Form 4 Results</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Subject</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $form4Results = $form4_results->where('applicant_user_id', $academic->applicant_user_id)
                                    ->where('index_no', $academic->index_no);
                                    @endphp
                                    @foreach ($form4Results as $index => $result)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $result->subject_code }}</td>
                                        <td>{{ $result->subject_name }}</td>
                                        <td>{{ $result->grade }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @elseif (Str::contains(strtolower($academic->educationLevel->name), 'six'))
                        <h6>Form 6 Results</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Subject</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $form6Results = $form6_results->where('applicant_user_id', $academic->applicant_user_id);
                                    @endphp
                                    @foreach ($form6Results as $index => $result)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $result->subject_code }}</td>
                                        <td>{{ $result->subject_name }}</td>
                                        <td>{{ $result->grade }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>


    </div>
</div>
@endif

@if ($attachments->isNotEmpty())
<!-- Card 4 -->
<div class="card mb-2" id="expandableCard4">
    <div class="py-2 px-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0" style="font-size: 14px;">Attachements</h6>
        <div>
            <button
                type="button"
                class="expand btn-xs btn-light p-1"
                style="width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;"
                onclick="toggleCard('expandableCard4')">
                <i class="ri-arrow-up-s-line" style="font-size: 16px;"></i>
            </button>
        </div>
    </div>
    <div class="card-body" id="cardContent4" style="display: none;">
        <div class="row">
            @foreach ($attachments as $attachment)
            <div class="col-md-6">
                <div class="card">
                    <div class="py-2 px-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0" style="font-size: 14px;">{{ $attachment->type->name ?? '' }}</h6>
                    </div>
                    <div class="card-body">
                        <img src="{{ asset('storage/app/public/' . $attachment->doc_url) }}" alt="{{ $attachment->type->name ?? '' }}" class="img-fluid" style="max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif


<div class="row">
@if ($payment)
    <div class="col-md-6">
        <!-- Card 5 -->
        <div class="card mb-2" id="expandableCard5">
            <div class="py-2 px-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0" style="font-size: 14px;">Payments</h6>
                <div>
                    <button
                        type="button"
                        class="expand btn-xs btn-light p-1"
                        style="width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;"
                        onclick="toggleCard('expandableCard5')">
                        <i class="ri-arrow-up-s-line" style="font-size: 16px;"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" id="cardContent5" style="display: none;">
                <p style="margin-bottom: 5px;"><strong>Control Number:</strong> {{ optional($payment)->control_no }}</p>
                <p style="margin-bottom: 5px;"><strong>Date Generated:</strong> {{ optional($payment)->controlno_generated_at }}</p>
                <p style="margin-bottom: 5px;"><strong>Amount:</strong> {{ optional($payment)->amount }}</p>
                @if ($payment->status == 1)
                <p style="margin-bottom: 5px;" class="badge bg-success"><strong>Paid</strong></p>
                @else
                <p style="margin-bottom: 5px;" class="badge bg-warning"><strong>Not Paid</strong></p>
                @endif
                <p style="margin-bottom: 5px;"><strong>Date Paid:</strong> {{ optional($payment)->pay_date }}</p>
            </div>
        </div>
    </div>
    @endif
    @if ($choice)
    <div class="col-md-6">
        <!-- Card 6 -->
        <div class="card" id="expandableCard6">
            <div class="py-2 px-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0" style="font-size: 14px;">Applicant Choices</h6>
                <div>
                    <button
                        type="button"
                        class="expand btn-xs btn-light p-1"
                        style="width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;"
                        onclick="toggleCard('expandableCard6')">
                        <i class="ri-arrow-up-s-line" style="font-size: 16px;"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" id="cardContent6" style="display: none;">
                <p style="margin-bottom: 5px;"><strong>First Choice:</strong> {{ optional($choice->programmeChoice1)->name }}</p>
                <p style="margin-bottom: 5px;"><strong>Second Choice:</strong> {{ optional($choice->programmeChoice2)->name }}</p>
                <p style="margin-bottom: 5px;"><strong>Third Choice:</strong> {{ optional($choice->programmeChoice3)->name }}</p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
@section('scripts')
@parent
@endsection
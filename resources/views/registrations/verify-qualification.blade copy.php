@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header"></section>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h6 class="mb-0 flex-grow-1">Verify Qualification</h6>
                            </div><!-- end card header -->
                            <div class="card-body">
                                <div class="live-preview">
                                    <form method="POST" action="{{ route('payment.setting.store') }}">
                                        @csrf
                                        <div class="row g-4">
                                            <!-- Study Mode Checkbox -->
                                            <div class="col-xxl-3 col-md-3">
                                                <div class="form-group">
                                                    <label for="study_mode" class="form-label">Select Mode of Study:</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="study_mode_fulltime"
                                                            id="full_time" value="Full-time"
                                                            {{ old('study_mode_fulltime') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="full_time">
                                                            Full-time
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="study_mode_blended"
                                                            id="blended" value="Blended"
                                                            {{ old('study_mode_blended') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="blended">
                                                            Blended
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Qualification Checkboxes -->
                                            <div class="col-xxl-3 col-md-3">
                                                <div class="form-group">
                                                    <label for="qualification" class="form-label">Select Qualification:</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_form_four"
                                                            id="form_four" value="Form Four"
                                                            {{ old('qualification_form_four') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="form_four">
                                                            Form Four
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_form_six"
                                                            id="form_six" value="Form Six"
                                                            {{ old('qualification_form_six') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="form_six">
                                                            Form Six
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_diploma"
                                                            id="diploma" value="Diploma"
                                                            {{ old('qualification_diploma') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="diploma">
                                                            Diploma
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_bachelor"
                                                            id="bachelor" value="Bachelor"
                                                            {{ old('qualification_bachelor') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="bachelor">
                                                            Bachelor Certificate
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_bachelor_transcript"
                                                            id="bachelor_transcript" value="Bachelor Transcript"
                                                            {{ old('qualification_bachelor_transcript') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="bachelor_transcript">
                                                            Bachelor Transcript
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_medical_form"
                                                            id="medical_form" value="Medical Form"
                                                            {{ old('qualification_medical_form') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="medical_form">
                                                            Medical Form
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_birth_certificate"
                                                            id="birth_certificate" value="Birth Certificate"
                                                            {{ old('qualification_birth_certificate') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="birth_certificate">
                                                            Birth Certificate
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Registration Number Generation -->
                                            @php
                                            $indexnumber = 'EQ2019000863-2012';
                                            // Retrieve the employment status ID for 'Unemployed'
                                            $employmee = \App\Models\EmploymentStatus::where('name', 'LIKE', '%Unemployed%')->pluck('id')->first();
                                            
                                            // Retrieve campus_id based on index_no and employment_status
                                            $campusId = \App\Models\ApplicantsInfo::where('index_no', $indexnumber)
                                                                     ->where('employment_status', $employmee)
                                                                     ->pluck('campus_id')
                                                                     ->first();
                                        
                                            // If campusId is not found, you may want to handle it, e.g., set a default or raise an error
                                            if ($campusId) {
                                                // Handle the case where no campusId is found (e.g., throw an error or use a default)
                                                $campusId = str_pad($campusId, 2, '0', STR_PAD_LEFT);
                                            }
                                        
                                            // Program ID (replace with dynamic program ID from the form or database)
                                            $programId = 6;
                                            $program = App\Models\Programme::find($programId); // Retrieve program details
                                        
                                            // Get the current year
                                            $currentYear = date('Y');
                                        
                                            // Assuming the last used number is saved in session or somewhere else (can be replaced by actual database logic)
                                            $lastUsedNumber = session('lastUsedNumber_' . $programId, 0);
                                        
                                            // If the year has changed or the program_id is different, reset the counter
                                            if (session('lastUsedYear_' . $programId) != $currentYear) {
                                                $lastUsedNumber = 0;
                                                session(['lastUsedYear_' . $programId => $currentYear]); // Update the year in session
                                            }
                                        
                                            // Increment the number for the program
                                            $newNumber = $lastUsedNumber + 1;
                                        
                                            // Pad the number to 4 digits (e.g., 0001, 0002, ...)
                                            $formattedRandomNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
                                        
                                            // Check if registration number already exists in the database
                                            $registrationNumber = $program->short . '-' . $campusId . '-' . $formattedRandomNumber . '-' . $currentYear;
                                        
                                            // Query to check if the registration number already exists
                                            $existingRegistration = \App\Models\VerifyQualification::where('regno', $registrationNumber)->first();
                                        
                                            // If the registration number exists, increment the number and try again
                                            if ($existingRegistration) {
                                                // Increment the number
                                                $newNumber++;
                                                $formattedRandomNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
                                                $registrationNumber = $program->short . '-' . $campusId . '-' . $formattedRandomNumber . '-' . $currentYear;
                                            }
                                        
                                            // Update the session with the latest used number for the program
                                            session(['lastUsedNumber_' . $programId => $newNumber]);
                        
                                        @endphp
                                        

                                            <!-- Registration Number Input -->
                                            <div class="col-xxl-3 col-md-3">
                                                <div class="form-group">
                                                    <label for="registration_number" class="form-label">Registration Number</label>
                                                    <input type="text" class="form-control" id="registration_number" name="registration_number" value="{{ $registrationNumber }}" readonly>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.card-body -->
                        </div><!-- /.card -->
                    </div><!-- /.col-lg-12 -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

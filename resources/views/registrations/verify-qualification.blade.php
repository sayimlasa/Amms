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
                                    <form method="POST" action="{{ route('qualification.store') }}">
                                        @csrf
                                        <div class="row g-4">
                                            <!-- Study Mode Checkbox -->
                                            <div class="col-xxl-3 col-md-3">
                                                <div class="form-group">
                                                    <label for="study_mode" class="form-label">Select Mode of Study:</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="study_mode_fulltime"
                                                            id="full_time" value="0"
                                                            {{ old('study_mode_fulltime') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="full_time">Evening Time</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="study_mode_blended"
                                                            id="blended" value="0"
                                                            {{ old('study_mode_blended') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="blended">Blended</label>
                                                    </div>
                                                                                                   </div>
                                            </div>

                                            <!-- Qualification Checkboxes -->
                                            <div class="col-xxl-3 col-md-3">
                                                <div class="form-group">
                                                    <label for="qualification" class="form-label">Select Qualification:</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_form_four"
                                                            id="form_four" value="0"
                                                            {{ old('qualification_form_four') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="form_four">Form Four</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_form_six"
                                                            id="form_six" value="0"
                                                            {{ old('qualification_form_six') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="form_six">Form Six</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_diploma"
                                                            id="diploma" value="0"
                                                            {{ old('qualification_diploma') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="diploma">Diploma</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_bachelor"
                                                            id="bachelor" value="0"
                                                            {{ old('qualification_bachelor') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="bachelor">Bachelor Certificate</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_bachelor_transcript"
                                                            id="bachelor_transcript" value="0"
                                                            {{ old('qualification_bachelor_transcript') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="bachelor_transcript">Bachelor Transcript</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_medical_form"
                                                            id="medical_form" value="0"
                                                            {{ old('qualification_medical_form') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="medical_form">Medical Form</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="qualification_birth_certificate"
                                                            id="birth_certificate" value="0"
                                                            {{ old('qualification_birth_certificate') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="birth_certificate">Birth Certificate</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Registration Number Generation -->
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

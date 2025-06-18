@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h6 class="mb-0 flex-grow-1">Edit Requirements</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('diploma-requirements.update', [$applicationLevelId, $educationLevelId, $programmeId]) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-4">
                                        <!-- Programme Selection -->
                                        <div class="col-xxl-6 col-md-6">
                                            <input type="hidden" name="application_level_id" id="application_level_id" value="{{ $applicationLevelId }}">
                                            <div>
                                                <label for="programme_id" class="form-label">Choose Programme</label>
                                                <select class="form-control select2" name="programme_id" id="programme_id" required>
                                                    <option selected disabled><--choose level--></option>
                                                    @foreach ($programmes as $programme)
                                                    <option value="{{ $programme->id }}" {{ $programme->id == $programmeId ? 'selected' : '' }}>
                                                        {{ $programme->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Education Level Selection -->
                                        <div class="col-xxl-6 col-md-6">
                                            <div>
                                                <label for="education_level_id" class="form-label">Qualifying With</label>
                                                <select class="form-control select2" name="education_level_id" id="education_level_id" required>
                                                    <option selected disabled><--choose level--></option>
                                                    @foreach ($educationLevels as $level)
                                                    <option value="{{ $level->id }}" {{ $level->id == $educationLevelId ? 'selected' : '' }}>
                                                        {{ $level->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Subjects/Courses (for Certificate) -->
                                        <div class="col-xxl-12 col-md-12" id="certificate_fields" style="{{ isset($subjects) && $subjects ? 'display:block;' : 'display:none;' }}">
                                            <div>
                                                <label for="subject_course" class="form-label">Subjects or Courses</label>
                                                <textarea class="form-control" id="subject_course" name="subject_course" rows="4">{{ old('subject_course', $subjects) }}</textarea>
                                                <small class="text-muted">Enter multiple subjects/courses separated by commas.</small>
                                            </div>
                                        </div>

                                        <!-- Advanced Pass (for Form Six) -->
                                        <div class="col-xxl-6 col-md-6 form-six-fields" style="{{ isset($min_advance_pass) && $min_advance_pass !== null ? 'display:block;' : 'display:none;' }}">
                                            <div>
                                                <label for="min_advance_pass" class="form-label">Minimum Number of Pass on Advance</label>
                                                <input type="number" class="form-control" id="min_advance_pass" name="min_advance_pass" value="{{ old('min_advance_pass', $min_advance_pass) }}">
                                                <small class="text-muted">Only check on principle subjects.</small>
                                            </div>
                                        </div>

                                        <!-- Subsidiary Pass (for Form Six) -->
                                        <div class="col-xxl-6 col-md-6 form-six-fields" style="{{ isset($min_subsidiary_pass) && $min_subsidiary_pass !== null ? 'display:block;' : 'display:none;' }}">
                                            <div>
                                                <label for="min_subsidiary_pass" class="form-label">Minimum Number of Subsidiary on Advance</label>
                                                <input type="number" class="form-control" id="min_subsidiary_pass" name="min_subsidiary_pass" value="{{ old('min_subsidiary_pass', $min_subsidiary_pass) }}">
                                                <small class="text-muted">Only check on principle subjects.</small>
                                            </div>
                                        </div>


                                        <!-- Submit Button -->
                                        <div class="col-12">
                                            <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <a href="{{ route('diploma-requirements.index') }}" class="btn btn-secondary">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!--end col-->
                            </div>
                            <!-- /.row -->
                        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@yield('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let educationSelect = document.getElementById("education_level_id");

        educationSelect.addEventListener("change", function() {
            let selectedText = educationSelect.options[educationSelect.selectedIndex].text.toLowerCase();

            // Check for Form Six
            if (selectedText.includes("six")) {
                document.querySelectorAll(".form-six-fields").forEach(el => el.style.display = "block");
                document.getElementById("certificate_fields").style.display = "none";
            }
            // Check for Certificate
            else if (selectedText.includes("certificate")) {
                document.querySelectorAll(".form-six-fields").forEach(el => el.style.display = "none");
                document.getElementById("certificate_fields").style.display = "block";
            }
            // Hide all if neither
            else {
                document.querySelectorAll(".form-six-fields").forEach(el => el.style.display = "none");
                document.getElementById("certificate_fields").style.display = "none";
            }
        });
    });
</script>
@endsection
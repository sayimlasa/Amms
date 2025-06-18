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
                                <form method="POST" action="{{ route('bachelor-requirements.update', [$applicationLevelId, $educationLevelId, $programmeId]) }}">
                                    @csrf
                                    @method('PUT') <!-- This makes sure we are sending an update request -->
                                    <div class="row g-4">
                                        <!-- Programme Selection -->
                                        <div class="col-xxl-6 col-md-6">
                                            <input type="hidden" name="application_level_id" id="application_level_id" value="{{$applicationLevels[0]}}">
                                            <div>
                                                <label for="programme_id" class="form-label">Choose Programme</label>
                                                <select class="form-control select2" name="programme_id" id="programme_id" required >
                                                    <option selected disabled><--choose level--></option>
                                                    @foreach ($programmes as $programme)
                                                    <option value="{{ $programme->id }}" {{ old('programme_id', $programmeId) == $programme->id ? 'selected' : '' }}>
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
                                                    <option value="{{ $level->id }}" {{ old('education_level_id', $educationLevelId) == $level->id ? 'selected' : '' }}>
                                                        {{ $level->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Subjects/Courses (for Certificate) -->
                                        <div class="col-xxl-12 col-md-12 diploma-fields" style="{{ isset($subjects) && $subjects ? 'display:block;' : 'display:none;' }}">
                                            <div>
                                                <label for="subject_course" class="form-label">Courses/Subjects</label>
                                                <input type="hidden" name="subject_course" value="">
                                                <textarea class="form-control" id="subject_course" name="subject_course" rows="4">{{ old('subject_course', $subjects) }}</textarea>
                                                <small class="text-muted">Enter multiple courses separated by commas.</small>
                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-md-6 diploma-fields" style="{{ isset($min_olevel_pass) && $min_olevel_pass ? 'display:block;' : 'display:none;' }}">
                                            <div>
                                                <label for="min_olevel_pass" class="form-label">Minimum Number of Pass at Olevel</label>
                                                <input type="number" class="form-control" id="min_olevel_pass" name="min_olevel_pass" value="{{ old('min_olevel_pass', $min_olevel_pass) }}">
                                                <small class="text-muted">Only check on principle subjects.</small>
                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-md-6 diploma-fields" style="{{ isset($min_olevel_average) && $min_olevel_average ? 'display:block;' : 'display:none;' }}">
                                            <div>
                                                <label for="min_olevel_average" class="form-label">Minimum Olevel Average</label>
                                                <input type="text" class="form-control" id="min_olevel_average" name="min_olevel_average" value="{{ old('min_olevel_average', $min_olevel_average) }}">
                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-md-6 diploma-fields" style="{{ isset($min_foundation_gpa_diploma) && $min_foundation_gpa_diploma ? 'display:block;' : 'display:none;' }}">
                                            <div>
                                                <label for="min_foundation_gpa_diploma" class="form-label">Minimum Foundation GPA</label>
                                                <input type="hidden" name="min_foundation_gpa_diploma" value="">
                                                <input type="number" class="form-control" id="min_foundation_gpa" name="min_foundation_gpa" value="{{ old('min_foundation_gpa_diploma', $min_foundation_gpa_diploma) }}">
                                            </div>
                                        </div>

                                        <!-- Advanced Pass (for Form Six) -->
                                      
                                        <div class="col-xxl-6 col-md-6 form-six-fields" style="{{ isset($min_advance_principle_pass) && $min_advance_principle_pass ? 'display:block;' : 'display:none;' }}">
                                            <div>
                                                <label for="min_advance_principle_pass" class="form-label">Minimum Principle Passes on Advance</label>
                                                <input type="number" class="form-control" id="min_advance_principle_pass" name="min_advance_principle_pass" value="{{ old('min_advance_principle_pass', $min_advance_principle_pass) }}">
                                                <small class="text-muted">Only check on principle subjects.</small>
                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-md-6 form-six-fields" style="{{ isset($min_advance_aggregate_points) && $min_advance_aggregate_points ? 'display:block;' : 'display:none;' }}">
                                            <div>
                                                <label for="min_advance_aggregate_points" class="form-label">Minimum Aggregate Points</label>
                                                <input type="number" class="form-control" id="min_advance_aggregate_points" name="min_advance_aggregate_points" value="{{ old('min_advance_aggregate_points', $min_advance_aggregate_points) }}">
                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-md-6 form-six-fields" style="{{ isset($min_advance_principle_pass) && $min_advance_principle_pass ? 'display:block;' : 'display:none;' }}">
                                             <div>
                                                <label for="math" class="form-label">Is Math Necessary?</label>
                                                <div class="form-check">
                                                    <input type="hidden" name="math" value="0">
                                                    <input class="form-check-input" type="checkbox" id="math" name="math" value="1" {{ $math || old('math', 0) === 1 ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-12">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success">Update</button>
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
    document.getElementById('programme_id').addEventListener('mousedown', function(event) {
        event.preventDefault(); // Prevent dropdown from opening
    });
    document.getElementById('education_level_id').addEventListener('mousedown', function(event) {
        event.preventDefault(); // Prevent dropdown from opening
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let educationSelect = document.getElementById("education_level_id");

        educationSelect.addEventListener("change", function() {
            let selectedText = educationSelect.options[educationSelect.selectedIndex].text.toLowerCase();

            // Check for Form Six
            if (selectedText.includes("six")) {
                document.querySelectorAll(".form-six-fields").forEach(el => el.style.display = "block");
                document.querySelectorAll(".diploma-fields").forEach(el => el.style.display = "none");
            }
            // Check for Diploma
            else if (selectedText.includes("diploma")) {
                document.querySelectorAll(".form-six-fields").forEach(el => el.style.display = "none");
                document.querySelectorAll(".diploma-fields").forEach(el => el.style.display = "block");
            }
            // Hide all if neither
            else {
                document.querySelectorAll(".form-six-fields").forEach(el => el.style.display = "none");
                document.querySelectorAll(".diploma-fields").forEach(el => el.style.display = "none");
            }
        });
    });
</script>
@endsection
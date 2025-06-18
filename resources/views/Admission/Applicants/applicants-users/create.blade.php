@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    </section>
    <div class="col-sm-12">
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h6 class=" mb-0 flex-grow-1">New Applicant</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{route('applicants-users.store')}}">
                                    @csrf
                                    <div class="row g-4">
                                        <!-- Name Input -->

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="index-number" class="form-label">Form Four Index Number</label>
                                                <input type="text" class="form-control" placeholder="Enter index number" id="index_no" name="index_no">
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="first-name" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="middle-name" class="form-label">Middle Name</label>
                                                <input type="text" class="form-control" id="middle_name" name="middle_name" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="last-name" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="numeral-formatting" class="form-label">Gender</label>
                                                <input type="text" class="form-control" id="sex" name="sex" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="school" class="form-label">School</label>
                                                <input type="text" class="form-control" id="center_name" name="center_name" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="email" class="form-label">email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="xxxx@xxx.xxx" required>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="password" class="form-label">password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="xxxxxxx" required>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="xxxxxxx" required>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="mobile_no" class="form-label">Mobile</label>
                                                <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="0788259199" required>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="application-category" class="form-label">Application category</label>
                                                <select class="form-control select2" name="application_category_id" id="application_category_id" required>
                                                    <option value="" selected disabled>select category</option>
                                                    @foreach ( $applicationCategories as $applicationCategory)
                                                    <option value="{{$applicationCategory->id}}">{{$applicationCategory->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="campus" class="form-label">Campus</label>
                                                <select class="form-control select2" name="campus_id" id="campus_id" required>
                                                    <option value="" selected disabled>select campus</option>

                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="academic-year" class="form-label">Academic Year</label>
                                                <input class="form-control" type="hidden" value="{{$academicYear->id}}" name="academic_year_id" id="academic_year_id">{{$academicYear->name}}
                                            </div>
                                        </div>

                                        <!-- Is Active Checkbox -->
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="active" class="form-label">Is Active?</label>
                                                <div class="form-check">
                                                    <input type="hidden" name="active" value="0">
                                                    <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ old('active', 0) == 1 ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden container for results -->
                                        <div id="results" style="display: none;">
                                            <!-- Hidden inputs for results will be appended here -->
                                        </div>

                                        <!-- Hidden container for subjects -->
                                        <div id="subjects" style="display: none;">
                                            <!-- Hidden inputs for subjects will be appended here -->
                                        </div>

                                        <!-- Start Date Input -->

                                        <!-- Submit Button -->
                                        <div class="col-12">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success">Submit</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const applicationCategories = @json($applicationCategories);
</script>

<script>
    document.getElementById('mobile_no').addEventListener('input', function() {
        const mobileInput = this.value;
        const mobilePattern = /^0\d{9,14}$/;

        if (!mobilePattern.test(mobileInput)) {
            this.setCustomValidity('Mobile number must start with 0 and have 10 to 15 digits.');
        } else {
            this.setCustomValidity(''); // Clear error message if valid
        }
    });

    $(document).ready(function() {
        $('#application_category_id').change(function() {
            const applicationCategoryId = $(this).val();
            const selectedCategory = applicationCategories.find(
                category => category.id == applicationCategoryId
            );

            // Clear existing options in the campus dropdown
            $('#campus_id').empty().append('<option value="" selected disabled>select campus</option>');

            if (selectedCategory && selectedCategory.application_level) {
                const campuses = selectedCategory.application_level.campuses;

                // Populate the campus dropdown with related campuses
                campuses.forEach(campus => {
                    $('#campus_id').append(
                        `<option value="${campus.id}">${campus.name}</option>`
                    );
                });
            }
        });
    });
</script>
<script>
    $("#index_no").on("blur", function() {
        let inputValue = $(this).val();
        let indexNumber = inputValue.split("/").slice(0, 2).join("-"); // Convert S3921/0208 to S3921-0208
        let examYear = inputValue.split("/")[2];
        $.ajax({
            url: '{{ route('fetch-student-data') }}', // Laravel route
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // CSRF token for security
            },
            data: {
                index_no: inputValue, // Send original input
                exam_year: examYear,
            },
            success: function(response) {
                if (response.status.code === 1) { // Check if the response is successful
                    // Populate the form fields with the data from the API response
                    $("#first_name").val(response.particulars.first_name || "");
                    $("#middle_name").val(response.particulars.middle_name || "");
                    $("#last_name").val(response.particulars.last_name || "");
                    $("#sex").val(response.particulars.sex || "");
                    $("#center_name").val(response.particulars.center_name || "");

                    $("#results").append(`<input type="hidden" name="results[division]" value="${response.results.division || ''}">`);
                    $("#results").append(`<input type="hidden" name="results[points]" value="${response.results.points || ''}">`);

                    // Loop through the subjects array and create hidden inputs for each subject
                    let subjects = response.subjects;
                    subjects.forEach(function(subject, index) {
                        // Create hidden input for each subject
                        let subjectCode = subject.subject_code || "";
                        let subjectName = subject.subject_name || "";
                        let grade = subject.grade || "";

                        // Create hidden inputs with the subject data
                        $("#subjects").append(`<input type="hidden" name="subjects[${index}][subject_code]" value="${subjectCode}">`);
                        $("#subjects").append(`<input type="hidden" name="subjects[${index}][subject_name]" value="${subjectName}">`);
                        $("#subjects").append(`<input type="hidden" name="subjects[${index}][grade]" value="${grade}">`);
                    });
                } else {
                    alert("Error: " + response.status.message);
                }
            },
            error: function(xhr) {
                alert("An error occurred while fetching the data.");
                console.error(xhr.responseText);
            }
        });
    });
</script>
@endsection
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
                            <h6 class=" mb-0 flex-grow-1">Add Academic Information</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('applicants-academics.store') }}">
                                   @csrf
                                    <div class="row g-4">
                                        <div>
                                            <h5 class="fs-14 text-muted">Academic Information</h5>
                                            <div class="row">
                                                <div class="col-xxl-3 col-md-4 mt-3">
                                                    <div>
                                                        <label for="index_no" class="form-label">Applicant Index Number</label>
                                                        <select class="form-control" id="index_no" name="index_no" required>
                                                            <option value="" selected disabled>Choose Applicant</option>
                                                            @foreach ($applicants as $applicant)
                                                                <option value="{{ $applicant->index_no}}" data-applicant_user_id="{{ $applicant->applicant_user_id }}"  data-application_category_id="{{ $applicant->application_category_id }}">
                                                                    {{ $applicant->index_no }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <input class="form-control" type="hidden" name="applicant_user_id" id="applicant_user_id">
                                                <input class="form-control" type="hidden" name="application_category_id" id="application_category_id">

                                                 <!-- Region Dropdown -->
                                                 <div class="col-xxl-3 col-md-4 mt-3">
                                                    <div>
                                                        <label for="education_level" class="form-label">Education Level</label>
                                                        <select class="form-control select2" name="education_level" id="education_level" required>
                                                            <option value="" selected disabled>Choose Level</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="course" class="form-label">Course</label>
                                                        <input type="text" class="form-control" id="course" name="course" placeholder="CSEE" oninput="capitalizeOnlyFirstLetter(this)" required>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="qualification_no" class="form-label">Qualification No(VI index, AVN, Foreign)</label>
                                                        <input type="text" class="form-control" id="qualification_no" name="qualification_no" placeholder="S0988/0000/0000" required>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="gpa_divission" class="form-label">Gpa/Division</label>
                                                        <input type="text" class="form-control" id="gpa_divission" name="gpa_divission" placeholder="4.0" required>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3 ">
                                                    <div>
                                                        <label for="yoc" class="form-label">Completion Year</label>
                                                        <input type="text" class="form-control" id="yoc" name="yoc" required>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3 ">
                                                    <div>
                                                        <label for="center_name" class="form-label">Center Name</label>
                                                        <input type="text" class="form-control" id="center_name" name="center_name" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border-top"></div>
                                        <div>
                                            <h5 class="fs-14 text-muted">School Location</h5>
                                            <div class="row">
                                                <!-- Country Dropdown -->
                                                <div class="col-xxl-3 col-md-4 mt-3">
                                                    <div>
                                                        <label for="code" class="form-label">Country</label>
                                                        <select class="form-control select2" id="country_id" name="country_id" required>
                                                            <option value="" selected disabled>Choose Country</option>
                                                            @foreach ($countries as $country)
                                                            <option value="{{ $country->id ?? '' }}" >
                                                                {{ $country->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Region Dropdown -->
                                                <div class="col-xxl-3 col-md-4 mt-3">
                                                    <div>
                                                        <label for="code" class="form-label">Region</label>
                                                        <select class="form-control select2" name="region_id" id="region_id" required>
                                                            <option value="" selected disabled>Choose Region</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- District Dropdown -->
                                                <div class="col-xxl-3 col-md-4 mt-3">
                                                    <div>
                                                        <label for="code" class="form-label">District</label>
                                                        <select class="form-control select2" name="district_id" id="district_id" required>
                                                            <option value="" selected disabled>Choose District</option>
                                                        </select>
                                                    </div>
                                                </div>
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
   $('#index_no').on('change', function() {
    // Get the selected option
    const applicant_user_id = $(this).find(':selected').data('applicant_user_id');
    const application_category_id = $(this).find(':selected').data('application_category_id');

    // Set the applicant_user_id and application_category_id in their respective inputs
    $('#applicant_user_id').val(applicant_user_id || '');
    $('#application_category_id').val(application_category_id || '');

    // Check if application_category_id exists before making the AJAX request
    if (application_category_id) {
        $.ajax({
            url: 'get-education-levels/' + application_category_id,  // Pass the correct application_category_id
            type: 'GET',
            success: function(response) {
                console.log('Education Levels:', response);  // Debugging response
                $('#education_level').empty().append('<option value="" selected disabled>Choose Level</option>');
                response.forEach(function(educationLevel) {
                    $('#education_level').append('<option value="' + educationLevel.id + '">' + educationLevel.name + '</option>');
                });

                $('#education_level').select2('destroy').select2({
                    placeholder: 'Select Level',
                    allowClear: true,
                });
            },
            error: function(xhr, status, error) {
                console.log("Error fetching education levels:", error);
                console.log("Response:", xhr.responseText);  // Log the response from the server
            }
        });
    }
});

</script>
<script>
     
    function capitalizeOnlyFirstLetter(input) {
        // Capitalize the first letter and make the rest lowercase
        input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1).toLowerCase();
    }

    $(document).ready(function () {
    $('.select2').select2({
        placeholder: 'Select an option',
        allowClear: true,
    });
     // Handle country change
     $('#country_id').change(function () {
        const country_id = $(this).val();

        if (country_id) {
            $.ajax({
                url: '{{ url("get-regions") }}/' + country_id,
                type: 'GET',
                success: function (data) {
                    $('#region_id').empty().append('<option value="" selected disabled>Choose Region</option>');
                    $.each(data, function (key, region) {
                        $('#region_id').append('<option value="' + region.id + '">' + region.name + '</option>');
                    });
                },
                error: function () {
                    alert('Failed to load regions. Please try again.');
                },
            });
        } else {
            $('#region_id').empty().append('<option value="" selected disabled>Choose Region</option>');
        }
    });

     // Handle region change
     $('#region_id').change(function () {
        const region_id = $(this).val();
        if (region_id) {
            $.ajax({
                url: '{{ url("get-districts") }}/' + region_id,
                type: 'GET',
                success: function (data) {
                    $('#district_id').empty().append('<option value="" selected disabled>Choose District</option>');
                    $.each(data, function (key, district) {
                        $('#district_id').append('<option value="' + district.id + '">' + district.name + '</option>');
                    });
                },
                error: function () {
                    alert('Failed to load districts. Please try again.');
                },
            });
        } else {
            $('#district_id').empty().append('<option value="" selected disabled>Choose District</option>');
        }
    });

});
</script>
@endsection
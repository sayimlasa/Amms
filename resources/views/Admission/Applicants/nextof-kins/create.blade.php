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
                            <h6 class=" mb-0 flex-grow-1">Create Kin Information</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('nextof-kins.store') }}">
                                   @csrf
                                    <div class="row g-4">
                                        <div>
                                            <h5 class="fs-14 text-muted">Kin Information</h5>
                                            <div class="row">
                                                <div class="col-xxl-3 col-md-4 mt-3">
                                                    <div>
                                                        <label for="index_no" class="form-label">Applicant Index Number</label>
                                                        <select class="form-control select2" id="index_no" name="index_no" required>
                                                            <option value="" selected disabled>Choose Applicant</option>
                                                            @foreach ($applicants as $applicant)
                                                                <option value="{{ $applicant->index_no . ',' . $applicant->applicant_user_id }}">
                                                                    {{ $applicant->index_no }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="name" class="form-label">First Name</label>
                                                        <input type="text" class="form-control" id="fname" name="fname" oninput="capitalizeOnlyFirstLetter(this)" required>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="name" class="form-label">Middle Name</label>
                                                        <input type="text" class="form-control" id="mname" name="mname"  oninput="capitalizeOnlyFirstLetter(this)" required>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3 ">
                                                    <div>
                                                        <label for="name" class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" id="lname" name="lname"  oninput="capitalizeOnlyFirstLetter(this)" required>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="mobile_no" class="form-label">Mobile</label>
                                                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" required>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="nationality" class="form-label">Nationality</label>
                                                        <select class="form-control select2" name="nationality" id="nationality" required>
                                                            <option value="" selected disabled>Select Nationality</option>
                                                            @foreach ($nationalities as $nationality)
                                                            <option value="{{ $nationality->id }}">
                                                                {{ $nationality->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="relationship_id" class="form-label">Relationship</label>
                                                        <select class="form-control select2" name="relationship_id" id="relationship_id" required>
                                                            <option value="" selected disabled>Select Relationship</option>
                                                            @foreach ($relationships as $relationship)
                                                            <option value="{{ $relationship->id }}">
                                                                {{ $relationship->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border-top"></div>
                                        <div>
                                            <h5 class="fs-14 text-muted">Place of domicile</h5>
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
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="physical_address" class="form-label">Physical Address</label>
                                                        <input class="form-control" type="text" placeholder="P.o.box 277 arusha" name="physical_address" id="physical_address" oninput="capitalizeOnlyFirstLetter(this)" required>
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
     document.getElementById('mobile_no').addEventListener('input', function() {
        const mobileInput = this.value;
        const mobilePattern = /^0\d{9,14}$/;

        if (!mobilePattern.test(mobileInput)) {
            this.setCustomValidity('Mobile number must start with 0 and have 10 to 15 digits.');
        } else {
            this.setCustomValidity(''); // Clear error message if valid
        }
    });
    flatpickr('.datepicker', {
        dateFormat: "Y-m-d",
    });

    function capitalizeOnlyFirstLetter(input) {
        // Capitalize the first letter and make the rest lowercase
        input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1).toLowerCase();
    }

    $(document).ready(function() {

        // Array of objects with IDs and their placeholders for select2 initialization
        const select2Elements = [{
                id: '#cob_id',
                placeholder: 'Choose a country'
            },
            {
                id: '#pob_id',
                placeholder: 'Choose a region'
            },
            {
                id: '#dob_id',
                placeholder: 'Choose a district'
            },
            {
                id: '#country_id',
                placeholder: 'Choose a country'
            },
            {
                id: '#region_id',
                placeholder: 'Choose a region'
            },
            {
                id: '#district_id',
                placeholder: 'Choose a district'
            },
            {
                id: '#nationality',
                placeholder: 'Choose a nationality'
            }
        ];

        // Loop through each element and initialize select2
        select2Elements.forEach(function(element) {
            $(element.id).select2({
                placeholder: element.placeholder, // Set the placeholder dynamically
                allowClear: true
            });
        });

    });

    $(document).ready(function () {
        $('#country_id').change(function () {
        const country_id = $(this).val();
        if (country_id) {
            $.ajax({
                url: '{{ url("get-regions") }}/' + country_id,
                type: 'GET',
                success: function (data) {
                    // Clear and populate the region dropdown
                    $('#region_id').empty().append('<option value="" selected disabled>Choose Region</option>');
                    $.each(data, function (key, region) {
                        $('#region_id').append('<option value="' + region.id + '">' + region.name + '</option>');
                    });

                    // Set selected value for editing
                    const selectedRegionId = '{{ $applicantsInfo->region->id ?? '' }}';
                    if (selectedRegionId) {
                        $('#region_id').val(selectedRegionId).trigger('change');
                    }
                },
                error: function () {
                    alert('Failed to load regions. Please try again.');
                },
            });
        } else {
            $('#region_id').empty().append('<option value="" selected disabled>Choose Region</option>');
        }
    });
    // Handle country change
    $('#cob_id').change(function () {
        const cob_id = $(this).val();
        if (cob_id) {
            $.ajax({
                url: '{{ url("get-regions") }}/' + cob_id,
                type: 'GET',
                success: function (data) {
                    // Clear and populate the region dropdown
                    $('#pob_id').empty().append('<option value="" selected disabled>Choose Region</option>');
                    $.each(data, function (key, region) {
                        $('#pob_id').append('<option value="' + region.id + '">' + region.name + '</option>');
                    });

                    // Set selected value for editing
                    const selectedRegionId = '{{ $applicantsInfo->placeOfBirth->id ?? '' }}';
                    if (selectedRegionId) {
                        $('#pob_id').val(selectedRegionId).trigger('change');
                    }
                },
                error: function () {
                    alert('Failed to load regions. Please try again.');
                },
            });
        } else {
            $('#pob_id').empty().append('<option value="" selected disabled>Choose Region</option>');
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
                    // Clear and populate the district dropdown
                    $('#district_id').empty().append('<option value="" selected disabled>Choose District</option>');
                    $.each(data, function (key, district) {
                        $('#district_id').append('<option value="' + district.id + '">' + district.name + '</option>');
                    });

                    // Set selected value for editing
                    const selectedDistrictId = '{{ $applicantsInfo->district->id ?? '' }}';
                    if (selectedDistrictId) {
                        $('#district_id').val(selectedDistrictId).trigger('change');
                    }
                },
                error: function () {
                    alert('Failed to load districts. Please try again.');
                },
            });
        } else {
            $('#district_id').empty().append('<option value="" selected disabled>Choose District</option>');
        }
    });
    $('#pob_id').change(function () {
        const pob_id = $(this).val();
        if (pob_id) {
            $.ajax({
                url: '{{ url("get-districts") }}/' + pob_id,
                type: 'GET',
                success: function (data) {
                    // Clear and populate the district dropdown
                    $('#dob_id').empty().append('<option value="" selected disabled>Choose District</option>');
                    $.each(data, function (key, district) {
                        $('#dob_id').append('<option value="' + district.id + '">' + district.name + '</option>');
                    });

                    // Set selected value for editing
                    const selectedDistrictId = '{{ $applicantsInfo->districtOfBirth->id ?? '' }}';
                    if (selectedDistrictId) {
                        $('#dob_id').val(selectedDistrictId).trigger('change');
                    }
                },
                error: function () {
                    alert('Failed to load districts. Please try again.');
                },
            });
        } else {
            $('#dob_id').empty().append('<option value="" selected disabled>Choose District</option>');
        }
    });

    if ($('#cob_id').val()) {
        $('#cob_id').trigger('change');
    }
    if ($('#pob_id').val()) {
        $('#pob_id').trigger('change');
    }
    // Trigger change events if editing
    if ($('#country_id').val()) {
        $('#country_id').trigger('change');
    }
    if ($('#region_id').val()) {
        $('#region_id').trigger('change');
    }

    $('#employment_status').change(function () {
        var employmentStatusId = $(this).val();

        if (employmentStatusId) {
            // AJAX request to fetch employers based on employment status
            $.ajax({
                url: '{{ url("get-employers") }}/' + employmentStatusId,
                type: 'GET',
                success: function (data) {
                    // Empty the employer dropdown
                    $('#employer_id').empty();

                    // Add a default option
                    $('#employer_id').append('<option value="" selected disabled>Select Employer</option>');

                    // Populate the dropdown with employers
                    $.each(data, function (key, employer) {
                        $('#employer_id').append('<option value="' + employer.id + '">' + employer.name + '</option>');
                    });

                    // Pre-select the employer if editing
                    var selectedEmployerId = '{{ $applicantsInfo->employer->id ?? '' }}';
                    if (selectedEmployerId) {
                        $('#employer_id').val(selectedEmployerId).trigger('change');
                    }
                },
                error: function () {
                    console.error('Failed to fetch employers.');
                }
            });
        } else {
            // Clear the employer dropdown if no employment status is selected
            $('#employer_id').empty().append('<option value="" selected disabled>Select Employer</option>');
        }
    });

    // Trigger change event on page load if editing
    var preSelectedEmploymentStatus = '{{ $applicantsInfo->employmentStatus->id ?? '' }}';
    if (preSelectedEmploymentStatus) {
        $('#employment_status').val(preSelectedEmploymentStatus).trigger('change');
    }
});
 //script for select2

    //script for select2
</script>
@endsection
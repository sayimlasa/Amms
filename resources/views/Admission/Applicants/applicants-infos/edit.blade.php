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
                            <h6 class=" mb-0 flex-grow-1">Update Applicant Information</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST"
                                    action="{{ route('applicants-infos.update', $applicantsInfo->id) }}">
                                    @method('PUT')
                                    @csrf
                                    <div class="row g-4">
                                        <div>
                                            <h5 class="fs-14 text-muted">Personal Information</h5>
                                            <div class="row">
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="name" class="form-label">Index Number</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $applicantsInfo->index_no) }}" oninput="capitalizeOnlyFirstLetter(this)" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="name" class="form-label">First Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('fname', $applicantsInfo->fname) }}" oninput="capitalizeOnlyFirstLetter(this)" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="name" class="form-label">Middle Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('mname', $applicantsInfo->mname) }}" oninput="capitalizeOnlyFirstLetter(this)" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3 ">
                                                    <div>
                                                        <label for="name" class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('lname', $applicantsInfo->lname) }}" oninput="capitalizeOnlyFirstLetter(this)" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="name" class="form-label">Gender</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('gender', $applicantsInfo->gender) }}" oninput="capitalizeOnlyFirstLetter(this)" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="mobile_no" class="form-label">Mobile</label>
                                                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="{{ old('mobile_no', $applicantsInfo->applicantUser->mobile_no) }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="birth_date" class="form-label">Date of Birth</label>
                                                        <input type="date" class="form-control datepicker"
                                                            id="birth_date" name="birth_date"
                                                            value="{{ old('birth_date', $applicantsInfo->birth_date) }}"
                                                            placeholder="yyyy-mm-dd" required>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="nationality" class="form-label">Nationality</label>
                                                        <select class="form-control select2" name="nationality"
                                                            id="nationality" required>
                                                            <option value="" selected disabled>Select Nationality
                                                            </option>
                                                            @foreach ($nationalities as $nationality)
                                                            <option value="{{ $nationality->id }}" {{ old('nationality', $applicantsInfo->nationalit->id ?? '') == $nationality->id ? 'selected' : '' }}>
                                                                {{ $nationality->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border-top"></div>
                                        <div>
                                            <h5 class="fs-14 text-muted">Place of Birth</h5>
                                            <div class="row">
                                                <!-- Country Dropdown -->
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="cob_id" class="form-label">Country</label>
                                                        <select class="form-control select2" name="cob_id" id="cob_id"
                                                            required>
                                                            <option value="" selected disabled>Select Country</option>
                                                            @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}" {{ old('cob_id',
                                                                $applicantsInfo->countryOfBirth->id ?? '') ==
                                                                $country->id ? 'selected' : '' }}>
                                                                {{ $country->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Region Dropdown -->
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="pob_id" class="form-label">Region</label>
                                                        <select class="form-control select2" name="pob_id" id="pob_id"
                                                            required>
                                                            <option value="" selected disabled>Select Region</option>
                                                            @if ($applicantsInfo->placeOfBirth)
                                                            <option value="{{ $applicantsInfo->placeOfBirth->id }}"
                                                                selected>
                                                                {{ $applicantsInfo->placeOfBirth->name }}
                                                            </option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- District Dropdown -->
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="dob_id" class="form-label">District</label>
                                                        <select class="form-control select2" name="dob_id" id="dob_id"
                                                            required>
                                                            <option value="" selected disabled>Select District</option>
                                                            @if ($applicantsInfo->districtOfBirth)
                                                            <option value="{{ $applicantsInfo->districtOfBirth->id }}"
                                                                selected>
                                                                {{ $applicantsInfo->districtOfBirth->name }}
                                                            </option>
                                                            @endif
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
                                                            <option value="{{ $country->id ?? '' }}"
                                                                {{ old('country_id', optional($applicantsInfo->countryOfBirth)->id) == $country->id ? 'selected' : '' }}>
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
                                                            @if ($applicantsInfo->region)
                                                            <option value="{{ $applicantsInfo->region->id }}" selected>{{ $applicantsInfo->placeOfBirth->name }}</option>
                                                            @else
                                                            <option value="" selected disabled>Choose Region</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- District Dropdown -->
                                                <div class="col-xxl-3 col-md-4 mt-3">
                                                    <div>
                                                        <label for="code" class="form-label">District</label>
                                                        <select class="form-control select2" name="district_id" id="district_id" required>
                                                            @if ($applicantsInfo->districtOfBirth)
                                                            <option value="{{ $applicantsInfo->districtOfBirth->id }}" selected>{{ $applicantsInfo->districtOfBirth->name }}</option>
                                                            @else
                                                            <option value="" selected disabled>Choose District</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="physical_address" class="form-label">Physical Address</label>
                                                        <input class="form-control" type="text" placeholder="P.o.box 277 arusha" name="physical_address" id="physical_address" value="{{ old('physical_address', $applicantsInfo->physical_address) }}" oninput="capitalizeOnlyFirstLetter(this)" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border-top"></div>
                                        <div>
                                            <h5 class="fs-14 text-muted">Employment</h5>
                                            <div class="row">
                                                <!-- Region Dropdown -->
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="employment_status" class="form-label">Employment Status</label>
                                                        <select class="form-control select2" name="employment_status" id="employment_status" required>
                                                            <option value="" selected disabled>Select Employment Status</option>
                                                            @foreach ($employmentStatuses as $employmentStatus)
                                                            <option
                                                                value="{{ $employmentStatus->id }}"
                                                                {{ old('employment_status', $applicantsInfo->employmentStatus->id ?? '') == $employmentStatus->id ? 'selected' : '' }}>
                                                                {{ $employmentStatus->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="employer_id" class="form-label">Employer</label>
                                                        <select class="form-control select2" name="employer_id" id="employer_id">
                                                            <option value="" selected disabled>Select Employer</option>
                                                            @if ($applicantsInfo->employer)
                                                            <option
                                                                value="{{ $applicantsInfo->employer->id }}"
                                                                selected>
                                                                {{ $applicantsInfo->employer->name }}
                                                            </option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="border-top"></div>
                                        <div>
                                            <h5 class="fs-14 text-muted">Campus & Intake</h5>
                                            <div class="row">
                                                <!-- Country Dropdown -->
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="campus_id" class="form-label">Campus</label>

                                                        <select class="form-control select2" name="campus_id" id="campus_id" disabled>
                                                            <option value="" selected disabled>Select Campus</option>
                                                            @foreach ($campuses as $campus)
                                                            <option
                                                                value="{{ $campus->id }}"
                                                                {{ old('campus_id"', $applicantsInfo->campus->id ?? '') == $campus->id ? 'selected' : '' }}>
                                                                {{ $campus->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Region Dropdown -->
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="intake_id" class="form-label">Intake</label>

                                                        <select class="form-control select2" name="intake_id" id="intake_id" disabled>
                                                            <option value="" selected disabled>Select Intake</option>
                                                            @foreach ($intakes as $intake)
                                                            <option
                                                                value="{{ $intake->id }}"
                                                                {{ old('intake_id"', $applicantsInfo->intake->id ?? '') == $intake->id ? 'selected' : '' }}>
                                                                {{ $intake->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border-top"></div>
                                        <div>
                                            <h5 class="fs-14 text-muted">Disability</h5>
                                            <div class="row">
                                                <!-- Country Dropdown -->
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="disability_id" class="form-label">Disability</label>

                                                        <select class="form-control select2" name="disability_id" id="disability_id" required>
                                                            <option value="" selected disabled>Select Disability</option>
                                                            @foreach ($disabilities as $disability)
                                                            <option
                                                                value="{{ $disability->id }}"
                                                                {{ old('disability_id"', $applicantsInfo->disability->id ?? '') == $disability->id ? 'selected' : '' }}>
                                                                {{ $disability->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="marital_status_id" class="form-label">Marital Status</label>

                                                        <select class="form-control select2" name="marital_status_id" id="marital_status_id" required>
                                                            <option value="" selected disabled>Select Marital Status</option>
                                                            @foreach ($maritalStatuses as $maritalStatus)
                                                            <option
                                                                value="{{ $maritalStatus->id }}"
                                                                {{ old('marital_status_id"', $applicantsInfo->maritalStatus->id ?? '') == $maritalStatus->id ? 'selected' : '' }}>
                                                                {{ $maritalStatus->name }}
                                                            </option>
                                                            @endforeach
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
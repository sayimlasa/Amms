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
                            <h6 class=" mb-0 flex-grow-1">Edit Kin Information</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('nextof-kins.update', $nextOfKin->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-4">
                                        <!-- Kin Information -->
                                        <h5 class="fs-14 text-muted">Kin Information</h5>
                                        <div class="row">
                                            <div class="col-xxl-3 col-md-4 mt-3">
                                                <label for="index_no" class="form-label">Applicant Index Number</label>
                                                <select class="form-control select2" id="index_no" name="index_no" disabled>
                                                    <option value="" disabled>Choose Applicant</option>
                                                    @foreach ($applicants as $applicant)
                                                    <option value="{{ $applicant->index_no . ',' . $applicant->applicant_user_id }}"
                                                        {{ $applicant->index_no == $nextOfKin->index_no ? 'selected' : '' }}>
                                                        {{ $applicant->index_no }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- First Name -->
                                            <div class="col-xxl-4 col-md-4 mt-3">
                                                <label for="fname" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="fname" name="fname"
                                                    value="{{ old('fname', $nextOfKin->fname) }}" required>
                                            </div>
                                            <!-- Middle Name -->
                                            <div class="col-xxl-4 col-md-4 mt-3">
                                                <label for="mname" class="form-label">Middle Name</label>
                                                <input type="text" class="form-control" id="mname" name="mname"
                                                    value="{{ old('mname', $nextOfKin->mname) }}">
                                            </div>
                                            <!-- Last Name -->
                                            <div class="col-xxl-4 col-md-4 mt-3">
                                                <label for="lname" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="lname" name="lname"
                                                    value="{{ old('lname', $nextOfKin->lname) }}" required>
                                            </div>
                                            <!-- Mobile Number -->
                                            <div class="col-xxl-4 col-md-4 mt-3">
                                                <label for="mobile_no" class="form-label">Mobile</label>
                                                <input type="text" class="form-control" id="mobile_no" name="mobile_no"
                                                    value="{{ old('mobile_no', $nextOfKin->mobile_no) }}" required>
                                            </div>
                                            <!-- Nationality -->
                                            <div class="col-xxl-4 col-md-4 mt-3">
                                                <label for="nationality" class="form-label">Nationality</label>
                                                <select class="form-control select2" name="nationality" id="nationality" required>
                                                    @foreach ($nationalities as $nationality)
                                                    <option value="{{ $nationality->id }}"
                                                        {{ $nationality->id == $nextOfKin->nationality ? 'selected' : '' }}>
                                                        {{ $nationality->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Relationship -->
                                            <div class="col-xxl-4 col-md-4 mt-3">
                                                <label for="relationship_id" class="form-label">Relationship</label>
                                                <select class="form-control select2" name="relationship_id" id="relationship_id" required>
                                                    @foreach ($relationships as $relationship)
                                                    <option value="{{ $relationship->id }}"
                                                        {{ $relationship->id == $nextOfKin->relationship_id ? 'selected' : '' }}>
                                                        {{ $relationship->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Place of Domicile -->
                                        <h5 class="fs-14 text-muted mt-4">Place of Domicile</h5>
                                        <div class="row">
                                            <!-- Country -->
                                            <div class="col-xxl-3 col-md-4 mt-3">
                                                <label for="country_id" class="form-label">Country</label>
                                                <select class="form-control select2" id="country_id" name="country_id" required>
                                                    @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $country->id == $nextOfKin->country_id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                             <!-- Region Dropdown -->
                                             <div class="col-xxl-3 col-md-4 mt-3">
                                                    <div>
                                                        <label for="code" class="form-label">Region</label>
                                                        <select class="form-control select2" name="region_id" id="region_id" required>
                                                            @if ($nextOfKin->region)
                                                            <option value="{{ $nextOfKin->region->id }}" selected>{{ $nextOfKin->region->name }}</option>
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
                                                            @if ($nextOfKin->districtOfBirth)
                                                            <option value="{{ $nextOfKin->district->id }}" selected>{{ $nextOfKin->district->name }}</option>
                                                            @else
                                                            <option value="" selected disabled>Choose District</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            <!-- Physical Address -->
                                            <div class="col-xxl-4 col-md-4 mt-3">
                                                <label for="physical_address" class="form-label">Physical Address</label>
                                                <input type="text" class="form-control" id="physical_address" name="physical_address"
                                                    value="{{ old('physical_address', $nextOfKin->physical_address) }}" required>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-12 text-end mt-4">
                                            <button type="submit" class="btn btn-success">Update</button>
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
    $(document).ready(function () {
        // Initialize Select2
        $('.select2').select2({
            allowClear: true,  // Allow clearing the selection
            placeholder: "Choose an option"  // Set a placeholder for all select2 dropdowns
        });

        // Handle country change event
        $('#country_id').change(function () {
            const country_id = $(this).val();
            if (country_id) {
                $.ajax({
                    url: '{{ url("get-regions") }}/' + country_id,
                    type: 'GET',
                    success: function (data) {
                        // Clear and repopulate the region dropdown
                        $('#region_id').empty().append('<option value="" selected disabled>Choose Region</option>');
                        $.each(data, function (key, region) {
                            $('#region_id').append('<option value="' + region.id + '">' + region.name + '</option>');
                        });

                        // Reinitialize Select2 for the region dropdown
                        $('#region_id').select2({
                            allowClear: true
                        });

                        // Set the selected region if available
                        const selectedRegionId = '{{ $nextOfKin['region_id'] ?? '' }}';
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

        // Handle region change event
        $('#region_id').change(function () {
            const region_id = $(this).val();
            if (region_id) {
                $.ajax({
                    url: '{{ url("get-districts") }}/' + region_id,
                    type: 'GET',
                    success: function (data) {
                        // Clear and repopulate the district dropdown
                        $('#district_id').empty().append('<option value="" selected disabled>Choose District</option>');
                        $.each(data, function (key, district) {
                            $('#district_id').append('<option value="' + district.id + '">' + district.name + '</option>');
                        });

                        // Reinitialize Select2 for the district dropdown
                        $('#district_id').select2({
                            allowClear: true
                        });

                        // Set the selected district if available
                        const selectedDistrictId = '{{ $nextOfKin['district_id'] ?? '' }}';
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

        // Trigger initial load for the selected country if already set
        if ($('#country_id').val()) {
            $('#country_id').trigger('change');
        }

        // Trigger initial load for the selected region if already set
        if ($('#region_id').val()) {
            $('#region_id').trigger('change');
        }
    });
</script>

@endsection
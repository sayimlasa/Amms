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
                            <h6 class=" mb-0 flex-grow-1">New District</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('districts.update', $district->id) }}">
                                    @method('PUT')
                                    @csrf
                                    <div class="row g-4">
                                        <!-- Name Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="name" class="form-label">District Name</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    name="name"
                                                    value="{{ old('name', $district->name) }}"
                                                    placeholder="Enter District Name"
                                                    oninput="capitalizeOnlyFirstLetter(this)"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- Country Dropdown -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="country_id" class="form-label">Country</label>
                                                <select class="form-control select2" name="country_id" id="country_id" required>
                                                    <option value="" selected disabled>Select Country</option>
                                                    @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}" {{ old('country_id', $district->region_state->country->id) == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Region Dropdown -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="region_id" class="form-label">Region</label>
                                                <select class="form-control select2" name="region_state_id" id="region_id" required>
                                                    <option value="" selected disabled>Select Region</option>
                                                    @if ($district->region)
                                                    <option value="{{ $district->region->id }}" selected>{{ $district->region->name }}</option>
                                                    @endif
                                                </select>
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
    function capitalizeOnlyFirstLetter(input) {
        // Capitalize the first letter and make the rest lowercase
        input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1).toLowerCase();
    }

    $(document).ready(function() {
        $('#country_id').select2({
            placeholder: "Choose a country",
            allowClear: true
        });
    });
    $(document).ready(function() {
        $('#region_id').select2({
            allowClear: true
        });
    });

    $(document).ready(function() {
        // When the country is selected
        $('#country_id').change(function() {
            var country_id = $(this).val();
            if (country_id) {
                // AJAX request to get regions for the selected country
                $.ajax({
                    url: '{{ url("get-regions") }}/' + country_id,
                    type: 'GET',
                    success: function(data) {
                        // Empty the region select
                        $('#region_id').empty();

                        // Add a default option for the region
                        $('#region_id').append('<option value="" selected disabled>Choose Region</option>');

                        // Populate region select with data from the response
                        $.each(data, function(key, region) {
                            $('#region_id').append('<option value="' + region.id + '">' + region.name + '</option>');
                        });

                        // Set the selected region for editing
                        var selectedRegionId = '{{ $district->region_state_id ?? '
                        ' }}';
                        if (selectedRegionId) {
                            $('#region_id').val(selectedRegionId).trigger('change');
                        }
                    }
                });
            } else {
                // If no country is selected, clear the region select
                $('#region_id').empty();
            }
        });

        // Trigger change event to load regions when the form loads (if editing)
        if ($('#country_id').val()) {
            $('#country_id').trigger('change');
        }
    });
</script>
@endsection
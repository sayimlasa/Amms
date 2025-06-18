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
                                <form method="POST" action="{{route('districts.store')}}">
                                    @csrf
                                    <div class="row g-4">
                                        <!-- Name Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="start_date" class="form-label">District Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Arusha" oninput="capitalizeOnlyFirstLetter(this)" required>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="code" class="form-label">Country</label>
                                                <select class="form-control select2" id="country_id" required>
                                                    <option value="" selected disabled></option>
                                                    @foreach ( $countries as $country)
                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="code" class="form-label">Region</label>
                                                <select class="form-control select2" name="region_state_id" id="region_id" required>
                                                  
                                                </select>

                                            </div>
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

    $(document).ready(function () {
            // When the country is selected
            $('#country_id').change(function () {
                var country_id = $(this).val();
                if (country_id) {
                    // AJAX request to get regions for the selected country
                    $.ajax({
                        url: '{{ url("get-regions") }}/' + country_id,
                        type: 'GET',
                        success: function (data) {
                            // Empty the region select
                            $('#region_id').empty();

                            // Add a default option for the region
                            $('#region_id').append('<option value="" selected disabled>Choose Region</option>');

                            // Populate region select with data from the response
                            $.each(data, function (key, region) {
                                $('#region_id').append('<option value="' + region.id + '">' + region.name + '</option>');
                            });

                            // Reinitialize Select2 after dynamic changes
                            $('#region_id').trigger('change'); // Re-initialize select2
                        }
                    });
                } else {
                    // If no country is selected, clear the region select
                    $('#region_id').empty();
                }
            });
        });
</script>
@endsection
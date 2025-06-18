@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    </section>
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
                            <h6 class=" mb-0 flex-grow-1">Add TutionFees</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{route('payment.setting.store')}}">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="application_level_id" class="form-label">Level</label>
                                                <select class="form-control select2" name="application_level_id" id="application_level_id" required>
                                                    @foreach ( $levels as $level)
                                                    <option value="{{$level->id}}">{{$level->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="name" class="form-label">Amount</label>
                                                <input type="text" class="form-control" id="name" name="amount" placeholder="" oninput="capitalizeOnlyFirstLetter(this)" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="computing" class="form-label">Is Computing?</label>
                                                <div class="form-check">
                                                    <input type="hidden" name="computing" value="0">
                                                    <input class="form-check-input" type="checkbox" id="computing" name="computing" value="1" {{ old('computing', 0) == 1 ? 'checked' : '' }}>
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
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
    function capitalizeOnlyFirstLetter(input) {
        // Capitalize the first letter and make the rest lowercase
        input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1).toLowerCase();
    }

    function capitalizeAllLetters(input) {
        // Convert the entire input value to uppercase
        input.value = input.value.toUpperCase();
    }
    document.addEventListener('DOMContentLoaded', function() {
        const intakeSelect = document.getElementById('intake_id');
        const campuSelect = document.getElementById('campus_id');

        new Choices(intakeSelect, {
            removeItemButton: true, // Allows deselecting an option with a close button
            searchEnabled: true,
        });
        new Choices(campuSelect, {
            removeItemButton: true, // Allows deselecting an option with a close button
            searchEnabled: true,
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // When the faculty is selected
        $('#faculty_id').change(function() {
            var faculty_id = $(this).val();
            if (faculty_id) {
                // AJAX request to get departments for the selected faculty
                $.ajax({
                    url: '{{ url("get-departments") }}/' + faculty_id,
                    type: 'GET',
                    success: function(data) {
                        // Empty the department select
                        $('#department_id').empty();

                        // Add a default option for the department
                        $('#department_id').append('<option value="" selected disabled>Choose Department</option>');

                        // Populate department select with data from the response
                        $.each(data, function(key, department) {
                            $('#department_id').append('<option value="' + department.id + '">' + department.name + '</option>');
                        });

                        // Set the selected department for editing
                        var selectedDepartmentId = '{{ $programme->department_id ?? '' }}';
                        if (selectedDepartmentId) {
                            $('#department_id').val(selectedDepartmentId).trigger('change');
                        }
                    }
                });
            } else {
                // If no faculty is selected, clear the department select
                $('#department_id').empty();
            }
        });

        // Trigger change event to load departments when the form loads (if editing)
        if ($('#faculty_id').val()) {
            $('#faculty_id').trigger('change');
        }
    });
</script>
@endsection
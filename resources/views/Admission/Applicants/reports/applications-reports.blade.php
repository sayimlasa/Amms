@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{route('applications-reports')}}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="intake_id" class="form-label">Intake</label>
                        <select class="form-control select2" name="intake_id" id="intake_id">
                            <option value="" selected>All</option>
                            @foreach ($intakes as $intake)
                            <option value="{{ $intake->id }}">{{ $intake->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="application_level_id" class="form-label">Level</label>
                        <select class="form-control select2" name="application_level_id" id="application_level_id">
                            <option value selected>All</option>
                            @foreach ($ntalevels as $ntalevel)
                            <option value="{{ $ntalevel->id }}">{{ $ntalevel->nta_level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="campus_id" class="form-label">Campus</label>
                        <select class="form-control select2" name="campus_id" id="campus_id">
                            <option selected disabled><-- Choose Campus --></option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="faculty_id" class="form-label">Faculty</label>
                        <select class="form-control select2" name="faculty_id" id="faculty_id">
                            <option value="" selected>All</option>
                            @foreach ($faculties as $faculty)
                            <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="department_id" class="form-label">Department</label>
                        <select class="form-control select2" name="department_id" id="department_id">
                            <option selected disabled><-- Choose Department --></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="programme_id" class="form-label">Programme</label>
                        <select class="form-control select2" name="programme_id" id="programme_id">
                            <option selected disabled><-- Choose Programme --></option>

                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-control select2" name="gender" id="gender">
                            <option selected value="">All</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-info">Fetch</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>Application Statistics</h4>
        </div>
        <div class="card-body">
            <table id="applicantsTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>PROGRAMME</th>
                        @foreach($campuses as $campus => $val)
                        <th>{{ strtoupper($campus) }}</th>
                        @endforeach
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programmes as $programme => $data)
                    <tr>
                        <td>{{ $programme }}</td>
                        @foreach($campuses as $campus => $val)
                        <td>{{ $data[$campus] ?? 0 }}</td>
                        @endforeach
                        <td><strong>{{ $data['Total'] }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
@parent
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<!-- Velzon JS -->
<script src="{{('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{('assets/libs/simplebar/simplebar.min.js')}}"></script>

<!-- jsPDF for PDF Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- PapaParse for CSV Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/vfs_fonts.js"></script>
<script>
    $(document).ready(function() {
        $("#applicantsTable").DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
<script>
    $(document).ready(function() {
        // When the faculty is selected
        $('#application_level_id').change(function() {
            var application_level_id = $(this).val();
            if (application_level_id) {
                // AJAX request to get departments for the selected faculty
                $.ajax({
                    url: '{{ url("get-campuses") }}/' + application_level_id,
                    type: 'GET',
                    success: function(data) {
                        // Empty the department select
                        $('#campus_id').empty();

                        // Add a default option for the department
                        $('#campus_id').append('<option value="" selected>All</option>');

                        // Populate department select with data from the response
                        $.each(data, function(key, campus) {
                            $('#campus_id').append('<option value="' + campus.id + '">' + campus.name + '</option>');
                        });
                    }
                });
            } else {
                // If no faculty is selected, clear the department select
                $('#campus_id').empty();
            }
        });

        // Trigger change event to load departments when the form loads (if editing)
        if ($('#application_level_id').val()) {
            $('#application_level_id').trigger('change');
        }
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
                        $('#department_id').append('<option value="" selected>All</option>');

                        // Populate department select with data from the response
                        $.each(data, function(key, department) {
                            $('#department_id').append('<option value="' + department.id + '">' + department.name + '</option>');
                        });
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
        $('#faculty_id').change(function() {
            var faculty_id = $(this).val();
            if (faculty_id) {
                // AJAX request to get departments for the selected faculty
                $.ajax({
                    url: '{{ url("get-programmes-faculty") }}/' + faculty_id,
                    type: 'GET',
                    success: function(data) {
                        // Empty the department select
                        $('#programme_id').empty();

                        // Add a default option for the department
                        $('#programme_id').append('<option value="" selected>All</option>');

                        // Populate department select with data from the response
                        $.each(data, function(key, programme) {
                            $('#programme_id').append('<option value="' + programme.id + '">' + programme.name + '</option>');
                        });
                    }
                });
            } else {
                // If no faculty is selected, clear the department select
                $('#programme_id').empty();
            }
        });

        // Trigger change event to load departments when the form loads (if editing)
        if ($('#faculty_id').val()) {
            $('#faculty_id').trigger('change');
        }

        $('#department_id').change(function() {
            var department_id = $(this).val();
            if (department_id) {
                // AJAX request to get departments for the selected faculty
                $.ajax({
                    url: '{{ url("get-programmes-department") }}/' + department_id,
                    type: 'GET',
                    success: function(data) {
                        // Empty the department select
                        $('#programme_id').empty();

                        // Add a default option for the department
                        $('#programme_id').append('<option value="" selected>All</option>');

                        // Populate department select with data from the response
                        $.each(data, function(key, programme) {
                            $('#programme_id').append('<option value="' + programme.id + '">' + programme.name + '</option>');
                        });
                    }
                });
            } else {
                // If no faculty is selected, clear the department select
                $('#programme_id').empty();
            }
        });

        // Trigger change event to load departments when the form loads (if editing)
        if ($('#department_id').val()) {
            $('#department_id').trigger('change');
        }
    });
</script>
@endsection
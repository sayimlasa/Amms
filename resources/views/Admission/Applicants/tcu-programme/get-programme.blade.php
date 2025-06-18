@extends('layouts.admin')

@section('content')
    <div class="col-sm-12">
        <!-- Display Success and Error Messages -->
        @if (session('success'))
            <div id="success-message" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @php
        // Decode the JSON-encoded string back into an array
        $applicant = json_decode(session('applicant'), true); // 'true' makes it an array
    @endphp
    @if (isset($applicant) && is_array($applicant) && count($applicant) > 0)
            <h5>Get Verified Applicants</h5>
        <table id="example" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Programme Name</th>
                    <th>Programme Code</th>
                    <th>Number Applicants</th>
                </tr>
            </thead>
            @php $count = 0 @endphp
            <tbody>
                @foreach ($applicant as $applicantData)
                    <tr>
                        <td>{{ ++$count }}</td>
                        <td>
                            @php
                            $pname = App\Models\ProgrammeTcu::where('tcu_code', $applicantData['programmecode'])->first();
                            @endphp
                            {{ $pname ? $pname->tcu_name : 'Not Available' }}
                        </td>                        
                        <td>{{ $applicantData['programmecode'] }}</td>
                        <td>{{ $applicantData['total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No confirmed applicants found.</p>
    @endif
@endsection

@section('scripts')
    @parent
    <!-- DataTables CSS and Buttons Extension CSS -->
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons Extension JS -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

    <!-- Required libraries for exporting to Excel, PDF, etc. -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Destroy the existing DataTable if it's already initialized
            if ($.fn.dataTable.isDataTable('#example')) {
                $('#example').DataTable().destroy();
            }

            // Initialize DataTable with export buttons
            $('#example').DataTable({
                dom: 'Bfrtip',  // Specify the layout for DataTables (including buttons)
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'  // Enable CSV, Excel, PDF, and Print buttons
                ]
            });

            // Initialize Select2 for the programme_id select element
            $('#programme_id').select2({
                placeholder: 'Select Programme',  // Set a placeholder for the select input
                allowClear: true                  // Allow the user to clear the selection
            });
        });
    </script>
@endsection

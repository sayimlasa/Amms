@extends('layouts.admin')
@section('content')
<div class="col-sm-12">
    <!-- Success and Error Messages -->
    @if(session('success'))
    <div id="success-message" class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>List Verified Applicants</span>
                        <div class="text-end">
                            <form action="{{ route('certificate.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Update Applicant Status</button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('verification.arusha.store') }}" method="POST">
                            @csrf
                            <div class="row align-items-end">
                                <div class="col-md-2">
                                    <label for="level" class="form-label">Academic Year</label>
                                    <select class="form-control select2" name="year" id="year" required>
                                        <option value="">Select academic year</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="intake" class="form-label">Intake</label>
                                    <select class="form-control select2" name="intake" id="intake_id" required>
                                        <option value="">Select intake</option>
                                        <option value="september">September</option>
                                        <option value="march">March</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="programme_id" class="form-label">Programme Name</label>
                                    <select class="form-control select2" name="programme_id" id="programme_id" required>
                                        <option value="">Select Programme</option>
                                        @foreach ($programme as $program)
                                        <option value="{{ $program->program_id }}" {{ request('programme_id') == $program->program_id ? 'selected' : '' }}>
                                            {{ $program->program_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Verified List</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                <h6 class="mb-0">List of Tamisemi Student</h6>
            </div>
        </div>

        <table id="studentTable" class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>User ID</th>
                    <th>Verification Status</th>
                    <th>Multiple Selection</th>
                    <th>Application Year</th>
                    <th>Intake</th>
                    <th>Eligibility</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
            @if(session('data') && isset(session('data')['params']) && !empty(session('data')['params']))
            @foreach(session('data')['params'] as $item)
                <tr>
                    <td>{{ $item['username'] ?? 'N/A' }}</td>
                    <td>{{ $item['user_id'] ?? 'N/A' }}</td>
                    <td>{{ $item['verification_status'] ?? 'N/A' }}</td>
                    <td>{{ $item['multiple_selection'] ?? 'N/A' }}</td>
                    <td>{{ $item['academic_year'] ?? 'N/A' }}</td>
                    <td>{{ $item['intake'] ?? 'N/A' }}</td>
                    <td>{{ $item['eligibility'] ?? 'N/A' }}</td>
                    <td>{{ $item['remarks'] ?? 'N/A' }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="8">No data available or data is not in the expected format.</td>
                </tr>
                @endif
            </tbody>
        </table>

    </div>
</div>

@endsection

@section('scripts')
@parent
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- DataTables CDN Links -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons Plugin -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 for dropdowns
        $('.select2').select2({
            placeholder: 'Select an option',
            allowClear: true
        });

        // Initialize DataTable with export buttons
        $('#studentTable').DataTable({
            dom: 'Bfrtip', // Add buttons to the DataTable
            buttons: [
                'copy', 'csv', 'excel', 'pdf'
            ]
        });
    });
</script>
@endsection

@extends('layouts.admin')

@section('content')
<div class="col-sm-12">
    <!-- Display Success and Error Messages -->
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

<div class="card">
    <div class="card-header">
        <h6 class="mb-0">List of Unelected Students</h6>
    </div>

    <div class="card-body">
        <!-- Filters for Programme, Campus, and All Columns -->
        <form method="GET" action="{{ route('selected.index') }}">
            <div class="row mb-3">
                <!-- Programme Filter -->
                <div class="col-md-4">
                    <label for="programme_id">Filter by Programme:</label>
                    <select class="form-control select2" name="programme_id" id="programme_id" onchange="this.form.submit()">
                        <option value="">Select Programme</option>
                        @foreach ($programmes as $program)
                        <option value="{{ $program->id }}" {{ request('programme_id') == $program->id ? 'selected' : '' }}>
                            {{ $program->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@parent
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!-- DataTables CDN Links -->
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.0/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#programme_id').select2({
            placeholder: 'Select Programme',
            allowClear: true
        });
        $('#campus_id').select2({
            placeholder: 'Select Campus',
            allowClear: true
        });
        $('#gender').select2({
            placeholder: 'Select Gender',
            allowClear: true
        });

        $('#select-all').on('change', function() {
            const isChecked = this.checked;
            $('input[name="selected_applicants[]"]').prop('checked', isChecked);
        });

        // Hide success/error messages after 5 seconds
        setTimeout(() => {
            $('#success-message, .alert-danger').fadeOut('slow');
        }, 5000);
    });
</script>
@endsection
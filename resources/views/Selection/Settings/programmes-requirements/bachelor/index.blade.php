@extends('layouts.admin')
@section('content')
<div class="col-sm-12">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <a href="{{route('bachelor-requirements.create')}}" class="btn btn-success">New Reqirements</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Bachelor requirements</h6>
    </div>
    <div class="card-body">
    <div class="table-responsive">
    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th hidden>ID</th>
            <th>Application Level</th>
            <th>Qualifying with</th>
            <th>Programme</th>
            <th hidden>Application Level</th>
            <th hidden>Programme Level</th>
            <th >Subjects/Courses</th> <!-- Apply the width here -->
            <th>Min Olevel Pass</th>
            <th>Min Olevel Average</th>
            <th>Min Foundation Gpa</th>
            <th>Min Advance Pass</th>
            <th>Min Advance Aggregate</th>
            <th>Math</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($requirements->groupBy(['application_level_id', 'education_level_id', 'programme_id']) as $applicationLevelId => $educationGroups)
            @foreach($educationGroups as $educationLevelId => $programmeGroups)
                @foreach($programmeGroups as $programmeId => $group)
                    <tr>
                        <td>{{ $loop->parent->parent->iteration }}.{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                        <td hidden>{{ $applicationLevelId }}</td>
                        <td hidden>{{ $educationLevelId }}</td>
                        <td hidden>{{ $programmeId }}</td>
                        <td>{{ $group->first()->applicationLevel->name ?? '' }}</td>
                        <td>{{ $group->first()->educationLevel->name ?? '' }}</td>
                        <td>{{ $group->first()->programme->name ?? '' }}</td>
                        <td  class="text-wrap" style="max-width: 400px;">
                            {{ $group->pluck('subject_course')->unique()->implode(', ') }}
                        </td>
                        <td>{{ $group->first()->min_olevel_pass ?? '-' }}</td>
                        <td>{{ $group->first()->min_olevel_average ?? '-' }}</td>
                        <td>{{ $group->first()->min_foundation_gpa ?? '-' }}</td>
                        <td>{{ $group->first()->min_advance_principle_pass ?? '-' }}</td>
                        <td>{{ $group->first()->min_advance_aggregate_points ?? '-' }}</td>
                        <td scope="row">
                        <div class="form-check">
                            <input class="form-check-input fs-15" type="checkbox" {{ $group->first()->math == 1 ? 'checked' : '' }} disabled>
                        </div>
                    </td>
                        <td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <!-- <li>
                                        <a class="dropdown-item view-item-btn" href="{{ route('requirements.show', $group->first()->id) }}">
                                            <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                        </a>
                                    </li> -->
                                    <li>
                                        <a class="dropdown-item edit-item-btn" href="{{ route('bachelor-requirements.edit', [$applicationLevelId, $educationLevelId, $programmeId]) }}">
                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>


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
<!-- <script>
    $(document).ready(function() {
        $("#applicantsTable").DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script> -->
@endsection
@extends('layouts.admin')

@section('content')
    <div class="col-sm-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
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

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('verify-qualification') }}" class="btn btn-success">Add New Payment</a>
                </div>
            </div>
        </div>
    </section>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Registered List</h6>
        </div>

        <div class="card-body">
            <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                @php $na = 1; @endphp
                <thead>
                    <tr>
                        <th>No</th>
                        <th data-ordering="true" hidden>Id</th>
                        <th data-ordering="true">Index Number</th>
                        <th data-ordering="true">Registration</th>
                        <th data-ordering="true">programme</th>
                        <th data-ordering="true">Bill ID</th>
                        <th data-ordering="true">Control Number</th>
                        <th data-ordering="true">Amount</th>
                        <th data-ordering="true">Intake</th>
                        <th data-ordering="true">Campus</th>
                        <th data-ordering="true">Academic Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registeredpayment as $p)
                        <tr>
                            <td>{{ $na }}</td>
                            <td hidden>{{ $p->id ?? '' }}</td>
                            <td>{{ $p->index_no ?? 'S2993/0020/2025' }}</td>
                            <td>{{ $p->regno ?? 'BTCMM-06-0012-2025	' }}</td>
                            <td>{{ $p->programme_id ?? 'BSC' }}</td>
                            <td>{{ $p->billId ?? 'NA' }}</td>
                            <td>{{ $p->control_no ?? 'NA' }}</td>
                            <td>{{ $p->amount ?? 'NA' }}</td>
                            <td>{{ $p->intake_id ?? 'October' }}</td>
                            <td>{{ $p->campus_id ?? 'Arusha campus' }}</td>
                            <td>{{ $p->academic_year_id ?? '2024/2025' }}</td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item view-item-btn"
                                                href="{{ route('payment.setting.edit', $p->id) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item edit-item-btn"
                                                href="{{ route('payment.setting.edit', $p->id) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('payment.setting.delete', $p->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item remove-item-btn">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @php $na++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            if (!$.fn.dataTable.isDataTable('#example')) {
                $('#example').DataTable({
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copy',
                            text: 'Copy'
                        },
                        {
                            extend: 'csv',
                            text: 'CSV'
                        },
                        {
                            extend: 'excel',
                            text: 'Excel'
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF'
                        },
                        {
                            extend: 'print',
                            text: 'Print'
                        }
                    ]
                });
            }
        });
    </script>
@endsection

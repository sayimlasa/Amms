@extends('layouts.admin')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($expiredCount > 0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Notice:</strong> {{ $expiredCount }} asset(s) have expired warranties.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($expiringSoonCount > 0)
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Reminder:</strong> {{ $expiringSoonCount }} asset(s) will expire in 2 days.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form method="GET" action="{{ route('ac-assets.index') }}" class="mb-4 row g-3">
    <div class="col-md-4">
        <label for="start_date" class="form-label">Start Date</label>
        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
    </div>
    <div class="col-md-4">
        <label for="end_date" class="form-label">End Date</label>
        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary me-2">Filter</button>
        <a href="{{ route('ac-assets.index') }}" class="btn btn-secondary">Reset</a>
    </div>
</form>

@if(request('start_date') && request('end_date'))
    <div class="alert alert-info">
        Showing assets with warranty expiry between 
        <strong>{{ request('start_date') }}</strong> and 
        <strong>{{ request('end_date') }}</strong>.
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h6 class="mb-0">AC Asset List</h6>
    </div>
    <div class="card-body">
        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
            <thead class="table-light">
                @php $na = 1; @endphp
                <tr>
                    <th>#</th>
                    <th>Serial Number</th>
                    <th>Model</th>
                    <th>Type</th>
                    <th>Condition</th>
                    <th>Status</th>
                    <th>Location</th>
                    <th>Warranty Expiry Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($assets && count($assets) > 0)
                    @foreach ($assets as $asset)
                        @php
                            $warrantyDate = $asset->warranty_expiry_date ? \Carbon\Carbon::parse($asset->warranty_expiry_date) : null;
                            $isExpired = $warrantyDate && $warrantyDate->lt(now());
                            $isExpiringSoon = $warrantyDate && $warrantyDate->isSameDay(now()->addDays(2));
                        @endphp
                        <tr @if($isExpired) class="table-danger" @elseif($isExpiringSoon) class="table-warning" @endif>
                            <td>{{ $na++ }}</td>
                            <td>{{ $asset->serial_number ?? '-' }}</td>
                            <td>{{ $asset->model ?? '-' }}</td>
                            <td>{{ $asset->type ?? '-' }}</td>
                            <td>{{ $asset->condition ?? '-' }}</td>
                            <td>{{ $asset->status ?? '-' }}</td>
                            <td>{{ $asset->location->name ?? '-' }}</td>
                            <td>
                                {{ $asset->warranty_expiry_date ?? '-' }}
                                @if($isExpired)
                                    <span class="badge bg-danger ms-1">Expired</span>
                                @elseif($isExpiringSoon)
                                    <span class="badge bg-warning text-dark ms-1">Expiring Soon</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item view-item-btn"
                                               href="{{ route('ac-assets.show', ['ac_asset' => $asset->id]) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                Track History
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center">No assets found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
@parent

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', className: 'btn btn-sm btn-secondary' },
                    { extend: 'csv', className: 'btn btn-sm btn-info' },
                    { extend: 'excel', className: 'btn btn-sm btn-success' },
                    { extend: 'pdf', className: 'btn btn-sm btn-danger' },
                    { extend: 'print', className: 'btn btn-sm btn-primary' }
                ]
            });
        }
    });
</script>
@endsection

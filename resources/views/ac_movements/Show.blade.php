@extends('layouts.admin')

@section('title', 'AC Movement Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>AC Movement Details</h4>
                <a href="{{ route('ac-movements.index') }}" class="btn btn-secondary float-end">Back to List</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Serial Number</th>
                            <td>{{ $movement->acAsset->serial_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Reference Number</th>
                            <td>{{ $movement->reference_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>From Location</th>
                            <td>{{ $movement->fromLocation->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>To Location</th>
                            <td>{{ $movement->toLocation->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Moved By</th>
                            <td>{{ $movement->movedBy->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Remark</th>
                            <td>{{ $movement->remark ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Moved At</th>
                            <td>{{ $movement->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td>{{ $movement->updated_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

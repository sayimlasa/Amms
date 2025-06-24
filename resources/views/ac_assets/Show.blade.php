@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>AC Asset Details</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h4>Asset ID: {{ $asset->id }}</h4>
            <p><strong>Current Location:</strong>
                @if($currentLocation)
                    {{ $currentLocation->name }}
                @else
                    Unknown
                @endif
            </p>
            <!-- Add other asset details here as needed -->
        </div>
    </div>

    <h3>Movement History</h3>
    @if($movements->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>From Location</th>
                    <th>To Location</th>
                    <th>Moved By</th>
                    <th>Movement Type</th>
                    <th>Remark</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movements as $index => $move)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $move->fromLocation ? $move->fromLocation->name : 'N/A' }}</td>
                    <td>{{ $move->toLocation ? $move->toLocation->name : 'N/A' }}</td>
                    <td>{{ $move->moveby ? $move->moveby->name : 'Unknown' }}</td>
                    <td>{{ $move->movement_type ?? '-' }}</td>
                    <td>{{ $move->remark ?? '-' }}</td>
                    <td>{{ $move->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No movement history found for this asset.</p>
    @endif
</div>
@endsection

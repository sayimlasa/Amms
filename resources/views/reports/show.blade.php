@extends('layouts.admin')

@section('content')
    <div class="container">
        <h3>Track AC Movement</h3>
        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Asset ID: {{ $asset->id }}</strong></p>
                    <p><strong>Serial Number :{{ $asset->serial_number }}</strong></p>
                <p><strong>Current Location:</strong>
                    @if ($currentLocation)
                        {{ $currentLocation->name }}
                    @else
                        Unknown
                    @endif
                </p>
                <!-- Add other asset details here as needed -->
            </div>
        </div>

        <h3>Movement History</h3>
        @if ($movements->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>From Location</th>
                        <th>To Location</th>
                        {{-- <th>Moved By</th> --}}
                        {{-- <th>Movement Type</th> --}}
                        <th>Remark</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movements as $index => $move)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $move->fromLocation ? $move->fromLocation->name : 'N/A' }}</td>
                            <td>{{ $move->toLocation ? $move->toLocation->name : 'N/A' }}</td>
                            {{-- <td>{{ $move->movedBy->name ?? '-' }}</td> --}}
                            {{-- <td>{{ $move->movement_type ?? '-' }}</td> --}}
                            <td>{{ $move->remark ?? '-' }}</td>
                            <td>{{ $move->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No movement history found for this asset.</p>
        @endif
         <div class="col-sm-6 text-end">
                <a href="{{ route('track.history') }}" class="btn btn-secondary">Back to List</a>
            </div>
    </div>
@endsection

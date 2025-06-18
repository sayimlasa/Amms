@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Audit Logs</h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.audit_logs.index') }}">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="event" class="form-label">Event Type</label>
                    <select name="event" class="form-control">
                        <option value="">All Events</option>
                        <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Created</option>
                        <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Updated</option>
                        <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <!-- Table to Display Logs -->
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Event</th>
                    <th>Auditable Type</th>
                    <th>Auditable ID</th>
                    <th>Old Values</th>
                    <th>New Values</th>
                    <th>User</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($audits as $audit)
                    <tr>
                        <td>{{ $audit->id }}</td>
                        <td>{{ ucfirst($audit->event) }}</td>
                        <td>{{ $audit->auditable_type }}</td>
                        <td>{{ $audit->auditable_id }}</td>
                        <td>{{ json_encode($audit->old_values) }}</td>
                        <td>{{ json_encode($audit->new_values) }}</td>
                        <td>{{ $audit->user ? $audit->user->name : 'N/A' }}</td>
                        <td>{{ $audit->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="pagination">
            {{ $audits->links() }}
        </div>
    </div>
@endsection

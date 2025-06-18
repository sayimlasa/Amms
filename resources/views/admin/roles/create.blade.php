@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Add New Role
    </div>
    <div class="card-body">
        <form id="addRoleForm" method="post" action="{{route('admin.roles.store')}}">
        @csrf
            <div class="form-group">
                <label for="name">Role Name</label>
                <input type="text" class="form-control" id="name" name="title" required>
            </div>
            <div class="form-group">
                <label for="permissions">Permissions</label>
                <div class="mb-2">
                    <button type="button" id="selectAll" class="btn btn-sm btn-primary">Select All</button>
                    <button type="button" id="deselectAll" class="btn btn-sm btn-secondary">Deselect All</button>
                </div>
                <select class="form-control permissions-select2" id="permissions" name="permissions[]" multiple required>
                    @foreach($permissions as $permission)
                        <option value="{{ $permission->id }}">{{ $permission->title }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Create Role</button>
        </form>
        <div id="successMessage" class="alert alert-success mt-3 d-none">
            Role created successfully!
        </div>
        <div id="errorMessage" class="alert alert-danger mt-3 d-none">
            Failed to create the role. Please try again.
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Include Select2 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.permissions-select2').select2({
            placeholder: "Select permissions",
            allowClear: true
        });

        // Select All
        $('#selectAll').on('click', function() {
            $('.permissions-select2 > option').prop('selected', true);
            $('.permissions-select2').trigger('change');
        });

        // Deselect All
        $('#deselectAll').on('click', function() {
            $('.permissions-select2 > option').prop('selected', false);
            $('.permissions-select2').trigger('change');
        });

       
    });
</script>
@endsection

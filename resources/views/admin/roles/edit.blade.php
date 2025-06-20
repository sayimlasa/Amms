@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <!-- Add your content header here -->
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h6 class="mb-0 flex-grow-1">Update Role Permissions</h6>
                            </div> <!-- End card header -->

                            <div class="card-body">
                                <div class="live-preview">
                                    <form method="POST" action="{{ route('admin.roles.update', [$role->id]) }}"
                                        enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <div class="row g-4">
                                            <!-- Role Name Field -->
                                            <div class="col-xxl-3 col-md-12">
                                                <label for="name" class="form-label">Role Name</label>
                                                <input type="text" class="form-control" id="name" name="title"
                                                    placeholder="Enter Role Name" required value="{{ $role->title }}">
                                            </div>

                                            <!-- Permissions Field -->
                                            <div class="col-xxl-3 col-md-12">
                                                <label class="required" for="permissions">Permissions</label>
                                                <div class="mb-2">
                                                    <!-- Select All / Deselect All Buttons -->
                                                    <button type="button" class="btn btn-info btn-xs select-all">Select
                                                        All</button>
                                                    <button type="button" class="btn btn-info btn-xs deselect-all">Deselect
                                                        All</button>
                                                </div>
                                                <select
                                                    class="form-select select2 {{ $errors->has('permissions') ? 'is-invalid' : '' }}"
                                                    name="permissions[]" id="permissions" multiple required>
                                                    <option value="" disabled>Select permissions</option>
                                                    @foreach ($permissions as $id => $permission)
                                                        <option value="{{ $id }}"
                                                            {{ in_array($id, old('permissions', [])) || $role->permissions->contains($id) ? 'selected' : '' }}>
                                                            {{ $permission }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('permissions'))
                                                    <span class="text-danger">{{ $errors->first('permissions') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.role.fields.permissions_helper') }}</span>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="col-12 text-center">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- End card body -->
                        </div> <!-- End card -->
                    </div> <!-- End col -->
                </div> <!-- End row -->
            </div> <!-- End container-fluid -->
        </section> <!-- End content -->
    </div> <!-- End content-wrapper -->

    <!-- Hidden fields to store the permissions -->
    <input type="hidden" id="assignedPermissionsInput" name="assigned_permissions" value="">
    <input type="hidden" id="unassignedPermissionsInput" name="unassigned_permissions" value="">

    @yield('script')

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#permissions').select2({
                placeholder: "Select Permissions",
                allowClear: true
            });

            // Select All functionality
            $('.select-all').click(function() {
                $('#permissions > option').prop("selected", true); // Select all options
                $('#permissions').trigger("change"); // Trigger change event to update Select2 UI
            });

            // Deselect All functionality
            $('.deselect-all').click(function() {
                $('#permissions > option').prop("selected", false); // Deselect all options
                $('#permissions').trigger("change"); // Trigger change event to update Select2 UI
            });

            // Capture the initial assigned permissions (from the backend)
            var assignedPermissions = @json($role->permissions->pluck('id')->toArray());

            // Capture the current state of permissions
            function getAssignedAndUnassignedPermissions() {
                var selectedPermissions = $('#permissions').val() || []; // Get selected permissions

                // Newly assigned permissions (not previously selected)
                var newlyAssigned = selectedPermissions.filter(function(permission) {
                    return !assignedPermissions.includes(permission); // Not already assigned
                });

                // Removed permissions (permissions that were assigned but are now deselected)
                var removedPermissions = assignedPermissions.filter(function(permission) {
                    return !selectedPermissions.includes(permission); // Previously assigned but not selected
                });

                console.log('Newly Assigned Permissions:', newlyAssigned);
                console.log('Removed Permissions:', removedPermissions);

                // Update hidden inputs with assigned and unassigned permissions
                $('#assignedPermissionsInput').val(selectedPermissions.join(','));
                $('#unassignedPermissionsInput').val(removedPermissions.join(','));
            }

            // When the selection changes, update the assigned and unassigned permissions
            $('#permissions').on('change', getAssignedAndUnassignedPermissions);

            // Initial call to track the permissions when the page loads
            getAssignedAndUnassignedPermissions();
        });
    </script>
@endsection

<!-- Select2 Custom CSS -->
<style>
    /* Custom styling for selected options in green before saving */
    .select2-selection__choice {
        background-color: #28a745 !important;
        color: white !important;
        border-radius: 0.25rem;
        margin-right: 5px;
        margin-bottom: 5px;
        display: inline-block;
    }

    /* Styling for the Select2 dropdown to display options horizontally */
    .select2-results__options {
        display: flex;
        flex-wrap: wrap;
    }

    .select2-results__option {
        width: auto;
        margin: 5px;
        white-space: nowrap;
        display: inline-block;
    }

    /* Styling for selected options in the dropdown */
    .select2-results__option[aria-selected="true"] {
        background-color: #28a745;
        color: white;
    }

    .select2-selection__choice:hover {
        background-color: #218838 !important;
    }

    /* Disable option after selection */
    .select2-results__option[aria-disabled="true"] {
        background-color: #d6d6d6;
        color: #aaa;
    }
</style>

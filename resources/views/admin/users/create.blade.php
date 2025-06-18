@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- Add your content header here -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h6 class=" mb-0 flex-grow-1">Add User</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{route('admin.users.store')}}">
                                    @csrf
                                    <div class="row g-4">
                                        <!-- Full Name Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="name" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name" required>
                                            </div>
                                        </div>

                                        <!-- Password Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                            </div>
                                        </div>

                                        <!-- Email Address Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                                            </div>
                                        </div>

                                        <!-- Mobile Number Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="mobile" class="form-label">Mobile No</label>
                                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile No" oninput="capitalizeOnlyFirstLetter(this)" required>
                                            </div>
                                        </div>

                                        <!-- Role Select -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="role_id" class="form-label">Role</label>
                                                <select class="form-control select2" name="role_id[]" id="role_id" multiple required>
                                                    @foreach($roles as $id => $role)
                                                    <option value="{{ $id }}">{{ $role }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Campus Select -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="campus_id" class="form-label">Campus</label>
                                                <select class="form-control select" name="campus_id" id="campus_id" required>
                                                    @foreach($campuses as $id => $entry)
                                                    <option value="{{ $id }}" {{ old('campus_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Is Active Checkbox -->
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="active" class="form-label">Is Active?</label>
                                                <div class="form-check">
                                                    <input type="hidden" name="active" value="0">
                                                    <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ old('active', 0) == 1 ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-12">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.container-fluid -->
                    </div><!-- /.card -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@yield('script')

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Choices for the Role and Campus selects
        const roleSelect = document.getElementById('role_id');
        const campusSelect = document.getElementById('campus_id');

        if (roleSelect) {
            new Choices(roleSelect, {
                removeItemButton: true, // Allows deselecting an option with a close button
                searchEnabled: true,    // Allows search functionality
            });
        }

        if (campusSelect) {
            new Choices(campusSelect, {
                removeItemButton: true, // Allows deselecting an option with a close button
                searchEnabled: true,    // Allows search functionality
            });
        }
    });

    // Function to capitalize the first letter of the mobile number
    function capitalizeOnlyFirstLetter(input) {
        let value = input.value;
        input.value = value.charAt(0).toUpperCase() + value.slice(1).toLowerCase();
    }
</script>

@endsection

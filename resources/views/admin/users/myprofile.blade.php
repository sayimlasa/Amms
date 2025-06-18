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
                            <div class="card-header d-flex align-items-center">
                                <h6 class="mb-0 flex-grow-1">Change Password</h6>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form method="POST" action="{{ route('admin.change.password') }}">
                                        @csrf
                                        <div class="row g-4">
                                            <!-- Current Password -->
                                            <div class="col-xxl-3 col-md-12">
                                                <label for="current_password" class="form-label">Current Password</label>
                                                <input type="password" class="form-control" id="current_password"
                                                    name="current_password" placeholder="Enter current password" required>
                                            </div>

                                            <!-- New Password -->
                                            <div class="col-xxl-3 col-md-12">
                                                <label for="new_password" class="form-label">New Password</label>
                                                <input type="password" class="form-control" id="new_password"
                                                    name="new_password" placeholder="Enter new password" required>
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="col-xxl-3 col-md-12">
                                                <label for="new_password_confirmation" class="form-label">Confirm New
                                                    Password</label>
                                                <input type="password" class="form-control" id="new_password_confirmation"
                                                    name="new_password_confirmation" placeholder="Confirm new password"
                                                    required>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-success">Change Password</button>
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

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Choices(document.getElementById('role_id'), {
                removeItemButton: true,
                searchEnabled: true,
            });
            new Choices(document.getElementById('campus_id'), {
                removeItemButton: true,
                searchEnabled: true,
            });
        });
    </script>
@endsection
e

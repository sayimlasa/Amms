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
                            <h6 class="mb-0 flex-grow-1">Add User</h6>
                        </div>

                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('admin.users.store') }}">
                                    @csrf
                                    <div class="row g-4">
                                        <!-- Full Name Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name" required>
                                        </div>

                                        <!-- Password Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                        </div>

                                        <!-- Email Address Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                                        </div>

                                        <!-- Mobile Number Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <label for="mobile" class="form-label">Mobile No</label>
                                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile No" required>
                                        </div>

                                        <!-- Role Select with Select2 -->
                                        <div class="col-xxl-3 col-md-6">
                                            <label for="role_id" class="form-label">Role</label>
                                            <select class="form-control select2" name="role_id[]" id="role_id" multiple required>
                                                @foreach($roles as $id => $role)
                                                    <option value="{{ $id }}">{{ $role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Is Active Checkbox -->
                                        <div class="col-xxl-3 col-md-3">
                                            <label for="active" class="form-label">Is Active?</label>
                                            <div class="form-check">
                                                <input type="hidden" name="active" value="0">
                                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ old('active', 0) == 1 ? 'checked' : '' }}>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-success">Submit</button>
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
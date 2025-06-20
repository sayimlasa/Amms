@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"></section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h6 class="mb-0 flex-grow-1">Edit User</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-4">
                                        <!-- Name Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="name" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name" required value="{{ $user->name }}">
                                            </div>
                                        </div>
                                        <!-- Email Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required value="{{ $user->email }}">
                                            </div>
                                        </div>
                                        <!-- Mobile Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="mobile" class="form-label">Mobile No</label>
                                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile Number" required value="{{ $user->mobile }}">
                                            </div>
                                        </div>
                                        <!-- Role Selection -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="role_id" class="form-label">Role</label>
                                                <select class="form-control select2" name="role_id[]" id="role_id" multiple required>
                                                    @foreach($roles as $id => $role)
                                                        <option value="{{ $id }}" {{ in_array($id, old('role_id', $user->roles->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $role }}</option>
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
                                                    <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ $user->active ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Submit Button -->
                                        <div class="col-12">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- /.card -->
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@yield('script')
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

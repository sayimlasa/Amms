@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h6 class=" mb-0 flex-grow-1">Edit User</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{route('admin.users.update',$user->id)}}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-4">
                                        <!-- Name Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="start_date" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name" required value="{{$user->name}}">
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="start_date" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required value="{{$user->email}}">
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="start_date" class="form-label">Mobile No</label>
                                                <input type="text" class="form-control" id="name" name="mobile" placeholder="Enter the Mobile" value="{{$user->mobile}}" required>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="campus_id" class="form-label">Role</label>
                                                <select class="form-control select2" name="role_id[]" id="role_id" multiple required>
                                                    @foreach($roles as $id => $role)
                                                    <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $user->roles->contains($id)) ? 'selected' : '' }}>{{ $role }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="campus_id" class="form-label">Campus</label>
                                                <select class="form-control select2" name="campus_id" id="campus_id" required>
                                                    @foreach($campuses as $id => $entry)
                                                    <option value="{{ $id }}" {{ old('campus_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        <div>
                                            <label for="active" class="form-label">Is Active?</label>
                                            <div class="form-check">
                                                <input type="hidden" name="active" value="0">
                                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ old('published', 0) == 1 ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                            </div>
                            </form>

                            <!--end col-->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@yield('script')
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const intakeSelect = document.getElementById('role_id');
        const campuSelect = document.getElementById('campus_id');

        new Choices(intakeSelect, {
            removeItemButton: true, // Allows deselecting an option with a close button
            searchEnabled: true,
        });
        new Choices(campuSelect, {
            removeItemButton: true, // Allows deselecting an option with a close button
            searchEnabled: true,
        });
    });
</script>
@endsection
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
                            <h6 class=" mb-0 flex-grow-1">Edit Department</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('departments.update', [$department->faculty_id]) }}">
                                    @method('PUT')
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-xxl-6 col-md-12">
                                            <div>
                                                <label for="name" class="form-label">Department Names (Comma-Separated)</label>
                                                <textarea class="form-control" id="name" name="name" rows="3" required>{{ $departments->pluck('name')->implode(', ') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="faculty_id" class="form-label">Faculty</label>
                                                <select class="form-control select2" name="faculty_id" id="faculty_id" required>
                                                    <option value="" selected disabled>Select Faculty</option>
                                                    @foreach ($faculties as $faculty)
                                                    <option value="{{ $faculty->id }}" {{ old('faculty_id', $department->faculty_id) == $faculty->id ? 'selected' : '' }}>
                                                        {{ $faculty->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-success">Update</button>
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
<script>
    function capitalizeOnlyFirstLetter(input) {
        // Capitalize the first letter and make the rest lowercase
        input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1).toLowerCase();
    }
</script>
@endsection
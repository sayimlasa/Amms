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
                            <h6 class=" mb-0 flex-grow-1">Edit Requirements</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form action="{{ route('requirements.update', [$applicationLevelId, $educationLevelId]) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="application_level" class="form-label">Application Level</label>
                                        <input type="text" class="form-control" value="{{ $applicationLevel->name }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="education_level" class="form-label">Education Level</label>
                                        <input type="text" class="form-control" value="{{ $educationLevel->name }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="subject_course" class="form-label">Subjects/Courses</label>
                                        <textarea name="subject_course" class="form-control" rows="4" required>{{ $subjects }}</textarea>
                                        <small class="text-muted">Separate subjects with commas.</small>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('requirements.index') }}" class="btn btn-secondary">Cancel</a>
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
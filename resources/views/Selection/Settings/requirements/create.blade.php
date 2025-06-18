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
                            <h6 class=" mb-0 flex-grow-1">New Requirements</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{route('requirements.store')}}">
                                    @csrf
                                    <div class="row g-4">
                                        <!-- Start Date Input -->
                                        <div class="col-xxl-6 col-md-6">
                                            <div>
                                                <label for="application_level_id" class="form-label">Level</label>
                                                <select class="form-control select2" name="application_level_id" id="application_level_id" required>
                                                    <option selected disabled><--choose level--></option>
                                                    @foreach ( $applicationLevels as $level)
                                                    <option value="{{$level->id}}">{{$level->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-md-6">
                                            <div>
                                                <label for="education_level_id" class="form-label">Qualifying With</label>
                                                <select class="form-control select2" name="education_level_id" id="education_level_id" required>
                                                    <option selected disabled><--choose level--></option>
                                                    @foreach ( $educationLevels as $level)
                                                    <option value="{{$level->id}}">{{$level->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-xxl-12 col-md-12">
                                            <div>
                                                <label for="subject_course" class="form-label">Subjects or Courses</label>
                                                <textarea class="form-control" id="subject_course" name="subject_course" rows="4" required></textarea>
                                                <small class="text-muted">Enter multiple subjects/courses separated by commas.</small>
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
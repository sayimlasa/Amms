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
                            <h6 class=" mb-0 flex-grow-1">Edit Academic Year</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{route('academic-years.update', [$academicYear->id])}}">
                                    @method('PUT')
                                    @csrf
                                    <div class="row g-4">
                                        <!-- Name Input -->
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{$academicYear->name}}" required>
                                            </div>
                                        </div>
                                        <!-- Start Date Input -->
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="start_date" class="form-label">Start Date</label>
                                                <input type="date" class="form-control datepicker" id="start_at" name="start_at"  value="{{$academicYear->start_at}}" required>
                                            </div>
                                        </div>

                                        <!-- End Date Input -->
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="end_date" class="form-label">End Date</label>
                                                <input type="date" class="form-control datepicker" id="end_at" name="end_at" value="{{$academicYear->end_at}}" required>
                                            </div>
                                        </div>

                                        <!-- Is Active Checkbox -->
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="active" class="form-label">Is Active?</label>
                                                <div class="form-check">
                                                    <input type="hidden" name="active" value="0">
                                                    <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ $academicYear->active || old('active', 0) === 1 ? 'checked' : '' }}>
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
    // Initialize Flatpickr with yyyy- format
    flatpickr('.datepicker', {
        dateFormat: "Y-m-d",
    });
</script>
@endsection
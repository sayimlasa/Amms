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
                            <h6 class=" mb-0 flex-grow-1">New Window</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{route('application-windows.store')}}">
                                    @csrf
                                    <div class="row g-4">
                                        <!-- Name Input -->
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="First window" oninput="capitalizeOnlyFirstLetter(this)" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="application_level_id" class="form-label">Level</label>
                                                <select class="form-control select2" name="application_level_id" id="application_level_id" required>
                                                <option value="" selected disabled><--please select--></option>    
                                                @foreach ( $levels as $level)
                                                    <option value="{{$level->id}}">{{$level->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="intake_id" class="form-label">Intake</label>
                                                <select class="form-control select2" name="intake_id" id="intake_id" required>
                                                <option value="" selected disabled><--please select--></option>    
                                                @foreach ( $intakes as $intake)
                                                    <option value="{{$intake->id}}">{{$intake->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="academic_year_id" class="form-label">Academic Year</label>
                                                <select class="form-control select2" name="academic_year_id" id="academic_year_id" required>
                                                <option value="" selected disabled><--please select--></option>    
                                                @foreach ( $academicYears as $academicYear)
                                                    <option value="{{$academicYear->id}}">{{$academicYear->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        
                                        <!-- Start Date Input -->
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="start_date" class="form-label">Start Date</label>
                                                <input type="date" class="form-control datepicker" id="start_at" name="start_at" placeholder="yyyy-mm-dd" required>
                                            </div>
                                        </div>

                                        <!-- End Date Input -->
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="end_date" class="form-label">End Date</label>
                                                <input type="date" class="form-control datepicker" id="end_at" name="end_at" placeholder="yyyy-mm-dd" required>
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

                                <!--end col-->
                            </div>
                            <!-- /.row -->
                        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
 @yield('script')
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
     flatpickr('.datepicker', {
        dateFormat: "Y-m-d",
    });

    function capitalizeOnlyFirstLetter(input) {
        // Capitalize the first letter and make the rest lowercase
        input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1).toLowerCase();
    }

    // $(document).ready(function() {
    //     $('#application_level_id').select2({
    //         placeholder: "Choose a country",
    //         allowClear: true
    //     });
    // });
</script>
@endsection
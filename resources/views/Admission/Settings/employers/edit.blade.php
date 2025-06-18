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
                            <h6 class=" mb-0 flex-grow-1">Edit Employer</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{route('employers.update', [$employer->id])}}">
                                    @method('PUT')
                                    @csrf
                                    <div class="row g-4">
                                        <!-- Start Date Input -->
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="start_date" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{$employer->name}}" oninput="capitalizeOnlyFirstLetter(this)" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="mobile_no" class="form-label">Mobile</label>
                                                <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="{{$employer->mobile_no}}" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" class="form-control" id="address" name="address" value="{{$employer->address}}" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="emil" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{$employer->email}}" required>
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

    document.getElementById('mobile_no').addEventListener('input', function() {
        const mobileInput = this.value;
        const mobilePattern = /^0\d{9,14}$/;

        if (!mobilePattern.test(mobileInput)) {
            this.setCustomValidity('Mobile number must start with 0 and have 10 to 15 digits.');
        } else {
            this.setCustomValidity(''); // Clear error message if valid
        }
    });
</script>
@endsection
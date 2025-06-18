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
                        <div class="card-header align-items-center d-flex">
                            <h6 class=" mb-0 flex-grow-1">Generate Control Number</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{route('create.BillId')}}">
                                    @csrf
                                    <div class="row g-4">
                                        <!-- Full Name Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="name" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name" required>
                                            </div>
                                        </div>

                                        <!-- Password Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="password" class="form-label">Amount</label>
                                                <input type="text" class="form-control" id="password" name="amount" placeholder="" required>
                                            </div>
                                        </div>

                                        <!-- Email Address Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                                            </div>
                                        </div>

                                        <!-- Mobile Number Input -->
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="mobile" class="form-label">Mobile No</label>
                                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile No" oninput="capitalizeOnlyFirstLetter(this)" required>
                                            </div>
                                       </div>
                                        <!-- Submit Button -->
                                        <div class="col-12">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success">Generate</button>
                                            </div>
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
@endsection

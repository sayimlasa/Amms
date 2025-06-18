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
                            <h6 class=" mb-0 flex-grow-1">Submit Attachment</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('attachments.store') }}" enctype="multipart/form-data">
                                   @csrf
                                    <div class="row g-4">
                                        <div>
                                            <div class="row">
                                                <div class="col-xxl-3 col-md-4 mt-3">
                                                    <div>
                                                        <label for="index_no" class="form-label">Applicant Index Number</label>
                                                        <select class="form-control select2" id="index_no" name="index_no" required>
                                                            <option value="" selected disabled>Choose Applicant</option>
                                                            @foreach ($applicants as $applicant)
                                                                <option value="{{ $applicant->index_no . ',' . $applicant->applicant_user_id }}">
                                                                    {{ $applicant->index_no }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="type_id" class="form-label">Attachment Type</label>
                                                        <select class="form-control select2" name="type_id" id="type_id" required>
                                                            <option value="" selected disabled>Select Type</option>
                                                            @foreach ($attachmentTypes as $attachmentType)
                                                            <option value="{{ $attachmentType->id }}">
                                                                {{ $attachmentType->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-md-4 mt-3">
                                                    <div>
                                                        <label for="doc_url" class="form-label">Attachment</label>
                                                        <input type="file" class="form-control" id="doc_url" name="doc_url" accept="image/*" required>
                                                    </div>
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
    $(document).ready(function() {
        // Loop through each element and initialize select2
        select2Elements.forEach(function(element) {
            $(element.id).select2({
                placeholder: element.placeholder, // Set the placeholder dynamically
                allowClear: true
            });
        });

    });
</script>
@endsection
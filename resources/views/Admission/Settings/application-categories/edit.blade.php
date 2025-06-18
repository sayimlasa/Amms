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
                            <h6 class=" mb-0 flex-grow-1">Edit Application Category</h6>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{route('application-categories.update', $applicationCategory->id)}}">
                                    @method('PUT')
                                    @csrf
                                    <div class="row g-4">
                                        <!-- Name Input -->
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{$applicationCategory->name}}" oninput="capitalizeOnlyFirstLetter(this)" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="application_level_id" class="form-label">Level</label>
                                                <select class="form-control select2" name="application_level_id" id="application_level_id" required>
                                                    <option value="" selected disabled>Select Level</option>
                                                    @foreach ($levels as $level)
                                                    <option value="{{ $level->id }}" {{ old('application_level_id', $applicationCategory->application_level->id) == $level->id ? 'selected' : '' }}>
                                                        {{ $level->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="education_level_id" class="form-label">Required Education Qualifications</label>
                                                <select class="form-control" name="education_level_id[]" id="education_level_id" multiple required>
                                                    @foreach ($educationLevels as $educationLevel)
                                                    <option value="{{ $educationLevel->id }}"
                                                        @if(in_array($educationLevel->id, $applicationCategory->educationLevels->pluck('id')->toArray())) selected @endif>
                                                        {{ $educationLevel->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-3">
                                            <div>
                                                <label for="attachment_type_id" class="form-label">Required Attachments</label>
                                                <select class="form-control" name="attachment_type_id[]" id="attachment_type_id" multiple>
                                                    @foreach ($attachmentTypes as $attachmentType)
                                                    <option value="{{ $attachmentType->id }}"
                                                        @if(in_array($attachmentType->id, $applicationCategory->attachmentTypes->pluck('id')->toArray())) selected @endif>
                                                        {{ $attachmentType->name }}
                                                    </option>
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
                                                    <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ $applicationCategory->active || old('active', 0) === 1 ? 'checked' : '' }}>
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
    function capitalizeOnlyFirstLetter(input) {
        // Capitalize the first letter and make the rest lowercase
        input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1).toLowerCase();
    }

    $(document).ready(function() {
        $('#application_level_id').select2({
            placeholder: "Choose a country",
            allowClear: true
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const campuSelect = document.getElementById('education_level_id');
        const attachmentSelect = document.getElementById('attachment_type_id');
        new Choices(campuSelect, {
            removeItemButton: true, // Allows deselecting an option with a close button
            searchEnabled: true,
        });
        new Choices(attachmentSelect, {
            removeItemButton: true, // Allows deselecting an option with a close button
            searchEnabled: true,
        });
    });
</script>
@endsection
@extends('layouts.admin')

@section('content')
<div class="col-sm-12">
    <!-- Display Success and Error Messages -->
    @if(session('success'))
    <div id="success-message" class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('bachelor.six') }}" method="GET">
                            <div class="row align-items-end">
                                <div class="col-md-9">
                                    <label for="programme_id" class="form-label">Programme</label>
                                    <select class="form-control select2" name="programme_id" id="programme_id" required>
                                        <option value="">Select Programme</option>
                                        @foreach ($programme as $program)
                                        <option value="{{ $program->id }}" {{ request('programme_id') == $program->id ? 'selected' : '' }}>
                                            {{ $program->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100">Run Selection</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<div class="card">
    <div id="checkbox-message" class="alert alert-warning mt-3">
        <strong>Warning!</strong> Please select at least one applicant before saving.
    </div>

    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-sm-4">
                <h6 class="mb-0">List of Selected Students</h6>
            </div>
            <div class="col-sm-4 text-center">
                <strong>Checked Applicants: </strong>
                <span id="checked-count">0</span>
            </div>
            <div class="col-sm-4 text-end">
                @if(request('programme_id'))
                <form action="{{ route('bachelor.six.store') }}" method="POST" id="save-form">
                    @csrf
                    <input type="hidden" name="programme_id" value="{{ request('programme_id') }}">
                    <button
                        type="submit"
                        class="btn btn-success"
                        id="save-selected-button"
                        style="display: none;">
                        Save Selected Applicant
                    </button>
                </form>
                @endif
            </div>
        </div>


        <div class="table-responsive mt-3">
            <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>SN</th>
                        <th>Applicant ID</th>
                        <th>Index Number 4</th>
                        <th>Index Number 6</th>
                        <th>Full Name</th>
                        <th>Phone number</th>
                        <th>Gender</th>
                        <th>Application Category</th>
                        <th>Program Name</th>
                        <th>Campus</th>
                        <th>total</th>
                        <th></th>
                    </tr>
                </thead>
                @php $count = 0 @endphp
                <tbody>
                    @foreach($allSelected as $bachelor)
                    @foreach($bachelor as $s)
                    <tr>
                        <td><input type="checkbox" name="selected_applicants[]" value="{{$s->id}}" class="applicant-checkbox"></td>
                        <td>{{ ++$count }}</td>
                        <td>{{ $s->id }}</td>
                        <td>{{ $s->index_no }}</td>
                        <td>{{$s->qualification_no}}</td>
                        <td>{{ $s->fname }} {{ $s->lname }}</td>
                        <td>{{ $s->mobile_no }}</td>
                        <td>{{ $s->gender }}</td>
                        <td>
                            @php
                            $category = \App\Models\ApplicationCategory::find($s->categoryId);
                            @endphp
                            {{ $category ? $category->name : 'N/A' }}
                        </td>
                        <td>
                            @php
                            $programme = \App\Models\Programme::find($s->programme_id);
                            @endphp
                            {{ $programme ? $programme->name : 'N/A' }}
                        </td>
                        <td>
                            @php
                            $campus = \App\Models\Campus::find($s->campus);
                            @endphp
                            {{ $campus ? $campus->name : 'N/A' }}
                        </td>
                        <td></td>
                        <td>
                            <a class="dropdown-item view-item-btn" href="{{ route('detailed-applicant-info', ['applicant_user_id' => $s->id, 'index_no' => $s->index_no]) }}">
                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> more
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#programme_id').select2({
            placeholder: 'Select Programme',
            allowClear: true
        });

        $('#select-all').on('change', function() {
            const isChecked = this.checked;
            $('input[name="selected_applicants[]"]').prop('checked', isChecked);
            updateCheckedCount();
            toggleSaveButton();
        });

        $(document).on('change', 'input[name="selected_applicants[]"]', function() {
            updateCheckedCount();
            toggleSaveButton();
        });

        function updateCheckedCount() {
            const checkedCount = $('input[name="selected_applicants[]"]:checked').length;
            $('#checked-count').text(checkedCount); // Update the checked count display
        }

        function toggleSaveButton() {
            const checkboxes = $('input[name="selected_applicants[]"]:checked');
            const saveButton = $('#save-selected-button');
            const message = $('#checkbox-message');
            if (checkboxes.length > 0) {
                saveButton.show();
                message.hide();
            } else {
                saveButton.hide();
                message.show();
            }
        }

        // Hide success/error messages after 5 seconds
        setTimeout(() => {
            $('#success-message, .alert-danger').fadeOut('slow');
        }, 5000);

        $('#save-form').submit(function(e) {
            e.preventDefault();

            // Clear any previous selected applicants inputs
            $('#save-form input[name="selected_applicants[]"]').remove();

            // Loop through checked checkboxes and append them as hidden inputs
            $('input[name="selected_applicants[]"]:checked').each(function() {
                const hiddenInput = $('<input>').attr({
                    type: 'hidden',
                    name: 'selected_applicants[]',
                    value: $(this).val()
                });
                $('#save-form').append(hiddenInput);
            });

            // Now submit the form
            if ($('input[name="selected_applicants[]"]:checked').length > 0) {
                $('#save-form')[0].submit(); // Direct form submission after appending selected values
            } else {
                alert('Please select at least one applicant.');
            }
        });
    });
</script>
@endsection
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
                        <form action="{{ route('sendtcu.arusha.send') }}" method="GET">
                            <div class="row align-items-end">
                                <div class="col-md-9">
                                    <label for="programme_id" class="form-label">Programme</label>
                                    <select class="form-control select2" name="programme_id" id="programme_id" required>
                                        <option value="">Select Programme</option>
                                        @foreach ($programtcu as $program)
                                        <option value="{{ $program->iaa_programme_id }}" {{ request('programme_id') == $program->tcu_code ? 'selected' : '' }}>
                                            {{ $program->tcu_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100">Send Applicants TCU</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Display XML output -->
<div class="col-sm-12">
    <h3>XML Response:</h3>
    <!-- Display the responsetcu value -->
    <p>StatusCode: {{ is_array(session('indexnumber')) ? json_encode(session('indexnumber')) : session('indexnumber') }}</p>

    <p>StatusCode: {{ is_array(session('responsetcu')) ? json_encode(session('responsetcu')) : session('responsetcu') }}</p>

    <!-- Display the responsecode value -->
    <p>StatusDescription: {{ is_array(session('responsecode')) ? json_encode(session('responsecode')) : session('responsecode') }}</p>
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

        // Hide success/error messages after 5 seconds
        setTimeout(() => {
            $('#success-message, .alert-danger').fadeOut('slow');
        }, 5000);
    });
</script>
@endsection

@extends('layouts.admin')

@section('content')
    <div class="col-sm-12">
        <!-- Display Success and Error Messages -->
        @if (session('success'))
            <div id="success-message" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
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
                            <form action="{{ route('submitted.babati.send') }}" method="GET">
                                <div class="row align-items-end">
                                    <div class="col-md-2">
                                        <label for="payment" class="form-label">Payment</label>
                                        <input class="form-control" type="text" name="payment" id="payment">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="level" class="form-label">Application Level</label>
                                        <select class="form-control select2" name="level" id="level" required>
                                            <option value="">Select level</option>
                                            <option value="4">Nta Level 4</option>
                                            <option value="5">Nta Level 5</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="intake_id" class="form-label">Intake</label>
                                        <select class="form-control select2" name="intake_id" id="intake_id" required>
                                            <option value="">Select intake</option>
                                            <option value="MARCH">March</option>
                                            <option value="SEPT">September</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="programme_id" class="form-label">Programme</label>
                                        <select class="form-control select2" name="programme_id" id="programme_id" required>
                                            <option value="">Select Programme</option>
                                            @foreach ($programme as $program)
                                                <option value="{{ $program->iaa_program_id }}"
                                                    {{ request('programme_id') == $program->iaa_program_id ? 'selected' : '' }}>
                                                    {{ $program->program_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">Submit Nactevet</button>
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
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <h6 class="mb-0">List of Submitted Applicants</h6>
                    <!-- Display indexNumbers and apiResponses -->
                    @if (session('indexNumbers') && session('apiResponses'))
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Index Number</th>
                                    <th>API Response</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (session('indexNumbers') as $index => $number)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $number }}</strong></td>
                                        <td>
                                            <pre>{{ session('apiResponses')[$index] ?? 'No response' }}</pre>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No data available</p>
                    @endif

                </div>
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
        $(function() {
            $('#programme_id, #intake_id, #level').select2({
                placeholder: function() {
                    return $(this).attr('placeholder');
                },
                allowClear: true
            });

            setTimeout(() => $('#success-message, .alert-danger').fadeOut('slow'), 5000);
        });
    </script>
@endsection

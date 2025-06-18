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
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <h6 class="mb-0">List of Arusha Programme</h6>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <!-- Table -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Programme Name</th>
                            <th>Programme Code</th>
                            <th>Iaa programme</th>
                            <th>programme Id</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($programmetcu as $key => $programme)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $programme->tcu_name }}</td>
                                <td>{{ $programme->tcu_code }}</td>
                                {{-- <td>{{ $programme->iaa_program ?? 'NA' }}</td> --}}
                                <td>
                                    @php
                                    $program = \App\Models\Programme::find($programme->iaa_program);
                                    @endphp
                                    {{ $program? $program->name : 'N/A' }}
                                </td>
                                <td>{{ $programme->iaa_programme_id ?? 'NA' }}</td>
                                <td>
                                    <a class="dropdown-item" href="{{ route('arusha.tcu.edit', $programme->id) }}">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> update
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

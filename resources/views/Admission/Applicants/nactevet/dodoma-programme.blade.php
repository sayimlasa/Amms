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
                <form action="{{ route('programme.dodoma.store') }}" method="GET">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Fetch Program</button>
                    </div>
                </form>
            </div>
            </form>
        </div>
    </div>
    </div>
</section>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                <h6 class="mb-0">List of dodoma Programme</h6>
            </div>
        </div>

        <div class="table-responsive mt-3">
            <table id="" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Programe ID</th>
                        <th>Programme Nactevet</th>
                        <th>Nta</th>
                        <th>Programme Iaa</th>
                        <th>Programme Iaa Id</th>
                        <th></th>
                    </tr>
                </thead>
                @php $count = 0 @endphp
                <tbody>
                    @foreach ($nacteprogramdodoma as $program)
                    <tr>
                        <td>{{ ++$count }}</td>
                        <td>{{ $program->program_id ?? 'N/A' }}</td>
                        <td>{{ $program->program_name ?? 'N/A' }}</td>
                         <td>
                            @php
                            $nta = \App\Models\ApplicationLevel::find($program->nta);
                            @endphp
                            {{ $nta ? $nta->nta_level: 'N/A' }}
                        </td>
                         <td>
                            @php
                            $programme = \App\Models\Programme::find($program->iaa_program);
                            @endphp
                            {{ $programme ? $programme->name : 'N/A' }}
                        </td>
                        <td>{{ $program->iaa_program_id ?? 'N/A' }}</td>
                        <td>
                            <a class="dropdown-item" href="{{ route('programme.dodoma.edit', $program->id) }}">
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
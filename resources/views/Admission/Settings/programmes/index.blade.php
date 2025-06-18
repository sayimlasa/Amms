@extends('layouts.admin')
@section('content')
<div class="col-sm-12">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <a href="{{route('programmes.create')}}" class="btn btn-success">New Programme</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Programmes</h6>
    </div>
    <div class="card-body">
        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
            @php $na = 1; @endphp
            <thead>
                <tr>
                    <th>Na</th>
                    <th data-ordering="true" hidden> id</th>
                    <th data-ordering="true"> Iaa Code</th>
                    <th data-ordering="true"> Tcu Code</th>
                    <th data-ordering="true"> Nacte Code</th>
                    <th data-ordering="true"> Name</th>
                    <th data-ordering="true"> Short</th>
                    <th data-ordering="true"> Campus</th>
                    <th data-ordering="true"> Intake</th>
                    <th data-ordering="true"> Level</th>
                    <th data-ordering="true"> Computing</th>
                    <th data-ordering="true">Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($programmes as $programme)
                <tr data-entry-id="{{ $programme->id }}">
                    <td>{{$na}}</td>
                    <td hidden>{{ $programme->id ?? '' }}</td>
                    <td>{{ $programme->iaa_code ?? '' }}</td>
                    <td>{{ $programme->tcu_code ?? '' }}</td>
                    <td>{{ $programme->nacte_code ?? '' }}</td>
                    <td>{{ $programme->name ?? '' }}</td>
                    <td>{{ $programme->short ?? '' }}</td>
                    <td>
                        @if($programme->campuses->isNotEmpty())
                        @foreach($programme->campuses as $campus)
                        <!-- <span class="badge bg-success"> {{ $campus->name }}  {{ $campus->name }}{{ !$loop->last ? ', ' : '' }}</span> -->
                        <span class="badge bg-info"> {{ $campus->name }}</span>
                        @endforeach
                        @else
                        No campuses assigned
                        @endif
                    </td>
                    <td>
                        @if($programme->intakes->isNotEmpty())
                        @foreach($programme->intakes as $intake)
                        <!-- {{ $intake->name }}{{ !$loop->last ? ', ' : '' }} -->
                        <span class="badge bg-info"> {{ $intake->name  }}</span>
                        @endforeach
                        @else
                        No intakes assigned
                        @endif
                    </td>
                    <td>{{ $programme->application_level->name ?? '' }}</td>
                    <td scope="row">
                        <div class="form-check">
                            <input class="form-check-input fs-15" type="checkbox" {{ $programme->computing == 1 ? 'checked' : '' }} disabled>
                        </div>
                    </td>
                    <td scope="row">
                        <div class="form-check">
                            <input class="form-check-input fs-15" type="checkbox" {{ $programme->active == 1 ? 'checked' : '' }} disabled>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item view-item-btn" href="{{ route('programmes.show', $programme->id) }}">
                                        <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                        view
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item edit-item-btn" href="{{ route('programmes.edit', $programme->id) }}">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                        edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('programmes.destroy', $programme->id) }}" method="POST" onsubmit="return confirm('are you sure?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item remove-item-btn">
                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                            delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @php $na++; @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection
@section('scripts')
@parent
@endsection
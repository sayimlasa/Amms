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
                <a href="{{route('campuses.create')}}" class="btn btn-success">New Campus</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Campuses</h6>
    </div>
    <div class="card-body">
        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
            @php $na = 1; @endphp
            <thead>
                <tr>
                    <th>Na</th>
                    <th data-ordering="true" hidden> id</th>
                    <th data-ordering="true"> Name</th>
                    <th data-ordering="true"> Country</th>
                    <th data-ordering="true"> Region</th>
                    <th data-ordering="true"> District</th>
                    <th data-ordering="true"> Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($campuses as $campus)
                <tr data-entry-id="{{ $campus->id }}">
                    <td>{{$na}}</td>
                    <td hidden>{{ $campus->id ?? '' }}</td>
                    <td>{{ $campus->name ?? '' }}</td>
                    <td>{{ $campus->country->name ?? '' }}</td>
                    <td>{{ $campus->region_state->name ?? '' }}</td>
                    <td>{{ $campus->district->name ?? '' }}</td>
                    <td scope="row">
                        <div class="form-check">
                            <input class="form-check-input fs-15" type="checkbox" {{ $campus->active == 1 ? 'checked' : '' }} disabled>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item view-item-btn" href="{{ route('campuses.show', $campus->id) }}">
                                        <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                        view
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item edit-item-btn" href="{{ route('campuses.edit', $campus->id) }}">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                        edit
                                    </a>
                                </li>
                                <!-- <li>
                                    <form action="{{ route('campuses.destroy', $campus->id) }}" method="POST" onsubmit="return confirm('are you sure?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item remove-item-btn">
                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                            delete
                                        </button>
                                    </form>
                                </li> -->
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
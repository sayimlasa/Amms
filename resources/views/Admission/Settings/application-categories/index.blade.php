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
                <a href="{{route('application-categories.create')}}" class="btn btn-success">New Application Category</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Application Categories</h6>
    </div>
    <div class="card-body">
        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
            @php $na = 1; @endphp
            <thead>
                <tr>
                    <th>Na</th>
                    <th data-ordering="true" hidden> id</th>
                    <th data-ordering="true"> Name</th>
                    <th data-ordering="true"> Level</th>
                    <th data-ordering="true"> Required Education qualifications</th>
                    <th data-ordering="true"> Required Attachments</th>
                    <th data-ordering="true"> Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applicationCategories as $applicationCategory)
                <tr data-entry-id="{{ $applicationCategory->id }}">
                    <td>{{$na}}</td>
                    <td hidden>{{ $applicationCategory->id ?? '' }}</td>
                    <td>{{ $applicationCategory->name ?? '' }}</td>
                    <td>{{ $applicationCategory->application_level->name ?? '' }}</td>
                    <td>
                        @if($applicationCategory->educationLevels->isNotEmpty())
                        @foreach($applicationCategory->educationLevels as $educationLevel)
                         <span class="badge bg-info"> {{ $educationLevel->name }}</span>
                        @endforeach
                        @else
                        No level assigned
                        @endif
                    </td>
                    <td>
                        @if($applicationCategory->attachmentTypes->isNotEmpty())
                        @foreach($applicationCategory->attachmentTypes as $attachmentType)
                         <span class="badge bg-info"> {{ $attachmentType->name }}</span>
                        @endforeach
                        @else
                        No attachment assigned
                        @endif
                    </td>
                    <td scope="row">
                        <div class="form-check">
                            <input class="form-check-input fs-15" type="checkbox" {{ $applicationCategory->active == 1 ? 'checked' : '' }} disabled>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item view-item-btn" href="{{ route('application-categories.show', $applicationCategory->id) }}">
                                        <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                        view
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item edit-item-btn" href="{{ route('application-categories.edit', $applicationCategory->id) }}">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                        edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('application-categories.destroy', $applicationCategory->id) }}" method="POST" onsubmit="return confirm('are you sure?');" style="display: inline;">
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
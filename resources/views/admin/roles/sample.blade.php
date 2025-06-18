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
      @can('role_create')
      <div class="row mb-2">
            <div class="col-sm-6">
                <a href="{{route('admin.roles.create')}}" class="btn btn-success">Add Role</a>
            </div>
        </div>
      @endcan
    </div><!-- /.container-fluid -->
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">User List</h6>
    </div>
    <div class="card-body">
        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
            @php $na = 1; @endphp
            <thead>
                <tr>
                    <th>S/N</th>
                    <th data-ordering="true" hidden> id</th>
                    <th data-ordering="true"> Role Name</th>
                    <th data-ordering="true">Permission</th>
                    <th data-ordering="true">Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $r)
                <tr data-entry-id="{{$r->id }}">
                    <td>{{$na}}</td>
                    <td hidden>{{ $r->id ?? '' }}</td>
                    <td>{{ $r->title ?? '' }}</td>
                    <td>{{ $r->name ?? '' }}</td>                  
                     <td scope="row">
                        <div class="form-check">
                            <input class="form-check-input fs-15" type="checkbox" {{ $r->active == 1 ? 'checked' : '' }} disabled>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item view-item-btn" href="{{ route('admin.roles.show', $r->id) }}">
                                        <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                        view
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item edit-item-btn" href="{{ route('admin.roles.edit', $r->id) }}">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                        edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('admin.roles.destroy', $r->id) }}" method="POST" onsubmit="return confirm('are you sure?');" style="display: inline;">
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
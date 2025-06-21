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
                <a href="{{route('admin.users.create')}}" class="btn btn-success">Add User</a>
            </div>
        </div>

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
                    <th data-ordering="true"> Full Name</th>
                    <th data-ordering="true">Email Addres</th>
                    <th data-ordering="true"> Mobile</th>
                    <th data-ordering="true"> Role</th>
                    <th data-ordering="true"> Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr data-entry-id="{{ $user->id }}">
                    <td>{{$na}}</td>
                    <td hidden>{{ $user->id ?? '' }}</td>
                    <td>{{ $user->name ?? '' }}</td>
                    <td>{{ $user->email ?? '' }}</td>
                    <td>{{ $user->mobile?? '' }}</td>

                    <!-- Display Role(s) -->
                    <td>
                        @foreach($user->roles as $role)
                        <span class="badge bg-primary">{{ $role->title }}</span>
                        @endforeach
                    </td>
                    <td scope="row">
                        <div class="form-check">
                            <input class="form-check-input fs-15" type="checkbox" {{ $user->active == 1 ? 'checked' : '' }} disabled>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item view-item-btn" href="{{ route('admin.users.show', $user->id) }}">
                                        <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                        view
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item edit-item-btn" href="{{ route('admin.users.edit', $user->id) }}">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                        edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('are you sure?');" style="display: inline;">
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
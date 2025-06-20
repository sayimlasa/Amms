@extends('layouts.admin')

@section('content')
<div style="margin-bottom: 10px;" class="row">
    @can('role_create')        
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.roles.create') }}">
            Add Role
        </a>
    </div>
    @endcan
</div>

<div class="card">
    <div class="card-header">
        Role List
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover" id="rolesTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Role Name</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $index => $role)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $role->title }}</td>
                    <td>
                        @foreach($role->permissions as $permission)
                        <span class="badge bg-info">{{ $permission->title }}</span>
                        @endforeach
                    </td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @can('role_show')
                                <li>
                                    <a class="dropdown-item view-item-btn" href="{{ route('admin.roles.show', $role->id) }}">
                                        <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                    </a>
                                </li>
                                @endcan
                                @can('role_edit')
                                <li>
                                <a class="dropdown-item edit-item-btn" href="{{ route('admin.roles.edit', $role->id) }}">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                    </a>
                                </li>
                                @endcan
                                @can('role_delete')                                    
                                <li>
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item remove-item-btn btn-danger">
                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                        </button>
                                    </form>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
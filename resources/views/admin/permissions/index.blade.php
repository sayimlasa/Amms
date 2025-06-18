@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            @can('permission_create')
            <div class="col-sm-6">
            <a href="{{route('admin.permissions.create')}}" class="btn btn-primary">Add Permission</a>
            </div>
            @endcan
          <div class="col-sm-6">
          @if(session('success'))
              <div id="success-message" class="alert alert-success">
                  {{ session('success') }}
              </div>
          @endif  
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="">Permissions List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th> </th>
                    <th>ID</th>
                    <th>Title</th>
                    <th> &nbsp; </th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($permissions as $permission)
                    <tr>
                    <td></td>
                    <td>{{$permission->id}}</td>
                    <td>{{$permission->title}}</td>
                    <td>
                      @can('permission_show')
                      <a class="btn btn-xs btn-primary" href="{{route('admin.permissions.show', $permission)}}">{{'view'}}</a>
                      @endcan  
                      @can('permission_edit')
                      <a class="btn btn-xs btn-info" href="{{route('admin.permissions.edit', $permission)}}">{{'edit'}}</a>
                      @endcan  
                      @can('permission_delete')
                      <form action="{{route('admin.permissions.destroy', $permission)}}" method="post">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-xs btn-danger" type="submit" onclick="return confirm('Are you Sure?')">{{'delete'}}</button>
                    </form> 
                      @endcan                   
                    </td>
                  </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

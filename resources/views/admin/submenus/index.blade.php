@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           <a href="{{route('submenus.create')}}" class="btn btn-primary">Add Sub Menu</a>
          </div>
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
                <h3 class="card-title">Sub Menus List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th> </th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Route</th>
                    <th>External Url</th>
                    <th>Published</th>
                    <th>Primary Menu</th>
                    <th> &nbsp; </th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($submenus as $submenu)
                    <tr>
                    <td>
                        <form action="">
                        <input type="hidden" name="" value="0">
                        <input style="transform: scale(1.5); margin:15px;" type="checkbox" id="" name="" value="1" {{ old('') ? 'checked' : '' }}>
                        </form>
                    </td>
                    <td>{{$submenu->id}}</td>
                    <td>{{$submenu->name}}</td>
                    <td>{{$submenu->route}}</td>
                    <td>{{$submenu->external_url}}</td>
                    <td>{{$submenu->is_published == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{$submenu->primary_menu->name}}</td>
                    <td>
                    <a class="btn btn-xs btn-primary" href="{{route('submenus.show', $submenu)}}">{{'view'}}</a>
                       
                    <a class="btn btn-xs btn-info" href="{{route('submenus.edit', $submenu)}}">{{'edit'}}</a>
                       
                    <form action="{{route('submenus.destroy', $submenu)}}" method="post">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-xs btn-danger" type="submit" onclick="return confirm('Are you Sure?')">{{'delete'}}</button>
                    </form>
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

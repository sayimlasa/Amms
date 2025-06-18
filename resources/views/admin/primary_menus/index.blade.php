@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           <a href="{{route('primary_menus.create')}}" class="btn btn-primary">Add Primary Menu</a>
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
                <h3 class="card-title">Primary Menus List</h3>
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
                    <th>Content</th>
                    <th>Published</th>
                    <th>No</th>
                    <th>menu</th>
                    <th> &nbsp; </th> 
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($primary_menus as $primary_menu)
                    <tr>
                    <td>
                        <form action="">
                        <input type="hidden" name="" value="0">
                        <input type="checkbox" id="" name="" value="1" {{ old('') ? 'checked' : '' }}>
                        </form>
                    </td>
                    <td>{{$primary_menu->id}}</td>
                    <td>{{$primary_menu->name}}</td>
                    <td>{{$primary_menu->route}}</td>
                    <td>{{$primary_menu->external_url}}</td>
                    <td>{{$primary_menu->content}}</td>
                    <td>{{$primary_menu->is_published == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{$primary_menu->no}}</td>
                    <td>{{$primary_menu->menu->name}}</td>
                    <td>
                    <a class="btn btn-xs btn-primary" href="{{route('primary_menus.show', $primary_menu)}}">{{'view'}}</a>
                       
                    <a class="btn btn-xs btn-info" href="{{route('primary_menus.edit', $primary_menu)}}">{{'edit'}}</a>
                       
                    <form action="{{route('primary_menus.destroy', $primary_menu)}}" method="post">
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

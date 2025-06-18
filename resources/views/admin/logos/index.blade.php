@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           <a href="{{route('logos.create')}}" class="btn btn-primary">Add Logo</a>
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
                <h3 class="card-title">Logo List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th> </th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Photo</th>
                    <th>Route</th>
                    <th>Published</th>
                    <th> &nbsp; </th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($logos as $logo)
                    <tr>
                    <td>
                        <form action="">
                        <input type="hidden" name="" value="0">
                        <input type="checkbox" id="" name="" value="1" {{ old('') ? 'checked' : '' }}>
                        </form>
                    </td>
                    <td>{{$logo->id}}</td>
                    <td>{{$logo->name}}</td>
                    <td>
                        <img src="/storage/{{$logo->photo}}" alt="logo" height="50px" width="100px">
                    </td>
                    <td>{{$logo->route}}</td>
                    <td>{{$logo->is_published == 1 ? 'Yes' : 'No' }}</td>
                    <td>
                    <a class="btn btn-xs btn-primary" href="{{route('logos.show', $logo)}}">{{'view'}}</a>
                       
                    <a class="btn btn-xs btn-info" href="{{route('logos.edit', $logo)}}">{{'edit'}}</a>
                       
                    <form action="{{route('logos.destroy', $logo)}}" method="post">
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

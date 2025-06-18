@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           <a href="{{route('members.create')}}" class="btn btn-primary">Add Member</a>
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
                <h3 class="card-title">Members List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th> </th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Organization</th>
                    <th>Speaker Type</th>
                    <th>conference</th>
                    <th>Photo</th>
                    <th>Published</th>
                    <th> &nbsp; </th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($members as $member)
                    <tr>
                    <td>
                        <form action="">
                        <input type="hidden" name="" value="0">
                        <input type="checkbox" id="" name="" value="1" {{ old('') ? 'checked' : '' }}>
                        </form>
                    </td>
                    <td>{{$member->id}}</td>
                    <td>{{$member->name}}</td>
                    <td>{{$member->title}}</td>
                    <td>{{$member->organization}}</td>
                    <td>{{$member->speaker->type}}</td>
                    <td>{{$member->conference->title}}</td>
                    <td>
                        <img src="/storage/{{$member->photo}}" alt="logo" height="50px" width="50px">
                    </td>
                    <td>{{$member->is_published == 1 ? 'Yes' : 'No' }}</td>
                    <td>
                    <a class="btn btn-xs btn-primary" href="{{route('members.show', $member)}}">{{'view'}}</a>
                       
                    <a class="btn btn-xs btn-info" href="{{route('members.edit', $member)}}">{{'edit'}}</a>
                       
                    <form action="{{route('members.destroy', $member)}}" method="post">
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

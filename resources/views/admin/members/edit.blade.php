@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Member</h3>
              </div>
              <!-- /.card-header -->
              @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
              <!-- form start -->
              <form method="post" action="{{route('members.update', $member)}}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$member->name}}">
                  </div>

                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{$member->title}}">
                  </div>

                  <div class="form-group">
                    <label for="organization">Organization</label>
                    <input type="text" class="form-control" id="organization" name="organization" value="{{$member->organization}}">
                  </div>

                  <div class="form-group">
                    <label for="speaker">Speaker Type</label>
                    <select name="speaker_id" id="speaker_id" class="form-control">
                        <option value="{{$member->speaker->id}}" selected>{{$member->speaker->type}}</option>
                        @foreach ($speakers as $speaker)
                        <option value="{{$speaker->id}}">{{$speaker->type}}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="conference">Conference</label>
                    <select name="conference_id" id="conference_id" class="form-control">
                        <option value="{{$member->conference->id}}" selected>{{$member->conference->title}}</option>
                        @foreach ($conferences as $conference)
                        <option value="{{$conference->id}}">{{$conference->title}}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="photo">Photo</label>
                    <input type="file" class="form-control-file" id="photo" name="photo">
                    <img src="/storage/{{$member->photo}}" alt="logo" height="100px" width="100px" style="margin-top:10px;">
                  </div>

                  <div class="form-group">
                    <label for="is_published">Is_Published</label>
                    <input type="hidden" name="is_published" value="0">
                    <input style="transform: scale(2); margin:10px;" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $member->is_published) ? 'checked' : '' }}>
                </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
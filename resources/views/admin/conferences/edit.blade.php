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
                <h3 class="card-title">Update Conference</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{route('conferences.update',$conference)}}">
                @method('PUT')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{$conference->title}}">
                  </div>

                  <div class="form-group">
                    <label for="theme">Theme</label>
                    <input type="text" class="form-control" id="theme" name="theme" value="{{$conference->theme}}">
                  </div>

                  <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{$conference->date}}">
                  </div>

                  <div class="form-group">
                    <label for="venue">Venue</label>
                    <input type="text" class="form-control" id="venue" name="venue" value="{{$conference->venue}}">
                  </div>

                  <div class="form-group">
                    <label for="region">Region</label>
                    <select name="region" id="region" class="form-control">
                        <option value="{{$conference->region}}" selected>{{$conference->region}}</option>
                        @foreach($regions as $region)
                        <option value="{{ $region }}">{{ $region }}</option>
                    @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="is_published">Is_Published</label>
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $conference->is_published) ? 'checked' : '' }}>
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

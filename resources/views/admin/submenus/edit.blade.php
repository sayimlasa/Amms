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
                <h3 class="card-title">Edit Sub Menu</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{route('submenus.update', $submenu)}}">
                @method('PUT')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$submenu->name}}">
                  </div>
                  <div class="form-group">
                    <label for="route">Route</label>
                    <input type="text" class="form-control" id="route" name="route" value="{{$submenu->route}}">
                  </div>

                  <div class="form-group">
                    <label for="external_url">External Url</label>
                    <input type="text" class="form-control" id="external_url" name="external_url" value="{{$submenu->external_url}}">
                  </div>

                  <div class="form-group">
                    <label for="menu">Primary Menu</label>
                    <select name="primary_menu_id" id="primary_menu_id" class="form-control">
                        <option value="{{$submenu->primary_menu->id}}" selected readonly>{{$submenu->primary_menu->name}}</option>
                        @foreach ($primary_menus as $primary_menu)
                        <option value="{{$primary_menu->id}}">{{$primary_menu->name}}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="is_published">Is_Published</label>
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $submenu->is_published) ? 'checked' : '' }}>
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
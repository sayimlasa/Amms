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
                <h3 class="card-title">Create Primary Menu</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{route('primary_menus.store')}}">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                  </div>

                  <div class="form-group">
                    <label for="route">Route</label>
                    <input type="text" class="form-control" id="route" name="route">
                  </div>

                  <div class="form-group">
                    <label for="external_url">External Url</label>
                    <input type="text" class="form-control" id="external_url" name="external_url">
                  </div>

                  <div class="form-group">
                    <label for="menu">Menu</label>
                    <select name="menu_id" id="menu_id" class="form-control">
                        <option value="" selected disabled>select menu</option>
                        @foreach ($menus as $menu)
                        <option value="{{$menu->id}}">{{$menu->name}}</option>
                        @endforeach
                    </select>
                  </div>

                  <div id="content-input" class="form-group" style="display: none;">
                <label for="content">Description</label>
                <input type="text" class="form-control" id="content" name="content">
            </div>

                  <div class="form-group">
                    <label for="no">No</label>
                    <input type="number" class="form-control" id="no" name="no">
                  </div>

                  <div class="form-group">
                    <label for="is_published">Is_Published</label> <br>
                    <input type="hidden" name="is_published" value="0">
                    <input style="transform: scale(2); margin:10px;" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                  </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                <script>
                    $(document).ready(function() {
                        $('#menu_id').change(function() {
                            var selectedOption = $(this).val();
                            if (selectedOption == '1') { 
                                $('#content-input').show();
                            } else {
                                $('#content-input').hide();
                            }
                        });
                    });
                </script>
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
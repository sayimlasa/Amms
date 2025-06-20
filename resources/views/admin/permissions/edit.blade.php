@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <!-- Add your content header here -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header align-items-center d-flex">
              <h6 class=" mb-0 flex-grow-1">Edit Permission</h6>
            </div><!-- end card header -->
            <div class="card-body">
              <div class="live-preview">
                <form method="POST" action="{{route('admin.permissions.update',$permission)}}">
                @method('PUT')
                  @csrf
                  <div class="row g-4">
                    <!-- Full Name Input -->
                    <div class="col-xxl-3 col-md-6">
                      <div>
                        <label for="name" class="form-label">Permission Name</label>
                        <input type="text" class="form-control" id="name" name="title" placeholder="Enter Permission Name" value="{{$permission->title}}">
                      </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="col-12">
                      <div class="text-end">
                        <button type="submit" class="btn btn-success">Create</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div><!-- /.container-fluid -->
          </div><!-- /.card -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@yield('script')

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
@endsection
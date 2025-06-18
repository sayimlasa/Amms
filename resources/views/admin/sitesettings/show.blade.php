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
            <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-info" href="{{ route('sitesettings.index') }}">
                                Back To List
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{'setting id'}}
                                    </th>
                                    <td>
                                        {{ $siteSetting->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'setting name' }}
                                    </th>
                                    <td>
                                        {{ $siteSetting->key }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'setting name' }}
                                    </th>
                                    <td>
                                        {{ $siteSetting->value }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'Is Published?' }}
                                    </th>
                                    <td>
                                        {{ $siteSetting->is_published == 1 ? 'Yes' : 'No' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
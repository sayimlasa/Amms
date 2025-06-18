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
                            <a class="btn btn-info" href="{{ route('primary_menus.index') }}">
                                Back To List
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{'prrimary menu id'}}
                                    </th>
                                    <td>
                                        {{ $primary_menu->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'primary menu name' }}
                                    </th>
                                    <td>
                                        {{ $primary_menu->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'primary menu route' }}
                                    </th>
                                    <td>
                                        {{ $primary_menu->route }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'primary menu External Url' }}
                                    </th>
                                    <td>
                                        {{ $primary_menu->external_ulr }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'Is Published?' }}
                                    </th>
                                    <td>
                                        {{ $primary_menu->is_published == 1 ? 'Yes' : 'No' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'primary menu no' }}
                                    </th>
                                    <td>
                                        {{ $primary_menu->no }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'primary menu Menu' }}
                                    </th>
                                    <td>
                                        {{ $primary_menu->menu->name }}
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
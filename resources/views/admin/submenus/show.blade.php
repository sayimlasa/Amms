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
                            <a class="btn btn-info" href="{{ route('submenus.index') }}">
                                Back To List
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{'sub menu id'}}
                                    </th>
                                    <td>
                                        {{ $submenu->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'submenu name' }}
                                    </th>
                                    <td>
                                        {{ $submenu->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'submenu route' }}
                                    </th>
                                    <td>
                                        {{ $submenu->route }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'submenu External Url' }}
                                    </th>
                                    <td>
                                        {{ $submenu->external_ulr }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'Is Published?' }}
                                    </th>
                                    <td>
                                        {{ $submenu->is_published == 1 ? 'Yes' : 'No' }}
                                    </td>
                                </tr>
                              
                                <tr>
                                    <th>
                                        {{ 'primary menu ' }}
                                    </th>
                                    <td>
                                        {{ $submenu->primary_menu->name }}
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
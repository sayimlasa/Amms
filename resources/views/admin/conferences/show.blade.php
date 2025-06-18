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
                            <a class="btn btn-info" href="{{ route('conferences.index') }}">
                                Back To List
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{'conference id'}}
                                    </th>
                                    <td>
                                        {{ $conference->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'conference title' }}
                                    </th>
                                    <td>
                                        {{ $conference->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'conference theme' }}
                                    </th>
                                    <td>
                                        {{ $conference->theme }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'conference date' }}
                                    </th>
                                    <td>
                                        {{ $conference->date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'conference venue' }}
                                    </th>
                                    <td>
                                        {{ $conference->venue }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'conference region' }}
                                    </th>
                                    <td>
                                        {{ $conference->region }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'Is Published?' }}
                                    </th>
                                    <td>
                                        {{ $conference->is_published == 1 ? 'Yes' : 'No' }}
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
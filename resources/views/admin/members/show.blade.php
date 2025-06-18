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
                            <a class="btn btn-info" href="{{ route('members.index') }}">
                                Back To List
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{'member id'}}
                                    </th>
                                    <td>
                                        {{ $member->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'member name' }}
                                    </th>
                                    <td>
                                        {{ $member->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'member Title' }}
                                    </th>
                                    <td>
                                        {{ $member->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'Organization' }}
                                    </th>
                                    <td>
                                        {{ $member->organization }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'speaker type' }}
                                    </th>
                                    <td>
                                        {{$member->speaker->type}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'Conference' }}
                                    </th>
                                    <td>
                                        {{$member->conference->title}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'photo path' }}
                                    </th>
                                    <td>
                                        {{ $member->photo }}
                                    </td>
                                </tr>
                               
                                <tr>
                                    <th>
                                        {{ 'Is Published?' }}
                                    </th>
                                    <td>
                                        {{ $member->is_published == 1 ? 'Yes' : 'No' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ 'photo' }}
                                    </th>
                                    <td>
                                        <img src="/storage/{{ $member->photo }}" alt="photo" height="200px" width="200px">
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
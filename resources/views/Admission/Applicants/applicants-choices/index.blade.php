@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        @can('applicants_user_control_create')
        <div class="col-sm-6">
          <a href="{{route('applicants-choice.create')}}" class="btn btn-primary">Add Applicants Choice</a>
        </div>
        @endcan
        <div class="col-sm-6">
          @if(session('success'))
          <div id="success-message" class="alert alert-success">
            {{ session('success') }}
          </div>
          @endif
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="">Applicants Choice</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th> </th>
                    <th>ID</th>
                    <th>Index Number</th>
                    <th>Choice One</th>
                    <th>Choice Two</th>
                    <th>Choice Three</th>
                    <th>Academic Year</th>
                    <th>Intake</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($applicantschoice as $choice)
                  <tr>
                    <td></td>
                    <td>{{$choice->id}}</td>
                    <td>{{$choice->index_no}}</td>
                    <td>{{ $programs->where('id', $choice->choice1)->first()->name ?? 'N/A' }}</td>
                    <td>{{ $programs->where('id', $choice->choice2)->first()->name ?? 'N/A' }}</td>
                    <td>{{ $programs->where('id', $choice->choice3)->first()->name ?? 'N/A' }}</td>
                    <td>{{ $academic->where('id', $choice->academic_year_id)->first()->name ?? 'N/A' }}</td>
                    <td>{{ $intake->where('id', $choice->intake_id)->first()->name ?? 'N/A' }}</td>
                    <td>
                      @if($choice->status == 0)
                      Active
                      @else
                      Inactive
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
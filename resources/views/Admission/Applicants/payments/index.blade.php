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
          <!-- Flexbox container for horizontal alignment -->
          <div class="d-flex">
            <!-- Generate Control Number Button -->
            <a href="{{route('application-fee.create')}}" class="btn btn-primary me-2">Generate Control Number</a>

            <!-- View Control Number Button -->
            <form action="{{route('generate.controlno')}}" method="post">
              @csrf
              <button class="btn btn-xs btn-primary" type="submit" onclick="return confirm('Are you Sure?')">VIEW CONTROL NUMBER</button>
            </form>
          </div>
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
              <h3 class="">Applicants Control List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th> </th>
                    <th>ID</th>
                    <th>Index Number</th>
                    <th>Full Name</th>
                    <th>Control Number</th>
                    <th>Bill Id</th>
                    <th>Amount</th>
                    <th>Date Requested</th>
                    <th>Date Paid</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @php $count=1; @endphp
                  @foreach ($controlno as $p)
                  <tr>
                    <td></td>
                    <td>{{$count++}}</td>
                    <td>{{$p->index_id}}</td>
                    <td>{{$p->name}}</td>
                    <td>{{$p->control_number}}</td>
                    <td>{{$p->billId}}</td>
                    <td>{{$p->amount}}</td>
                    <td>{{$p->created_at}}</td>
                    <td>{{$p->date_paid}}</td>
                    <td style="color: {{ $p->status == 0 ? 'red' : 'green' }}">
                      @php
                      echo $p->status == 0 ? "Not Paid" : "Paid";
                      @endphp
                    </td>
                    <td>
                      <div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          @can('applicants_user_control_show')
                          <li>
                            <a class="btn btn-xs btn-primary" href="{{route('application-fee.show', $p)}}">{{'view'}}</a>
                          </li>
                          @endcan
                          @can('applicants_user_control_edit')
                          <li>
                            <a class="btn btn-xs btn-info" href="{{route('application-fee.edit', $p)}}">{{'edit'}}</a>
                          </li>
                          @endcan
                          @can('applicants_user_control_delete')
                          <li>
                            <form action="{{route('application-fee.destroy', $p)}}" method="post">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-xs btn-danger" type="submit" onclick="return confirm('Are you Sure?')">{{'delete'}}</button>
                            </form>
                          </li>
                          @endcan
                          <li>
                            <a class="btn btn-xs btn-warning" href="{{ route('refresh.control', $p->billId) }}">Refresh Get Control No</a>
                          </li>
                          <li>
                            <a class="btn btn-xs btn-warning" href="{{ route('application-fee.check-status', $p->control_number) }}">Check Payment Status</a>
                          </li>
                        </ul>
                      </div>
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

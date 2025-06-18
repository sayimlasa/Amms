@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="d-flex">
            <!-- Form to view control numbers (uncomment if needed) -->
            <!-- <form action="{{ route('generate.controlno') }}" method="POST"> -->
            <!-- @csrf -->
            <!-- </form> -->
          </div>
        </div>

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
              <h3 class="">Applicants Control No List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Index Number</th>
                      <th>Control Number</th>
                      <th>Amount</th>
                      <th>Date Requested</th>
                      <th>Date Paid</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $count = 1; @endphp
                    @foreach ($controlno as $p)
                    <tr>
                      <td>{{ $count++ }}</td>
                      <td>{{ $p->index_no }}</td>
                      <td>{{ $p->control_no }}</td>
                      <td>{{ $p->amount }}</td>
                      <td>{{ $p->created_at }}</td>
                      <td>{{ $p->pay_date }}</td>
                      <td>
                        @if ($p->status == 1)
                          <span class="badge bg-success">Paid</span>
                        @else
                          <span class="badge bg-warning">Not Paid</span>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
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

@section('scripts')
@parent

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
   $(document).ready(function() {
      if (!$.fn.dataTable.isDataTable('#example')) {
         $('#example').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
               { extend: 'copy', text: 'Copy' },
               { extend: 'csv', text: 'CSV' },
               { extend: 'excel', text: 'Excel' },
               { extend: 'pdf', text: 'PDF' },
               { extend: 'print', text: 'Print' }
            ]
         });
      }
   });
</script>

@endsection

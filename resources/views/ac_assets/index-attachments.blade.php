 @extends('layouts.admin')

 @section('content')
     <div class="col-sm-12">
         @if (session('success'))
             <div class="alert alert-success alert-dismissible fade show" role="alert">
                 <strong>Success!</strong> {{ session('success') }}
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
         @endif
     </div>

     <section class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <a href="{{ route('ac-assets.create') }}" class="btn btn-success">Add AC Asset Unit</a>
                 </div>
             </div>
         </div>
     </section>

     <div class="card">
         <div class="card-header">
             <h6 class="mb-0">AC Asset List</h6>
         </div>
         <div class="card-body">
             <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                 style="width:100%">
                 <thead class="table-light">
                     @php $na = 1; @endphp
                     <tr>
                         <th>#</th>
                         <th>Serial Number</th>
                         <th>Delivery Note Number</th>
                         <th>Invoice Number</th>
                          <th>Invoice Number Attachment</th>
                     </tr>

                 </thead>
                 <tbody>
                     @foreach ($attachments as $index => $attachment)
                         <tr>
                             <td>{{ $index + 1 }}</td>
                             <td>{{ $attachment->serial_number }}</td>
                             <td>{{ $attachment->derivery_note_number }}</td>
                             <td>{{ $attachment->invoice_no }}</td>

                             <td>
                                 @if ($attachment->invoice_number_attachment)
                                     <a href="{{ asset('storage/' . $attachment->invoice_number_attachment) }}"
                                         target="_blank">View</a>
                                 @else
                                     N/A
                                 @endif
                             </td>
                         </tr>
                     @endforeach
                 </tbody>
             </table>
         </div>
     </div>
 @endsection

 @section('scripts')
     @parent

     <!-- DataTables + Buttons CSS -->
     <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.flash.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

     <script>
         $(document).ready(function() {
             if (!$.fn.DataTable.isDataTable('#example')) {
                 $('#example').DataTable({
                     dom: 'Bfrtip',
                     buttons: [{
                             extend: 'copy',
                             className: 'btn btn-sm btn-secondary'
                         },
                         {
                             extend: 'csv',
                             className: 'btn btn-sm btn-info'
                         },
                         {
                             extend: 'excel',
                             className: 'btn btn-sm btn-success'
                         },
                         {
                             extend: 'pdf',
                             className: 'btn btn-sm btn-danger'
                         },
                         {
                             extend: 'print',
                             className: 'btn btn-sm btn-primary'
                         }
                     ]
                 });
             }
         });
     </script>
 @endsection

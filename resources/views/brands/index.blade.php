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
                    <a href="{{ route('brands.create') }}" class="btn btn-success">Add Location</a>
                </div>
            </div>
        </div>
    </section>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Brand List</h6>
        </div>
        <div class="card-body">
            <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $location)
                        <tr>
                            <td>{{ $location->name ?? '-' }}</td>
                            <td>{{ $location->created_at->format('Y-m-d') ?? '-' }}</td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item view-item-btn" href="{{ route('brands.show', ['brand' => $location->id]) }}">
                                                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item edit-item-btn" href="{{ route('brands.edit', ['brand' => $location->id]) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('brands.destroy', ['brand' => $location->id]) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item remove-item-btn">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
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
                    buttons: [
                        { extend: 'copy', className: 'btn btn-sm btn-secondary' },
                        { extend: 'csv', className: 'btn btn-sm btn-info' },
                        { extend: 'excel', className: 'btn btn-sm btn-success' },
                        { extend: 'pdf', className: 'btn btn-sm btn-danger' },
                        { extend: 'print', className: 'btn btn-sm btn-primary' }
                    ]
                });
            }
        });
    </script>
@endsection

@extends('layouts.admin')
@section('content')
<div class="col-sm-12">
    @if(session('success'))
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
                <a href="{{route('attachments.create')}}" class="btn btn-success">Add Attachment</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Applicants Attachments</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                @php $na = 1; @endphp
                <thead>
                    <tr>
                        <th>#</th>
                        <th data-ordering="true" hidden> id</th>
                        <th data-ordering="true"> Index Number</th>
                        <th data-ordering="true"> Type</th>
                        <th data-ordering="true"> Document</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attachments as $attachment)
                    <tr data-entry-id="{{ $attachment->id }}">
                        <td>{{$na}}</td>
                        <td hidden>{{ $attachment->id }}</td>
                        <td>{{ $attachment->index_no }}</td>
                        <td>{{ $attachment->type->name }}</td>
                        <!-- Table Row -->
                        <td>
    @if (file_exists(storage_path('app/public/' . $attachment->doc_url)))
        <a href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{ $attachment->id }}">View Document</a>

        <!-- Modal -->
        <div class="modal fade" id="viewModal{{ $attachment->id }}" tabindex="-1"
            aria-labelledby="viewModalLabel{{ $attachment->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel{{ $attachment->id }}">Document Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <!-- Display the Image with A4 Dimensions -->
                        <div class="a4-container">
                            <img src="{{ asset('storage/app/public/' . $attachment->doc_url) }}"
                                alt="Document Preview" class="img-fluid rounded a4-image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- Download Button -->
                        <a href="{{ asset('storage/app/public/' . $attachment->doc_url) }}"
                            class="btn btn-success" download>Download</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <span class="text-danger">File Missing</span>
    @endif
</td>
                    </tr>
                    @php $na++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
@endsection
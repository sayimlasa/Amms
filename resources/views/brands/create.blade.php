 @extends('layouts.admin')

@section('title') AC Assets @endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">AC Assets Unit</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('ac-assets.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label for="serial_number" class="form-label">Serial Number *</label>
                        <input type="text" class="form-control" name="serial_number" value="{{ old('serial_number') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="reference_number" class="form-label">Reference Number</label>
                        <input type="text" class="form-control" name="reference_number" value="{{ old('reference_number') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select name="supplier_id" class="form-select select2">
                            <option value="">-- Select Supplier --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="brand_id" class="form-label">Brand</label>
                        <select name="brand_id" class="form-select select2">
                            <option value="">-- Select Brand --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="warranty_expiry_date" class="form-label">Warranty Expiry Date</label>
                        <input type="text" class="form-control" name="warranty_expiry_date" value="{{ old('warranty_expiry_date') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="warranty_number" class="form-label">Warranty Number</label>
                        <input type="text" class="form-control" name="warranty_number" value="{{ old('warranty_number') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" name="model" value="{{ old('model') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" name="type" value="{{ old('type') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="capacity" class="form-label">Capacity</label>
                        <input type="text" class="form-control" name="capacity" value="{{ old('capacity') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="derivery_note_number" class="form-label">Delivery Note Number</label>
                        <input type="text" class="form-control" name="derivery_note_number" value="{{ old('derivery_note_number') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="derivery_note_date" class="form-label">Delivery Note Date</label>
                        <input type="date" class="form-control" name="derivery_note_date" value="{{ old('derivery_note_date') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="lpo_no" class="form-label">LPO Number</label>
                        <input type="text" class="form-control" name="lpo_no" value="{{ old('lpo_no') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="invoice_date" class="form-label">Invoice Date</label>
                        <input type="date" class="form-control" name="invoice_date" value="{{ old('invoice_date') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="invoice_no" class="form-label">Invoice Number</label>
                        <input type="text" class="form-control" name="invoice_no" value="{{ old('invoice_no') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="installation_date" class="form-label">Installation Date</label>
                        <input type="date" class="form-control" name="installation_date" value="{{ old('installation_date') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="installed_by" class="form-label">Installed By</label>
                        <input type="text" class="form-control" name="installed_by" value="{{ old('installed_by') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="condition" class="form-label">Condition *</label>
                        <select name="condition" class="form-select select2" required>
                            <option value="">-- Select Condition --</option>
                            <option value="New" @selected(old('condition') == 'New')>New</option>
                            <option value="Mid-used" @selected(old('condition') == 'Mid-used')>Mid-used</option>
                            <option value="Old" @selected(old('condition') == 'Old')>Old</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status *</label>
                        <select name="status" class="form-select select2" required>
                            <option value="">-- Select Status --</option>
                            <option value="Working" @selected(old('status') == 'Working')>Working</option>
                            <option value="Under Repair" @selected(old('status') == 'Under Repair')>Under Repair</option>
                            <option value="Scrapped" @selected(old('status') == 'Scrapped')>Scrapped</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="location_id" class="form-label">Location</label>
                        <select name="location_id" class="form-select select2">
                            <option value="">-- Select Location --</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="justification_form_no" class="form-label">Justification Form No</label>
                        <input type="text" class="form-control" name="justification_form_no" value="{{ old('justification_form_no') }}">
                    </div>
                    <div class="col-12 text-end mt-3">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Save Asset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Load Select2 CSS --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

{{-- Load jQuery & Select2 JS --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Select an option',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush

 @extends('layouts.admin')
@section('title', 'Edit AC Movement')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Edit AC Movement</h4>
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

                <form action="{{ route('ac-movements.update', $ac_movement->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    {{-- Serial Number --}}
                    <div class="col-md-6">
                        <label for="ac_id" class="form-label">Serial Number</label>
                        <select name="ac_id" id="ac_id" class="form-select select2" disabled>
                            <option value="">-- Select Serial Number --</option>
                            @foreach ($acAssets as $id => $serial)
                                <option value="{{ $id }}" {{ old('ac_id', $ac_movement->ac_id) == $id ? 'selected' : '' }}>
                                    {{ $serial }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Reference Number (auto-filled) --}}
                    <div class="col-md-6">
                        <label for="reference_number" class="form-label">Reference Number</label>
                        <input type="text" name="reference_number" id="reference_number"
                               class="form-control" value="{{ old('reference_number', $ac_movement->reference_number) }}" readonly>
                    </div>

                    {{-- From Location --}}
                    <div class="col-md-6">
                        <label for="from_location_id" class="form-label">From Location</label>
                        <select name="from_location_id" id="from_location_id" class="form-select select2" disabled>
                            <option value="">-- Select From Location --</option>
                            @foreach ($locations as $id => $name)
                                <option value="{{ $id }}" {{ old('from_location_id', $ac_movement->from_location_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- To Location --}}
                    <div class="col-md-6">
                        <label for="to_location_id" class="form-label">To Location</label>
                        <select name="to_location_id" id="to_location_id" class="form-select select2" disabled>
                            <option value="">-- Select To Location --</option>
                            @foreach ($locations as $id => $name)
                                <option value="{{ $id }}" {{ old('to_location_id', $ac_movement->to_location_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Remark --}}
                    <div class="col-md-6">
                        <label for="remark" class="form-label">Remark</label>
                        <textarea name="remark" id="remark" class="form-control" rows="3">{{ old('remark', $ac_movement->remark) }}</textarea>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: 'Select an option',
            allowClear: true,
            width: '100%'
        });

        // Fetch reference_number when serial number changes
        $('#ac_id').on('change', function () {
            let assetId = $(this).val();
            if (assetId) {
                $.ajax({
                    url: '/ac-assets/' + assetId,
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#reference_number').val(data.reference_number || '');
                    },
                    error: function () {
                        $('#reference_number').val('');
                    }
                });
            } else {
                $('#reference_number').val('');
            }
        });
    });
</script>
@endpush

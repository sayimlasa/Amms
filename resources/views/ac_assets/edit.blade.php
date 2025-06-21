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
                <h4>Edit AC Asset Unit</h4>
            </div>
            <div class="col-sm-6 text-end">
                <a href="{{ route('ac-assets.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-body">
        <form action="{{ route('ac-assets.update', $asset->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="serial_number" class="form-label">Serial Number</label>
                <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                       id="serial_number" name="serial_number"
                       value="{{ old('serial_number', $asset->serial_number) }}">
                @error('serial_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control @error('model') is-invalid @enderror"
                       id="model" name="model"
                       value="{{ old('model', $asset->model) }}">
                @error('model')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control @error('type') is-invalid @enderror"
                       id="type" name="type"
                       value="{{ old('type', $asset->type) }}">
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="condition" class="form-label">Condition</label>
                <select class="form-select @error('condition') is-invalid @enderror"
                        id="condition" name="condition">
                    <option value="">Select condition</option>
                    @foreach(['New', 'Good', 'Fair', 'Poor'] as $condition)
                        <option value="{{ $condition }}"
                            {{ old('condition', $asset->condition) == $condition ? 'selected' : '' }}>
                            {{ $condition }}
                        </option>
                    @endforeach
                </select>
                @error('condition')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror"
                        id="status" name="status">
                    <option value="">Select status</option>
                    @foreach(['Active', 'Inactive', 'Under Repair'] as $status)
                        <option value="{{ $status }}"
                            {{ old('status', $asset->status) == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="location_id" class="form-label">Location</label>
                <select class="form-select @error('location_id') is-invalid @enderror"
                        id="location_id" name="location_id">
                    <option value="">Select location</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}"
                            {{ old('location_id', $asset->location_id) == $location->id ? 'selected' : '' }}>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
                @error('location_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Asset</button>
        </form>
    </div>
</div>

@endsection

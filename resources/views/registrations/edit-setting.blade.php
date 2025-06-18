@extends('layouts.admin')

@section('content')
    <div class="col-sm-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Edit Tution Fee</h3>
                </div>
            </div>
        </div>
    </section>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('payment.setting.update', $setting->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="level_id">Level</label>
                    <select name="level_id" id="level_id" class="form-control">
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}" {{ old('level_id', $setting->level_id) == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('level_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" id="amount" class="form-control" value="{{ $setting->amount }}" required>
                    @error('amount')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="computing">Is Computing?</label>
                    <input type="checkbox" name="computing" id="computing" value="1" {{ $setting->computing ? 'checked' : '' }}>
                    @error('computing')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
@endsection

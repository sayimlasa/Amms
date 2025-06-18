@extends('layouts.admin')

@section('content')
    <div class="container">
        <h4>Applicant Status</h4>

        <!-- Check if session data exists -->
        @if(session('f4indexno') && session('statusDescription'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Form Four Index Number:</strong> {{ session('f4indexno') }}<br>
            {{-- <strong>Status Code:</strong> {{ session('statusCode') }}<br> --}}
            <strong>Status Description:</strong> {{ session('statusDescription') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        
        <form action="{{ route('check.store.dar') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="indexno">Form Four Index Number</label>
                <input type="text" class="form-control @error('indexno') is-invalid @enderror" id="indexno" name="indexno" placeholder="S0000/0000/0000" required>
                @error('indexno')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Check Status</button>
            </div>
        </form>
    </div>
@endsection

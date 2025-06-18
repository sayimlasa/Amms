@extends('layouts.admin')

@section('content')
    <div class="container">
        <h4>Applicant Verification Status</h4>

        {{-- Check if the "Response" key exists and has applicants --}}
        @if(isset($arrayResponse['Response']['Applicant']) && is_array($arrayResponse['Response']['Applicant']))
            {{-- Loop through each applicant --}}
            @foreach($arrayResponse['Response']['Applicant'] as $applicant)
                <form action="{{ route('applicant.update', $applicant['f4indexno']) }}" method="POST">
                    @csrf
                    @method('PUT')  {{-- If you are updating the applicant status --}}
                    
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>Applicant: {{ $applicant['f4indexno'] }}</strong>
                        </div>
                        <div class="card-body">
                                <h1>Applicants Verification Status</h1> 
                                @if (isset($arrayResponse['Response']['ResponseParameters']['Applicant']) && count($arrayResponse['Response']['ResponseParameters']['Applicant']) > 0)
                                    <table border="1">
                                        <thead>
                                            <tr>
                                                <th>Index No</th>
                                                <th>Verification Status Code</th>
                                                <th>Admission Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($arrayResponse['Response']['ResponseParameters']['Applicant'] as $applicant)
                                                <tr>
                                                    <td>{{ $applicant['f4indexno'] }}</td>
                                                    <td>{{ $applicant['VerificationStatusCode'] }}</td>
                                                    <td>{{ $applicant['AdmissionStatus'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p>No applicants found or there was an issue with the data.</p>
                                @endif
                            {{-- Add a submit button for each applicant's form --}}
                            <button type="submit" class="btn btn-primary">Update Applicant Status</button>
                        </div>
                    </div>
                </form>
            @endforeach
        @else
            <div class="alert alert-warning">
                No applicants found or the data format is unexpected.
            </div>
        @endif
    </div>
@endsection

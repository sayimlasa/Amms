<?php

namespace App\Http\Controllers\Admissions\Applicants;

use App\Http\Controllers\Controller;
use App\Models\ApplicantStatus;
use App\Models\VerificationNacte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApplicantStatusController extends Controller
{
    public function certicatediploma()
    {
        // Fetch data from the VerificationNacte table where status is 1
        $certificateDiploma = VerificationNacte::where('ors_status', 0)->get();

        // Check if there are records in the collection
        if ($certificateDiploma->isEmpty()) {
            return redirect()->route('verification.arusha')->with('error', 'No data found for the specified criteria. Please check and try again.');
         }

        // Loop through each record in the certificateDiploma collection
        foreach ($certificateDiploma as $data) {
            // Save or update the corresponding record in ApplicantStatus
            $savedRecord = ApplicantStatus::updateOrCreate(
                [
                    'index_number' => $data->username, // Use object properties
                ],
                [
                    'academic_year_id' => $data->academic_year_id,
                    'intake_id'=>$data->intake_id,
                    'campus_id' => $data->campus_id,
                    'programme_id' => $data->programme_id, // Corrected field name
                    'status' => $data->status,
                ]
            );
            Log::info("Applicants Status ".$savedRecord);
            // Update the 'ors_status' field in the VerificationNacte table
            VerificationNacte::where('username', $data->username)
                ->update(['ors_status' => 1]);
        }

        // Return a JSON response after data has been successfully transferred
        return redirect()->route('verification.arusha')->with('success','Successfdully uploaded the Status of applicants');
    }
}

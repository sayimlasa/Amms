<?php

namespace App\Http\Controllers\Admissions\Applicants;

use App\Models\Campus;
use App\Models\Programme;
use Illuminate\Http\Request;
use App\Models\ApplicantsInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\SelectedDiplomaCertificate;
use App\Http\Controllers\Applicant\ApplicantsPayment;

class SelectedApplicantController extends Controller
{
    public function index(Request $request)
    {
        $programmes = Programme::all();
        $campuses = Campus::all();
        //request from from    
        $programmeId = $request->input('programme_id');
        $campusId = $request->input('campus_id');
        $gender = $request->input('gender');
        $selectedApplicants = SelectedDiplomaCertificate::when($programmeId, function ($query) use ($programmeId) {
            $query->where('iaa_programme_code', $programmeId);
        })->when($campusId, function ($query) use ($campusId) {
            $query->where('campus_id', $campusId);
        })->when($gender, function ($query) use ($gender) {
            $query->where('gender', $gender);
        })
            ->get();

        return view('Admission.Applicants.selections.index-selected', compact('selectedApplicants', 'programmes', 'campuses'));
    }
    public function unselected(Request $request)
    {
        // Fetch all programmes
        $programmes = Programme::all();
        // Request from the form
        $programmeId = $request->input('programme_id');
        $result = DB::table('applicants_infos')
        ->join('applicants_choices as choice', 'choice.applicant_user_id', '=', 'applicants_infos.applicant_user_id')
        ->where(function($query) use ($programmeId) {
            $query->where('choice.choice1', $programmeId)
                  ->orWhere('choice.choice2', $programmeId)
                  ->orWhere('choice.choice3', $programmeId);
        })
        ->select([
            'applicants_infos.fname as fname',
            'applicants_infos.lname as lname',
            'applicants_infos.index_no as index_no',
            DB::raw("
                CASE
                    WHEN choice.choice1 = :programmeId THEN choice.choice1
                    WHEN choice.choice2 = :programmeId THEN choice.choice2
                    WHEN choice.choice3 = :programmeId THEN choice.choice3
                    ELSE NULL
                END as programme_id
            ", ['programmeId' => $programmeId]),
        ])
        ->get();
    

        Log::info($result);
        return view('Admission.Applicants.selections.index-selected', compact('programmes'));
        }

     
}

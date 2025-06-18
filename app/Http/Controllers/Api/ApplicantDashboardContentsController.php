<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ApplicantAttachment;
use App\Models\ApplicantsAcademic;
use App\Models\ApplicantsChoice;
use App\Models\ApplicantsInfo;
use App\Models\ApplicantsPayment;
use App\Models\ApplicationCategory;
use App\Models\Campus;
use App\Models\NextOfKin;
use Illuminate\Http\Request;

class ApplicantDashboardContentsController extends Controller
{
    public function applicantDashboardDetails(Request $request)
{
    // Validate input data
    $validatedData = $request->validate([
        'applicant_user_id' => 'required|integer|exists:applicants_infos,applicant_user_id',
        'index_no' => 'required|string|exists:applicants_infos,index_no',
    ]);

    // Check for an active academic year
    $academic_year = AcademicYear::where('active', 1)->first();
    if (!$academic_year) {
        return response()->json([
            'success' => false,
            'message' => 'No active academic year found.',
        ], 404);
    }

    // Fetch applicant information
    $applicant_info = ApplicantsInfo::with('region', 'country', 'district')
        ->where('applicant_user_id', $validatedData['applicant_user_id'])
        ->where('index_no', $validatedData['index_no'])
        ->where('acadmic_year_id', $academic_year->id)
        ->first();

    if (!$applicant_info) {
        return response()->json([
            'success' => false,
            'message' => 'Applicant information not found for the provided details.',
        ], 404);
    }

    // Retrieve application category, campus, and next of kin
    $application_category = ApplicationCategory::find($applicant_info->application_category_id);
    $campus = Campus::find($applicant_info->campus_id);
    $next_of_kin = NextOfKin::with('region', 'country', 'district')
        ->where('applicant_user_id', $applicant_info->applicant_user_id)
        ->first();

    // Fetch academic details
    $academics = ApplicantsAcademic::with('educationLevel')
        ->where('applicant_user_id', $applicant_info->applicant_user_id)
        ->get();

    $academicDetails = $academics->map(function ($academic) {
        return [
            'level' => $academic->educationLevel->name ?? 'N/A',
            'center' => $academic->center_name ?? 'N/A',
            'completion_year' => $academic->yoc ?? 'N/A',
            'gpa_division' => $academic->gpa_divission ?? 'N/A',
        ];
    });

    // Fetch attachments
    $attachments = ApplicantAttachment::with('type')
        ->where('applicant_user_id', $applicant_info->applicant_user_id)
        ->get();

    $attachmentDetails = $attachments->map(function ($attachment) {
        return [
            'attachment' => $attachment->type->name ?? 'N/A',
        ];
    });

    // Fetch payment details
    $payments = ApplicantsPayment::where('applicant_user_id', $applicant_info->applicant_user_id)
        ->where('academic_year_id', $academic_year->id)
        ->first();

    // Fetch choices
    $choices = ApplicantsChoice::with('programmeChoice1', 'programmeChoice2', 'programmeChoice3')
        ->where('applicant_user_id', $applicant_info->applicant_user_id)
        ->where('academic_year_id', $academic_year->id)
        ->first();

    // Construct the response
    return response()->json([
        'success' => true,
        'applicantinfo' => [
            'info' => trim($applicant_info->fname . ' ' . $applicant_info->mname . ' ' . $applicant_info->lname) ?: 'N/A',
            'location' => trim($applicant_info->country->name ?? 'N/A') . ', ' .
                          trim($applicant_info->region->name ?? 'N/A') . ', ' .
                          trim($applicant_info->district->name ?? 'N/A'),
        ],
        'application_category' => $application_category->name ?? 'N/A',
        'campus' => $campus->name ?? 'N/A',
        'nextofkin' => $next_of_kin ? [
            'info' => trim($next_of_kin->fname . ' ' . $next_of_kin->mname . ' ' . $next_of_kin->lname) ?: 'N/A',
            'location' => trim($next_of_kin->country->name ?? 'N/A') . ', ' .
                          trim($next_of_kin->region->name ?? 'N/A') . ', ' .
                          trim($next_of_kin->district->name ?? 'N/A'),
        ] : 'N/A',
        'academics' => $academicDetails->isEmpty() ? 'No academic records found.' : $academicDetails,
        'attachments' => $attachmentDetails->isEmpty() ? 'No attachments found.' : $attachmentDetails,
        'payments' => $payments ? [
            'control_number' => $payments->control_no ?? 'N/A',
            'amount' => $payments->amount ?? 'N/A',
            'status' => $payments->status ?? 'N/A',
        ] : 'No payment details found.',
        'choices' => $choices ? [
            'choice1' => $choices->programmeChoice1->name ?? 'N/A',
            'choice2' => $choices->programmeChoice2->name ?? 'N/A',
            'choice3' => $choices->programmeChoice3->name ?? 'N/A',
        ] : 'No choices found.',
    ], 200);
}

}

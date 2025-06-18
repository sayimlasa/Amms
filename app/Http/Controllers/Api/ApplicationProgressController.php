<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ApplicantsInfo;
use App\Models\ApplicationProgress;
use App\Models\AttachmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApplicationProgressController extends Controller
{
    public function getApplicationProgress($applicant_user_id)
    {
        try {
            // Check for active academic year
            $academic_year = AcademicYear::where('active', 1)->first();

            if (!$academic_year) {
                // Log error and return a 404 if no active academic year is found
                Log::error("No active academic year found.");
                return response()->json(['error' => 'No active academic year found.'], 404);
            }

            // Retrieve progress for the applicant in the active academic year
            $progress = ApplicationProgress::where('applicant_user_id', $applicant_user_id)
                ->where('academic_year_id', $academic_year->id)
                ->get();

            if ($progress->isEmpty()) {
                // Log and return a 404 if no progress records are found
                Log::error("No progress records found for applicant user ID {$applicant_user_id}.");
                return response()->json(['error' => 'No progress records found for this applicant in the current academic year.'], 404);
            }

            // If progress records found, return them with a 200 response
            Log::info("Fetched application progress for applicant user ID {$applicant_user_id}.", ['progress' => $progress]);
            return response()->json($progress, 200);
        } catch (\Exception $e) {
            // Log the exception error
            Log::error("Error fetching application progress: " . $e->getMessage(), ['exception' => $e]);

            // Return a generic error response with a 500 status code
            return response()->json(['error' => 'An error occurred while fetching the application progress.'], 500);
        }
    }
    public function haveAttachment($applicant_user_id)
{
    // Check for active academic year
    $academic_year = AcademicYear::where('active', 1)->first();
    if (!$academic_year) {
        return response()->json([
            'success' => false,
            'message' => 'No active academic year found.',
            'attachment' => false,
        ], 404);
    }

    // Fetch the application category ID for the applicant
    $category_id = ApplicantsInfo::select('application_category_id')
        ->where('acadmic_year_id', $academic_year->id)
        ->where('applicant_user_id', $applicant_user_id)
        ->value('application_category_id');

    if (!$category_id) {
        return response()->json([
            'success' => true,
            'message' => 'No application category found for the applicant.',
            'attachment' => false,
        ]);
    }

    // Fetch the total count of attachments for the category
    $totalAttachments = AttachmentType::whereHas('attachmentTypesCategories', function ($query) use ($category_id) {
        $query->where('application_category_id', $category_id);
    })->count();

    if ($totalAttachments === null || $totalAttachments === 0) {
        return response()->json([
            'success' => true,
            'message' => 'No attachments found for the category.',
            'attachment' => false,
        ]);
    }

    // If attachments exist
    return response()->json([
        'success' => true,
        'message' => 'Attachments exist for the category.',
        'attachment' => true,
        'totalAttachments' => $totalAttachments,
    ]);
}

}

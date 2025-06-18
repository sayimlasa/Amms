<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApplicantAttachment;
use App\Models\AttachmentType;
use Illuminate\Http\Request;

class AttachmentsController extends Controller
{
    public function getAttachmentTypes($applicationCategoryId)
    {
        // Validate the applicationCategoryId to ensure it is a number
        if (!is_numeric($applicationCategoryId)) {
            return response()->json([
                'error' => 'Invalid application category ID provided.'
            ], 400);
        }

        // Fetch education levels related to the given application category
        $attachmentTypes = AttachmentType::whereHas('attachmentTypesCategories', function ($query) use ($applicationCategoryId) {
            $query->where('application_category_id', $applicationCategoryId);
        })->get();

        // Return education levels as a JSON response
        return response()->json([
            'success' => true,
            'data' => $attachmentTypes,
        ]);
    }
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validated = $request->validate([
                'applicant_user_id' => 'required|exists:applicants_users,id',
                'index_no' => 'required|string',
                'type_id' => 'required|exists:attachment_types,id',
                'doc_url' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048', // Allow images under 2MB
            ]);

            // Store the uploaded file in the 'public/applicants-attachments' directory
            $filePath = $request->file('doc_url')->store('applicants-attachments', 'public');

            // Use the `updateOrCreate` method to either update an existing record or create a new one
            $attachment = ApplicantAttachment::updateOrCreate(
                [
                    'applicant_user_id' => $validated['applicant_user_id'],
                    'index_no' => $validated['index_no'],
                    'type_id' => $validated['type_id'],
                ],
                [
                    'doc_url' => $filePath, // Update with the new file path
                ]
            );

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully!',
                'data' => $attachment, // Return the created/updated attachment
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Handle any other errors
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAttachments($applicant_user_id, $type_id)
    {
        $attachments = ApplicantAttachment::where('applicant_user_id', $applicant_user_id)
            ->where('type_id', $type_id)
            ->get();
    
        // Prepare response format
        if ($attachments->isEmpty()) {
            return response()->json([
                'error' => true,
                'message' => 'No attachments found',
                'data' => []
            ], 404);  // Use 404 or another appropriate status code
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Attachments fetched successfully',
            'data' => $attachments
        ], 200);
    }
    
}

<?php

namespace App\Http\Controllers\Admissions\Applicants;

use App\Http\Controllers\Controller;
use App\Models\ApplicantAttachment;
use App\Models\ApplicantsInfo;
use App\Models\AttachmentType;
use Illuminate\Http\Request;

class ApplicantAttachmentController extends Controller
{
    public function index()
    {
        $attachments = ApplicantAttachment::get();
        return view('Admission.Applicants.attachments.index', compact('attachments'));
    }

    public function create()
    {
        $attachmentTypes = AttachmentType::get();
        $applicants = ApplicantsInfo::whereHas('academicYear', function ($query) {
            $query->where('active', 1);
        })->get();
        return view('Admission.Applicants.attachments.create', compact('attachmentTypes', 'applicants'));
    }

    public function store(Request $request)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'index_no' => 'required|string',
        'type_id' => 'required|exists:attachment_types,id',
        'doc_url' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048', // Allow images under 2MB
    ]);

    $selectedValue = $validated['index_no'];
    list($index_no, $applicant_user_id) = explode(',', $selectedValue);


    // Store the uploaded file in the 'public/applicants-attachments' directory
    $filePath = $request->file('doc_url')->store('applicants-attachments', 'public');


    // Use the `updateOrCreate` method to either update an existing record or create a new one
    ApplicantAttachment::updateOrCreate(
        [
            'applicant_user_id' => $applicant_user_id,
            'index_no' => $index_no,
            'type_id' => $validated['type_id'],
        ],
        [
            'doc_url' => $filePath, // Update with the new file path
        ]
    );

    // Redirect back to the index route with a success message
    return redirect()->route('attachments.index')->with('success', 'Attachment uploaded or updated successfully.');
}

}

<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApplicantsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApplicantAuthController extends Controller
{
    public function login(Request $request)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $validator->errors()
        ], 422);
    }

    // Find the applicant by email
    $applicant = ApplicantsUser::where('email', $request->email)->first();

    // Check if applicant exists
    if (!$applicant) {
        return response()->json([
            'status' => 'error',
            'message' => 'you do not have account please register',
        ], 404); // 404 Not Found
    }

    // Check if password matches
    if (!Hash::check($request->password, $applicant->password)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials',
        ], 401); // Unauthorized
    }

    $applicantInfo = $applicant->applicantInfo; // Use the relationship method

    // Check if related info exists
    if (!$applicantInfo) {
        return response()->json([
            'status' => 'error',
            'message' => 'Applicant information not found',
        ], 404);
    }

    // Revoke all previous tokens
    $applicant->tokens()->delete();

    // Issue a token
    $token = $applicant->createToken('Personal Access Token')->plainTextToken;

    // Return success response with the token
    return response()->json([
        'status' => 'success',
        'message' => 'Login successful',
        'token' => $token,
        'user' => [
            'id' => $applicant->id,
            'indexNumber' => $applicant->index_no,
            'email' => $applicant->email,
            'mobile_no' => $applicant->mobile_no,
            'info' => [
                'id' => $applicantInfo->id,
                'full_name' => $applicantInfo->fname." ".$applicantInfo->mname." ".$applicantInfo->lname,
                'application_category_id' => $applicantInfo->application_category_id,
                'campus_id' => $applicantInfo->campus_id,
        ],
        ]
    ]);
}

}

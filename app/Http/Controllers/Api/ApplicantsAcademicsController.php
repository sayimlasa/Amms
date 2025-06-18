<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApplicantsAcademic;
use App\Models\Form6Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApplicantsAcademicsController extends Controller
{
    public function academicDetails($applicant_user_id)
    {
        $applicantAcademics = ApplicantsAcademic::with('country', 'region', 'district', 'educationLevel')->where('applicant_user_id', $applicant_user_id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Academic details fetched successfully!',
            'data' => $applicantAcademics,
        ], 200);
    }

    public function store(Request $request, $id, $name)
    {
        try {
            // Map education level names to the corresponding store methods
            $educationLevelMethods = [
                'Primary' => 'storePrimary',
                'Form six' => 'storeFormSix',
                'Diploma' => 'storeDiploma',
                'Certificate' => 'storeCertificate',
                'Bachelor degree' => 'storeBachelorDegree',
            ];

            // Decode the name to handle encoded spaces and special characters
            $decodedName = urldecode($name);

            // Check if the decoded education level name is valid
            if (array_key_exists($decodedName, $educationLevelMethods)) {
                // Call the corresponding method
                return $this->{$educationLevelMethods[$decodedName]}($request, $id, $decodedName);
            }

            // Return a JSON error response if the name is invalid
            return response()->json([
                'success' => false,
                'message' => 'Invalid education level!',
            ], 400);
        } catch (\Exception $e) {
            // Catch and handle exceptions
            Log::error('Store Exception:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }



    // For each education level, define the corresponding store method
    protected function storePrimary(Request $request, $id, $name)
    {
        try {
            // Validate input data
            $validatedData = $request->validate([
                'applicant_user_id' => 'required|integer|exists:applicants_infos,applicant_user_id',
                'index_no' => 'required|string|exists:applicants_infos,index_no',
                'education_level' => 'required|integer|exists:education_levels,id',
                'course' => 'required|string',
                'yoc' => 'required|string',
                'center_name' => 'required|string',
                'country_id' => 'required|integer|exists:countries,id',
                'region_id' => 'required|integer|exists:regions_states,id',
                'district_id' => 'required|integer|exists:districts,id',
            ]);

            // Prepare data for creating or updating the record
            $primaryData = [
                'applicant_user_id' => $validatedData['applicant_user_id'],
                'index_no' => $validatedData['index_no'],
                'education_level' => $validatedData['education_level'],
                'course' => $validatedData['course'],
                'yoc' => $validatedData['yoc'],
                'center_name' => $validatedData['center_name'],
                'country_id' => $validatedData['country_id'],
                'region_id' => $validatedData['region_id'],
                'district_id' => $validatedData['district_id'],
            ];

            // Use `updateOrCreate` to handle create or update logic
            $primaryInfo = ApplicantsAcademic::updateOrCreate(
                [
                    'applicant_user_id' => $validatedData['applicant_user_id'],
                    'index_no' => $validatedData['index_no'],
                    'education_level' => $validatedData['education_level'],
                ],
                $primaryData
            );

            // Return a JSON response for success
            return response()->json([
                'success' => true,
                'message' => 'Primary education data saved successfully!',
                'data' => $primaryInfo,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Format validation errors into a user-friendly structure
            $errors = $e->validator->errors()->all();

            return response()->json([
                'success' => false,
                'message' => 'Validation failed!',
                'errors' => $errors, // Return all errors as an array
            ], 422);
        }
    }


    protected function storeFormSix(Request $request, $id, $name)
    {
        try {
            // Validate input data
            $validatedData = $request->validate([
                'applicant_user_id' => 'required|integer|exists:applicants_infos,applicant_user_id',
                'index_no' => 'required|string|exists:applicants_infos,index_no',
                'education_level' => 'required|integer|exists:education_levels,id',
                'qualification_no' => 'required|string',
                'course' => 'required|string',
                'country_id' => 'required|integer|exists:countries,id',
                'region_id' => 'required|integer|exists:regions_states,id',
                'district_id' => 'required|integer|exists:districts,id',
            ]);

            // Handle the qualification number logic
            $qualification_no = str_replace('/', '-', $validatedData['qualification_no']);
            $parts = explode('-', $qualification_no);
            if (count($parts) !== 3) {
                return response()->json(['error' => 'Invalid qualification number format.'], 400);
            }
            $index_number = $parts[0] . '-' . $parts[1];
            $exam_year = $parts[2];

            // API payload setup
            $payload = [
                'api_key' => '$2y$10$c8Fkezr4884riyJ7WW1AbeVXyfiMJeIWjCBVIfAXZw4Nj5LWS60.e',
                'index_number' => $index_number,
                'exam_year' => $exam_year,
                'exam_id' => 2,
            ];

            // Send POST request to external API
            $response = Http::acceptJson()->post('https://api.necta.go.tz/api/results/individual', $payload);

            // Check if the response is successful and is in JSON format
            if ($response->failed()) {
                Log::error('Failed API Request:', ['status_code' => $response->status(), 'body' => $response->body()]);
                return response()->json(['error' => 'Failed to communicate with external API.'], 500);
            }

            // Try to parse the response as JSON
            $responseData = json_decode($response->body(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Invalid JSON response:', ['response_body' => $response->body()]);
                return response()->json(['error' => 'Received invalid JSON from the external API.'], 500);
            }

            // Check if the API returned the expected result
            if (!isset($responseData['status']['code']) || $responseData['status']['code'] !== 1) {
                Log::error('API Error:', ['response_data' => $responseData]);
                return response()->json(['error' => 'Failed to fetch results from external API.'], 500);
            }

            // Process academic data and store it
            $sixData = [
                'applicant_user_id' => $validatedData['applicant_user_id'],
                'index_no' => $validatedData['index_no'],
                'education_level' => $validatedData['education_level'],
                'qualification_no' => $qualification_no,
                'course' => $validatedData['course'],
                'country_id' => $validatedData['country_id'],
                'yoc' => $exam_year,
                'region_id' => $validatedData['region_id'],
                'district_id' => $validatedData['district_id'],
                'center_name' => $responseData['particulars']['center_name'] ?? 'Unknown',
                'gpa_divission' => $responseData['results']['division'] ?? 'Not Available',
            ];

            // Insert or update academic record
            $sixInfo = ApplicantsAcademic::updateOrCreate(
                [
                    'applicant_user_id' => $validatedData['applicant_user_id'],
                    'index_no' => $validatedData['index_no'],
                    'education_level' => $validatedData['education_level'],
                ],
                $sixData
            );

            // Insert or update Form Six results
            foreach ($responseData['subjects'] as $subject) {
                $status = ($subject['grade'] == 'F') ? 0 : 1;
                $resultData = [
                    'applicant_user_id' => $validatedData['applicant_user_id'],
                    'qualification_no' => $qualification_no,
                    'subject_code' => $subject['subject_code'],
                    'subject_name' => $subject['subject_name'],
                    'marks' => $subject['marks'] ?? null,
                    'grade' => $subject['grade'],
                    'status' => $status,
                ];

                Form6Result::updateOrCreate(
                    [
                        'applicant_user_id' => $validatedData['applicant_user_id'],
                        'qualification_no' => $qualification_no,
                        'subject_code' => $subject['subject_code'],
                    ],
                    $resultData
                );
            }

            // Return successful response
            return response()->json([
                'success' => true,
                'message' => 'Form Six data saved successfully!',
                'data' => [
                    'academic_info' => $sixInfo,
                ]
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'error' => 'Validation failed.',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Handle any other errors
            Log::error('General Error:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
        }
    }



    protected function storeDiploma(Request $request, $id, $name)
    {
        try {
            // Validate input data
            $validatedData = $request->validate([
                'applicant_user_id' => 'required|integer|exists:applicants_infos,applicant_user_id',
                'index_no' => 'required|string|exists:applicants_infos,index_no',
                'education_level' => 'required|integer|exists:education_levels,id',
                'qualification_no' => 'required|string',
                'yoc' => 'required|string',
                'country_id' => 'required|integer|exists:countries,id',
                'region_id' => 'required|integer|exists:regions_states,id',
                'district_id' => 'required|integer|exists:districts,id',
            ]);
    
            // Handle the qualification number logic
            $avn = base64_encode($validatedData['qualification_no']);
    
            // Send GET request to external API with the base64-encoded qualification number
            $response = Http::acceptJson()->get('http://196.41.62.108:8080/esb/nacte.php?avn=' . $avn);
    
            // Check if the response is successful
            if ($response->failed()) {
                Log::error('Failed API Request:', [
                    'status_code' => $response->status(),
                    'body' => $response->body()
                ]);
                return response()->json(['error' => 'Failed to communicate with external API.'], 500);
            }
    
            // Check if the response body is valid JSON
            $responseBody = $response->body();
            $responseData = json_decode($responseBody, true);
    
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Handle non-JSON responses, e.g., HTML error pages
                Log::error('Invalid JSON response:', ['response_body' => $responseBody]);
                return response()->json([
                    'error' => 'invalid AVN number',
                ], 500);
            }
    
            // Handle specific API error response if the API indicates an invalid format
            if (isset($responseData['error']) && $responseData['error'] === 'API returned an invalid response format. Expected JSON.') {
                Log::error('API Error: Invalid response format', ['response_data' => $responseData]);
                return response()->json([
                    'error' => 'Please check the AVN or try again later.',
                    'details' => $responseData
                ], 400);
            }
    
            // Check if the expected fields are present in the response data
            if (!isset($responseData['firstname'], $responseData['middlename'], $responseData['surname'])) {
                Log::error('API Error: Missing expected fields', ['response_data' => $responseData]);
                return response()->json(['error' => 'Required information (name fields) not found in the API response.'], 400);
            }
    
            // If everything is successful, you can proceed to process the valid response
            $institution = $responseData['institution'];
            $programme = $responseData['programme'];
            $gpa = $responseData['gpa'];
            $avn = $responseData['avn'];
    
            // Process academic data and store it
            $diplomaData = [
                'applicant_user_id' => $validatedData['applicant_user_id'],
                'index_no' => $validatedData['index_no'],
                'education_level' => $validatedData['education_level'],
                'qualification_no' => $avn,
                'course' => $programme,
                'country_id' => $validatedData['country_id'],
                'yoc' => $validatedData['yoc'],
                'region_id' => $validatedData['region_id'],
                'district_id' => $validatedData['district_id'],
                'center_name' => $institution ?? 'Unknown',
                'gpa_divission' => $gpa ?? 'Not Available',
            ];
    
            // Insert or update academic record
            $diplomaInfo = ApplicantsAcademic::updateOrCreate(
                [
                    'applicant_user_id' => $validatedData['applicant_user_id'],
                    'index_no' => $validatedData['index_no'],
                    'education_level' => $validatedData['education_level'],
                ],
                $diplomaData
            );
    
            // Return successful response
            return response()->json([
                'success' => true,
                'message' => 'Form Six data saved successfully!',
                'data' => [
                    'academic_info' => $diplomaInfo,
                ]
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'error' => 'Validation failed.',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Handle any other errors
            Log::error('General Error:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
        }
    }
    

    

    protected function storeCertificate(Request $request, $id, $name)
    {
        try {
            // Validate input data
            $validatedData = $request->validate([
                'applicant_user_id' => 'required|integer|exists:applicants_infos,applicant_user_id',
                'index_no' => 'required|string|exists:applicants_infos,index_no',
                'education_level' => 'required|integer|exists:education_levels,id',
                'gpa_divission' => 'required|regex:/^\d+(\.\d)?$/',
                'qualification_no' => 'required|string',
                'course' => 'required|string',
                'yoc' => 'required|string',
                'center_name' => 'required|string',
                'country_id' => 'required|integer|exists:countries,id',
                'region_id' => 'required|integer|exists:regions_states,id',
                'district_id' => 'required|integer|exists:districts,id',
            ]);

            // Prepare data for creating or updating the record
            $bachelorData = [
                'applicant_user_id' => $validatedData['applicant_user_id'],
                'index_no' => $validatedData['index_no'],
                'education_level' => $validatedData['education_level'],
                'qualification_no' => $validatedData['qualification_no'],
                'gpa_divission' => $validatedData['gpa_divission'],
                'course' => $validatedData['course'],
                'yoc' => $validatedData['yoc'],
                'center_name' => $validatedData['center_name'],
                'country_id' => $validatedData['country_id'],
                'region_id' => $validatedData['region_id'],
                'district_id' => $validatedData['district_id'],
            ];

            // Use `updateOrCreate` to handle create or update logic
            $bachelorInfo = ApplicantsAcademic::updateOrCreate(
                [
                    'applicant_user_id' => $validatedData['applicant_user_id'],
                    'index_no' => $validatedData['index_no'],
                    'education_level' => $validatedData['education_level'],
                ],
                $bachelorData
            );

            // Return a JSON response for success
            return response()->json([
                'success' => true,
                'message' => 'Bachelor details saved successfully!',
                'data' => $bachelorInfo,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Format validation errors into a detailed response
            $errors = $e->validator->errors()->toArray();

            return response()->json([
                'success' => false,
                'message' => 'Validation failed!',
                'errors' => $errors, // Return all errors with field-specific messages
            ], 422);
        } catch (\Exception $e) {
            // Catch other exceptions to handle unexpected issues
            return response()->json([
                'success' => false,
                'message' => 'An error occurred!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    protected function storeBachelorDegree(Request $request, $id, $name)
    {
        try {
            // Validate input data
            $validatedData = $request->validate([
                'applicant_user_id' => 'required|integer|exists:applicants_infos,applicant_user_id',
                'index_no' => 'required|string|exists:applicants_infos,index_no',
                'education_level' => 'required|integer|exists:education_levels,id',
                'gpa_divission' => 'required|regex:/^\d+(\.\d)?$/',
                'qualification_no' => 'required|string',
                'course' => 'required|string',
                'yoc' => 'required|string',
                'center_name' => 'required|string',
                'country_id' => 'required|integer|exists:countries,id',
                'region_id' => 'required|integer|exists:regions_states,id',
                'district_id' => 'required|integer|exists:districts,id',
            ]);

            // Prepare data for creating or updating the record
            $bachelorData = [
                'applicant_user_id' => $validatedData['applicant_user_id'],
                'index_no' => $validatedData['index_no'],
                'education_level' => $validatedData['education_level'],
                'qualification_no' => $validatedData['qualification_no'],
                'gpa_divission' => $validatedData['gpa_divission'],
                'course' => $validatedData['course'],
                'yoc' => $validatedData['yoc'],
                'center_name' => $validatedData['center_name'],
                'country_id' => $validatedData['country_id'],
                'region_id' => $validatedData['region_id'],
                'district_id' => $validatedData['district_id'],
            ];

            // Use `updateOrCreate` to handle create or update logic
            $bachelorInfo = ApplicantsAcademic::updateOrCreate(
                [
                    'applicant_user_id' => $validatedData['applicant_user_id'],
                    'index_no' => $validatedData['index_no'],
                    'education_level' => $validatedData['education_level'],
                ],
                $bachelorData
            );

            // Return a JSON response for success
            return response()->json([
                'success' => true,
                'message' => 'Bachelor details saved successfully!',
                'data' => $bachelorInfo,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Format validation errors into a detailed response
            $errors = $e->validator->errors()->toArray();

            return response()->json([
                'success' => false,
                'message' => 'Validation failed!',
                'errors' => $errors, // Return all errors with field-specific messages
            ], 422);
        } catch (\Exception $e) {
            // Catch other exceptions to handle unexpected issues
            return response()->json([
                'success' => false,
                'message' => 'An error occurred!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ApplicantsInfo;
use App\Models\ApplicantsUser;
use App\Models\ApplicationCategory;
use App\Models\ApplicationWindow;
use App\Models\Form4Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ApplicationCategoriesController extends Controller
{
    public function index()
    {
        // Get the application_level_ids from active application windows
        $activeWindows = ApplicationWindow::where('active', 1)->pluck('application_level_id');

        // Get the active categories that match the active application windows by application_level_id
        $applicationCategories = ApplicationCategory::with(['application_level.campuses']) // Eager load related data if needed
            ->where('active', 1) // Only active categories
            ->whereIn('application_level_id', $activeWindows) // Match the application_level_id from active windows
            ->get();

        // $applicationCategories = ApplicationCategory::with(['application_level.campuses'])
        //     ->where('active', 1)
        //     ->get();

        return response()->json($applicationCategories, 200);
    }

    public function fetchStudentData(Request $request)
    {
        $academicYear = AcademicYear::select('id')->where('active', 1)->first();
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'index_no' => 'required|regex:/^[A-Za-z0-9]{5}\/[A-Za-z0-9]{4}\/[A-Za-z0-9]{4}$/', // validation for the index number
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'mobile_no' => 'required|regex:/^0\d{9,14}$/', // updated regex pattern
            'application_category_id' => 'required|exists:application_categories,id',
            'campus_id' => 'required|exists:campuses,id',
            // 'academic_year_id' => 'required|exists:academic_years,id',
            'active' => 'boolean',
        ]);

        // Return validation errors if any
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Extract values from index_no
        $email = $request->input('email');
        $password = $request->input('password');
        $mobile_no = $request->input('mobile_no');
        $application_category_id = $request->input('application_category_id');
        $campus_id = $request->input('campus_id');
        $academic_year_id = $academicYear->id;
        $active = $request->input('active');
        $index_no = $request->input('index_no');
        $parts = explode('/', $index_no);
        $indexNumber = implode('-', array_slice($parts, 0, 2)); // Convert S3921/0208 to S3921-0208
        $examYear = $parts[2]; // Extract the year

        // Prepare the payload for the API request
        $payload = [
            'api_key' => '$2y$10$c8Fkezr4884riyJ7WW1AbeVXyfiMJeIWjCBVIfAXZw4Nj5LWS60.e',
            'index_number' => $indexNumber,
            'exam_year' => $examYear,
            'exam_id' => 1,
        ];

        try {
            // Send the POST request to the external API using Laravel's HTTP client
            $response = Http::acceptJson()->post('https://api.necta.go.tz/api/results/individual', $payload);

            // Decode the JSON response
            $responseData = $response->json();

            // Prepare subjects data
            $subjects = array_map(function ($subject) {
                return [
                    'subject_code' => $subject['subject_code'] ?? null,
                    'subject_name' => $subject['subject_name'] ?? null,
                    'grade' => $subject['grade'] ?? null,
                ];
            }, $responseData['subjects'] ?? []);

            DB::beginTransaction();

            try {
                // Step 1: Check if the applicant exists with the same index_no and email in the same academic year
                $existingApplicant = ApplicantsUser::where('index_no', $request->input('index_no'))
                    ->where('email', $request->input('email'))
                    ->first();

                if ($existingApplicant) {
                    // Step 2: Check if the same index_no and email combination already exists in the same academic year
                    $existingInfo = ApplicantsInfo::where('applicant_user_id', $existingApplicant->id)
                        ->where('acadmic_year_id', $academicYear->id)
                        ->first();

                    if ($existingInfo) {
                        // If the applicant already exists for the same academic year, return an error
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Applicant already has an account for this academic year.',
                        ], 400);
                    } else {
                        // If the academic year is different, create a new record in ApplicantsInfo for the new academic year
                        $intake = $this->getIntakeId(); // Call method to get intake_id

                        // Step 3: Create a new record in ApplicantsInfo for the different academic year
                        ApplicantsInfo::create([
                            'applicant_user_id' => $existingApplicant->id,
                            'index_no' => $request->input('index_no'),
                            'fname' => $responseData['particulars']['first_name'] ?? null,
                            'mname' => $responseData['particulars']['middle_name'] ?? null,
                            'lname' => $responseData['particulars']['last_name'] ?? null,
                            'gender' => $responseData['particulars']['sex'] ?? null,
                            'application_category_id' => $request->input('application_category_id'),
                            'campus_id' => $request->input('campus_id'),
                            'acadmic_year_id' => $academicYear->id,
                            'nationality' => null, // Can be updated if you have a value for nationality
                            'district_id' => null, // Same for district
                            'intake_id' => $intake,
                        ]);

                        // Step 4: Update the mobile number if different
                        if ($existingApplicant->mobile_no !== $request->input('mobile_no')) {
                            $existingApplicant->update(['mobile_no' => $request->input('mobile_no')]);
                        }

                        // Step 5: Update the password if different
                        if ($existingApplicant->password !== bcrypt($request->input('password'))) {
                            $existingApplicant->update(['password' => bcrypt($request->input('password'))]);
                        }

                        return response()->json([
                            'status' => 'success',
                            'message' => 'Account updated successfully for the new academic year!',
                        ], 200);
                    }
                } else {
                    // Step 6: Check if the mobile number is already taken
                    $existingMobile = ApplicantsUser::where('mobile_no', $request->input('mobile_no'))->first();

                    if ($existingMobile) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'This mobile number is already registered.',
                        ], 400);
                    }

                    // Step 7: Check if the combination of index_no and email is already registered for the academic year
                    $existingIndexAndEmailForAcademicYear = ApplicantsInfo::where('index_no', $request->input('index_no'))

                        ->where('acadmic_year_id', $academicYear->id)
                        ->first();

                    if ($existingIndexAndEmailForAcademicYear) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'This index number and email combination already exists for the selected academic year.',
                        ], 400);
                    }

                    // Step 8: Create a new ApplicantsUser record
                    $applicantUser = ApplicantsUser::create([
                        'index_no' => $request->input('index_no'),
                        'email' => $request->input('email'),
                        'password' => bcrypt($request->input('password')),
                        'mobile_no' => $request->input('mobile_no'),
                        'active' => $request->input('active') ?? 1,
                    ]);

                    // Retrieve intake_id from ApplicationWindow
                    $intake = $this->getIntakeId();

                    // Step 9: Create a new ApplicantsInfo record
                    ApplicantsInfo::create([
                        'applicant_user_id' => $applicantUser->id,
                        'index_no' => $request->input('index_no'),
                        'fname' => $responseData['particulars']['first_name'] ?? null,
                        'mname' => $responseData['particulars']['middle_name'] ?? null,
                        'lname' => $responseData['particulars']['last_name'] ?? null,
                        'gender' => $responseData['particulars']['sex'] ?? null,
                        'application_category_id' => $request->input('application_category_id'),
                        'campus_id' => $request->input('campus_id'),
                        'acadmic_year_id' => $academicYear->id,
                        'nationality' => null,
                        'district_id' => null,
                        'intake_id' => $intake,
                    ]);

                    // Step 10: Store subjects in Form4Result
                    foreach ($subjects as $subject) {
                        $existingResult = Form4Result::where('index_no', $request->input('index_no'))
                            ->where('subject_code', $subject['subject_code'])
                            ->first();

                        if (!$existingResult) {
                            $status = ($subject['grade'] === 'F') ? 0 : 1;

                            Form4Result::create([
                                'applicant_user_id' => $applicantUser->id,
                                'index_no' => $request->input('index_no'),
                                'subject_code' => $subject['subject_code'],
                                'subject_name' => $subject['subject_name'],
                                'marks' => null,
                                'grade' => $subject['grade'],
                                'status' => $status,
                            ]);
                        }
                    }

                    DB::commit();

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Applicant created successfully!',
                    ], 201);
                }
            } catch (QueryException $e) {
                // Handle SQL errors like duplicate entries (1062)
                if ($e->getCode() == 23000 && strpos($e->getMessage(), '1062') !== false) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to create applicant. Error: Duplicate entry for email.',
                    ], 400);
                }

                // Handle other SQL exceptions or general exceptions
                return response()->json([
                    'status' => 'error',
                    'message' => 'An error occurred while processing the request. Please try again.',
                ], 500);
            }
        } catch (\Exception $e) {
            // In case of error, return a custom error response
            Log::error('Error fetching student data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch data.'], 500);
        }
    }

    private function getIntakeId()
    {
        $window = ApplicationWindow::where('active', 1)->first();
        if (!$window || !$window->intake) {
            throw new \Exception('Active application window or intake not found.');
        }
        return $window->intake->id;
    }
}

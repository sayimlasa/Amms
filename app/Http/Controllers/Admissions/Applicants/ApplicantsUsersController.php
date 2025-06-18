<?php

namespace App\Http\Controllers\Admissions\Applicants;

use App\Http\Controllers\Controller;
use App\Http\Requests\Applicants\Store\ApplicantsUserStoreRequest;
use App\Models\AcademicYear;
use App\Models\ApplicantsInfo;
use App\Models\ApplicantsUser;
use App\Models\ApplicationCategory;
use App\Models\ApplicationWindow;
use App\Models\Form4Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApplicantsUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    // Run the query to fetch the data
    $applicantsUsers = DB::select('
        SELECT applicants_users.id, applicants_users.active, applicants_users.index_no, applicants_users.email, applicants_users.mobile_no, 
               application_categories.name AS application_category_name, 
               campuses.name AS campus_name, 
               academic_years.name AS academic_year_name
        FROM applicants_users
        JOIN applicants_infos ON applicants_users.id = applicants_infos.applicant_user_id
        JOIN academic_years ON applicants_infos.acadmic_year_id = academic_years.id
        JOIN application_categories ON applicants_infos.application_category_id = application_categories.id
        JOIN campuses ON applicants_infos.campus_id = campuses.id
        WHERE academic_years.active = 1
    ');

    
    return view('Admission.Applicants.applicants-users.index', compact('applicantsUsers'));
}

    

    

    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $academicYear = AcademicYear::where('active', 1)->first();
        $applicationCategories = ApplicationCategory::with(['application_level.campuses'])->where('active', 1)->get();
        return view('Admission.Applicants.applicants-users.create', compact('academicYear', 'applicationCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fetchStudentData(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'index_no' => 'required|string',
            'exam_year' => 'required|integer',
        ]);

        // Format the index_number
        $indexArr = explode('/', $validated['index_no']); // Split by '/'
        $formattedIndexNumber = $indexArr[0] . '-' . $indexArr[1]; // Format it as 'S3921-0208'

        // Prepare the payload for the API request
        $payload = [
            'api_key' => '$2y$10$c8Fkezr4884riyJ7WW1AbeVXyfiMJeIWjCBVIfAXZw4Nj5LWS60.e',
            'index_number' => $formattedIndexNumber,
            'exam_year' => $validated['exam_year'],
            'exam_id' => 1,
        ];

        try {
            // Send the POST request to the external API using Laravel's HTTP client
            $response = Http::acceptJson()->post('https://api.necta.go.tz/api/results/individual', $payload);

            // Return the API response as JSON
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            // In case of error, return a custom error response
            Log::error('Error fetching student data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch data.'], 500);
        }
    }

    public function store(ApplicantsUserStoreRequest $request)
    {
        $academicYear = AcademicYear::select('id')->where('active',1)->first();
        // Begin the transaction to ensure atomicity
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
                    session()->flash('error', 'Applicant already has an account for this academic year.');
                    return redirect()->route('applicants-users.create');
                } else {
                    // If the academic year is different, create a new record in ApplicantsInfo for the new academic year
                    $intake = $this->getIntakeId(); // Call method to get intake_id

                    // Step 3: Create a new record in ApplicantsInfo for the different academic year
                    ApplicantsInfo::create([
                        'applicant_user_id' => $existingApplicant->id,
                        'index_no' => $request->input('index_no'),
                        'fname' => $request->input('first_name'),
                        'mname' => $request->input('middle_name'),
                        'lname' => $request->input('last_name'),
                        'gender' => $request->input('sex'),
                        'application_category_id' => $request->input('application_category_id'),
                        'campus_id' => $request->input('campus_id'),
                        'acadmic_year_id' => $academicYear->id,
                        'nationality' => null, // Can be updated if you have a value for nationality
                        'district_id' => null, // Same for district
                        'intake_id' => $intake,
                    ]);

                    // Flash success message for account update
                    session()->flash('success', 'Account updated successfully for the new academic year!');
                }

                // Step 4: Check if the mobile number is different from the stored one and update it
                if ($existingApplicant->mobile_no !== $request->input('mobile_no')) {
                    // If the mobile number is different, update it
                    $existingApplicant->update([
                        'mobile_no' => $request->input('mobile_no'),
                    ]);
                }

                // Step 5: Check if the password is different from the stored one and update it
                if ($existingApplicant->password !== bcrypt($request->input('password'))) {
                    // If the password is different, update it
                    $existingApplicant->update([
                        'password' => bcrypt($request->input('password')),
                    ]);
                }

            } else {
                // Step 6: Check if the mobile number is already taken
                $existingMobile = ApplicantsUser::where('mobile_no', $request->input('mobile_no'))->first();

                if ($existingMobile) {
                    // If the mobile number is already taken, return an error
                    session()->flash('error', 'This mobile number is already registered.');
                    return redirect()->route('applicants-users.index');
                }

                // Step 7: Check if the combination of index_no and email is already registered for the academic year
                $existingIndexAndEmailForAcademicYear = ApplicantsInfo::where('index_no', $request->input('index_no'))
                    ->where('email', $request->input('email'))
                    ->where('acadmic_year_id', $academicYear->id)
                    ->first();

                if ($existingIndexAndEmailForAcademicYear) {
                    // If the index_no and email combination is already taken for the selected academic year, return an error
                    session()->flash('error', 'This index number and email combination already exists for the selected academic year.');
                    return redirect()->route('applicants-users.index');
                }

                // Step 8: If the applicant doesn't exist, create a new one in ApplicantsUser
                $applicantUser = ApplicantsUser::create([
                    'index_no' => $request->input('index_no'),
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')), // Hash password with bcrypt
                    'mobile_no' => $request->input('mobile_no'),
                    'active' => $request->input('active'),
                ]);

                // Retrieve intake_id from ApplicationWindow
                $intake = $this->getIntakeId(); // Call method to get intake_id

                // Step 9: Create the record in ApplicantsInfo for the new academic year
                ApplicantsInfo::create([
                    'applicant_user_id' => $applicantUser->id,
                    'index_no' => $request->input('index_no'),
                    'fname' => $request->input('first_name'),
                    'mname' => $request->input('middle_name'),
                    'lname' => $request->input('last_name'),
                    'gender' => $request->input('sex'),
                    'application_category_id' => $request->input('application_category_id'),
                    'campus_id' => $request->input('campus_id'),
                    'acadmic_year_id' => $academicYear->id,
                    'nationality' => null, // Can be updated if you have a value for nationality
                    'district_id' => null, // Same for district
                    'intake_id' => $intake,
                ]);

                // Flash success message for new applicant creation
                session()->flash('success', 'Applicant created successfully!');
            }

            // Step 10: Store in Form4Result table (handling multiple subjects)
            foreach ($request->input('subjects') as $subject) {
                // Check if the result already exists for the given index_no
                $existingResult = Form4Result::where('index_no', $request->input('index_no'))
                    ->where('subject_code', $subject['subject_code'])
                    ->first();

                if (!$existingResult) {
                    // If no existing result, create a new one
                    $status = ($subject['grade'] === 'F') ? 0 : 1;

                    Form4Result::create([
                        'applicant_user_id' => $applicantUser->id,
                        'index_no' => $request->input('index_no'),
                        'subject_code' => $subject['subject_code'],
                        'subject_name' => $subject['subject_name'],
                        'marks' => null, // Assuming you will get marks or leave it as null
                        'grade' => $subject['grade'],
                        'status' => $status, // Store 0 for 'F' grade, 1 otherwise
                    ]);
                }
            }

            // Commit the transaction
            DB::commit();

            // Return to the applicant list with a success message
            return redirect()->route('applicants-users.index');

        } catch (\Exception $e) {
            // Rollback in case of an error
            DB::rollBack();

            // Log the error for debugging
            Log::error('Error storing applicant data: ' . $e->getMessage());

            // Flash an error message with the exception message and redirect
            session()->flash('error', 'Failed to create applicant. Error: ' . $e->getMessage());
            return redirect()->route('applicants-users.index');
        }
    }

    /**
     * Helper method to retrieve the current intake_id
     */
    private function getIntakeId()
    {
        $window = ApplicationWindow::where('active', 1)->first();
        if (!$window || !$window->intake) {
            throw new \Exception('Active application window or intake not found.');
        }
        return $window->intake->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApplicantsUser  $applicantsUser
     * @return \Illuminate\Http\Response
     */
    public function show(ApplicantsUser $applicantsUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApplicantsUser  $applicantsUser
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplicantsUser $applicantsUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApplicantsUser  $applicantsUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplicantsUser $applicantsUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApplicantsUser  $applicantsUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicantsUser $applicantsUser)
    {
        //
    }
}

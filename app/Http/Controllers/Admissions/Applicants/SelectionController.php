<?php

namespace App\Http\Controllers\Admissions\Applicants;

use App\Models\Intake;
use App\Models\Programme;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\ApplicationLevel;
use App\Models\ApplicationWindow;
use Illuminate\Support\Facades\DB;
use App\Models\ApplicationCategory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use PhpParser\Node\VarLikeIdentifier;
use App\Models\SelectedDiplomaCertificate;

class SelectionController extends Controller
{
    public function index(Request $request)
    {
        // Step 1: Get the active Academic Year, Intake, and Window
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();
        $window = ApplicationWindow::where('active', 1)->first();

        // Step 2: Check if the required records exist
        if (!$academicYear || !$intake || !$window) {
            return redirect()->back()->withErrors('Academic Year, Intake, or Window not active.');
        }

        // Step 3: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', '%Certicate%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        // Get the programme and category IDs related to the level
        $programme = Programme::where('application_level_id', $level->id)->get();
        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)->where('active', 1)
            ->pluck('id')->toArray();

        // Initialize variables
        $selectedApplicants = collect();
        $capacity = $request->input('capacity') ? (int) $request->input('capacity') : null;

        // Define query for SelectedDiplomaCertificate
        $query = SelectedDiplomaCertificate::query();

        // Step 4: Handle Programme ID filter
        if ($request->has('programme_id') && !empty($request->input('programme_id'))) {
            $programme_id = (int) $request->input('programme_id');
            $query->where('programme_id', $programme_id);
        }

        // Step 5: Fetch applicants and compare with capacity if provided
        $selectedApplicants = $query->list(
            $programme_id ?? null,
            $intake->id,
            $window->id,
            $academicYear->id,
            $categoryIds
        )->orderBy('status_count', 'DESC')
            ->get();

        $applicantCount = $selectedApplicants->count();


        // Step 6: Ensure the number of selected applicants matches the capacity
        if ($capacity !== null) {
            if ($applicantCount > $capacity) {
                // Trim the excess applicants
                $selectedApplicants = $selectedApplicants->take($capacity);
            } elseif ($applicantCount < $capacity) {
                // Padding with placeholders if fewer applicants than capacity
                $additionalApplicants = collect(); // Replace this with logic to fetch additional applicants if necessary
                $selectedApplicants = $selectedApplicants->merge($additionalApplicants)->take($capacity);
            }
        }

        // Step 7: Pass the data to the view
        return view('Admission.Applicants.selections.index-certificate', compact('programme', 'selectedApplicants'));
    }
    public function getApplicants(Request $request)
    {
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();
        $window = ApplicationWindow::where('active', 1)->first();

        if (!$academicYear || !$intake || !$window) {
            return response()->json([
                'error' => 'Academic Year, Intake, or Application Window not active.'
            ], 400);
        }

        $selected = [];

        if ($request->has('programme_id')) {
            $programme_id = $request->input('programme_id');

            $selected = DB::table('applicants_users')
                ->join('form4_results', 'form4_results.applicant_user_id', '=', 'applicants_users.id')
                ->join('applicants_choices', 'applicants_choices.applicant_user_id', '=', 'applicants_users.id')
                ->join('applicants_infos as ai', 'ai.applicant_user_id', '=', 'applicants_users.id')
                ->join('application_categories as ac', 'ai.application_category_id', '=', 'ac.id')
                ->join('nextof_kins', 'nextof_kins.applicant_user_id', '=', 'applicants_users.id')
                ->where(function ($query) use ($programme_id) {
                    $query->where('applicants_choices.choice1', '=', $programme_id)
                        ->orWhere('applicants_choices.choice2', '=', $programme_id)
                        ->orWhere('applicants_choices.choice3', '=', $programme_id);
                })
                ->where('applicants_choices.intake_id', '=', $intake->id)
                ->where('applicants_choices.window_id', '=', $window->id)
                ->where('applicants_choices.academic_year_id', '=', $academicYear->id)
                ->where('applicants_choices.status', '=', 0)
                ->whereIn('form4_results.grade', ['A', 'B+', 'B', 'C', 'D'])
                ->where('form4_results.status', '=', 1)
                ->where('ai.application_category_id', '=', 7)
                ->select(
                    'applicants_users.id as id',
                    'ai.fname as fname',
                    'ai.mname as mname',
                    'ai.lname as lname',
                    'ai.gender as gender',
                    'applicants_users.index_no as index_no',
                    DB::raw("CONCAT(nextof_kins.fname, ' ', COALESCE(nextof_kins.mname, ''), ' ', nextof_kins.lname) as next_of_kin_fullname"),
                    DB::raw("CASE
                        WHEN applicants_choices.choice1 = $programme_id THEN applicants_choices.choice1
                        WHEN applicants_choices.choice2 = $programme_id THEN applicants_choices.choice2
                        WHEN applicants_choices.choice3 = $programme_id THEN applicants_choices.choice3
                        ELSE 'No Program Selected'
                    END as programme_name"),
                    DB::raw('COUNT(CASE 
                        WHEN form4_results.status = 1 AND form4_results.subject_name NOT IN ("BIBLE KNOWLEDGE", "ELIMU YA DINI YA KIISLAMU")  
                        THEN 1 
                    END) as status_count')
                )
                ->groupBy(
                    'applicants_users.index_no',
                    'applicants_users.id',
                    'ai.fname',
                    'ai.mname',
                    'ai.lname',
                    'ai.gender',
                    'applicants_choices.choice1',
                    'applicants_choices.choice2',
                    'applicants_choices.choice3',
                    'nextof_kins.fname',
                    'nextof_kins.mname',
                    'nextof_kins.lname'
                )
                ->havingRaw('status_count >= 4')
                ->distinct()
                ->get();

            return response()->json([
                'data' => $selected,
                'count' => count($selected)
            ], 200);
        }

        return response()->json([
            'message' => 'No applicants found or programme_id not provided.'
        ], 404);
    }



    public function store(Request $request)
    {
        // Step 1: Get the active Academic Year, Intake, and Window
        $programme_id = (int) $request->input('programme_id');
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();
        $window = ApplicationWindow::where('active', 1)->first();

        // Check for active academic year, intake, and window
        if (!$academicYear || !$intake || !$window) {
            return redirect()->back()->withErrors('Academic Year, Intake, or Window is not active.');
        }

        // Step 2: Validate user input
        $request->validate([
            'programme_id' => 'required|integer|exists:programmes,id',
            'selected_applicants' => 'required|array|min:1',
            'selected_applicants.*' => 'exists:applicants_users,id',
        ], [
            'selected_applicants.required' => 'Please select at least one applicant to proceed.',
            'selected_applicants.*.exists' => 'One or more selected applicants are invalid.',
        ]);

        $selectedApplicantIds = $request->input('selected_applicants');
        //print_r($selectedApplicantIds);die();
        Log::info('Selected Applicant IDs:', $selectedApplicantIds);

        if (empty($selectedApplicantIds)) {
            return redirect()->back()->withErrors('Please select at least one applicant to proceed.');
        }

        // Step 3: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', '%Certicate%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }

        // Get the programme and category IDs related to the level
        //$programme = Programme::where('application_level_id', $level->id)->get();
        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)
            ->where('active', 1)->pluck('id')->toArray();

        $selected = collect();  // Initialize empty collection

        // Step 4: Get the programme ID from the request
        if ($request->has('programme_id')) {
            $programme_id = (int) $request->input('programme_id'); // Cast to an integer for safety

            // Step 5: Use the list method to fetch the data
            $selected = SelectedDiplomaCertificate::list(
                $programme_id,       // Pass just the programme ID (not the full model)
                $intake->id,         // Pass the intake ID
                $window->id,         // Pass the window ID
                $academicYear->id,   // Pass the academic year ID
                $categoryIds         // Pass the category IDs
            )->whereIn('applicants_users.id', $selectedApplicantIds)  // Use whereIn to match multiple IDs
                ->get();
        }
        Log::info("totla selected" . $selected);
        // Step 6: Save the selected applicants to the "selected_applicants" table
        foreach ($selected as $applicant) {
            // Check if applicant id exists
            $checkapplicants = SelectedDiplomaCertificate::where('applicant_user_id', $selectedApplicantIds)
                ->where('index_no', $applicant->index_no)->first();

            if ($checkapplicants) {
                return redirect()->back()->with("error", "Applicant with Index No: {$applicant->index_no} is already registered under another programme.");
            }

            $record = SelectedDiplomaCertificate::updateOrCreate(
                ['applicant_user_id' => $applicant->id], // Ensure no duplicate entries for the same applicant
                [
                    'index_no' => $applicant->index_no,
                    'first_name' => $applicant->fname,
                    'middle_name' => $applicant->mname,
                    'last_name' => $applicant->lname,
                    'gender' => $applicant->gender,
                    'dob' => $applicant->dob,
                    'disability' => $applicant->disability,
                    'email' => $applicant->email,
                    'mobile_no' => $applicant->mobile_no,
                    'physical_address' => $applicant->physical_address,
                    'campus_id' => $applicant->campus,
                    'region' => $applicant->region_info,
                    'district' => $applicant->district_info,
                    'nationality' => $applicant->nation,
                    'next_kin_name' => $applicant->next_of_kin_fullname,
                    'next_kin_address' => $applicant->next_keen_address,
                    'next_kin_email' => $applicant->next_keen_email,
                    'next_kin_phone' => $applicant->next_keen_mobile,
                    'next_kin_region' => $applicant->region_kin,
                    'next_kin_district' => $applicant->district_kin,
                    'next_kin_nationality' => $applicant->nation,
                    'next_kin_relationship' => $applicant->relation,
                    'iaa_programme_code' => $applicant->programme_id,
                    'application_year' => today()->year, // Laravel's today() helper
                    'intake' => $intake->id,
                    'window' => $window->id,
                    'status_count' => $applicant->status_count
                ]
            );
            Log::info($record);
            // Update status in applicants_choices table to 1 for the selected applicant
            DB::table('applicants_choices')
                ->where('applicant_user_id', $applicant->id)
                ->update(['status' => 1]);
        }

        // Redirect back or to another page with a success message
        return redirect()->route('applicants-selection.index')->with('success', 'Selected applicants have been saved and status updated.');
    }


    public function show(Request $request)
    {
        $programme_id = $request->input('programme_id');
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();
        $window = ApplicationWindow::where('active', 1)->first();

        // Check for active academic year, intake, and window
        if (!$academicYear || !$intake || !$window) {
            return redirect()->back()->withErrors('Academic Year, Intake, or Window is not active.');
        }
        // Validate user input
        $request->validate([
            'programme_id' => 'required|exists:programmes,id',
            'selected_applicants' => 'required|array|min:1',
            'selected_applicants.*' => 'exists:applicants_users,id',
        ], [
            'selected_applicants.required' => 'Please select at least one applicant to proceed.',
            'selected_applicants.*.exists' => 'One or more selected applicants are invalid.',
        ]);

        $selectedApplicantIds = $request->input('selected_applicants');
        Log::info('Selected Applicant IDs:', $selectedApplicantIds);

        if (empty($selectedApplicantIds)) {
            return redirect()->back()->withErrors('Please select at least one applicant to proceed.');
        }

        // Retrieve selected applicants based on filters
        $selected = DB::table('applicants_users')
            ->join('form4_results', 'form4_results.applicant_user_id', '=', 'applicants_users.id')
            ->join('applicants_choices', 'applicants_choices.applicant_user_id', '=', 'applicants_users.id')
            ->join('applicants_infos as ai', 'ai.applicant_user_id', '=', 'applicants_users.id')
            ->leftJoin('disabilities', 'ai.disability_id', '=', 'disabilities.id')
            ->leftJoin('regions_states as region_info', 'ai.region_id', '=', 'region_info.id')
            ->leftJoin('districts as district_info', 'ai.district_id', '=', 'district_info.id')
            ->leftJoin('nationalities', 'ai.nationality', '=', 'nationalities.id')
            ->leftJoin('nextof_kins as nk', 'nk.applicant_user_id', '=', 'applicants_users.id')
            ->leftJoin('countries', 'nk.country_id', '=', 'countries.id')
            ->leftJoin('regions_states as region_kin', 'nk.region_id', '=', 'region_kin.id')
            ->leftJoin('districts as district_kin', 'nk.district_id', '=', 'district_kin.id')
            ->leftJoin('relationships', 'nk.relationship_id', '=', 'relationships.id')
            ->where(function ($query) use ($programme_id) {
                $query->where('applicants_choices.choice1', '=', $programme_id)
                    ->orWhere('applicants_choices.choice2', '=', $programme_id)
                    ->orWhere('applicants_choices.choice3', '=', $programme_id);
            })
            ->where('applicants_choices.intake_id', '=', $intake->id)
            ->where('applicants_choices.window_id', '=', $window->id)
            ->where('applicants_choices.academic_year_id', '=', $academicYear->id)
            ->where('applicants_choices.status', 0) // Ensure status is 0
            ->whereIn('form4_results.grade', ['A', 'B+', 'B', 'C', 'D'])
            ->where('form4_results.status', 1) // Ensure status is 1
            ->whereIn('applicants_users.id', $selectedApplicantIds) // Filter by selected applicants' IDs
            ->select(
                'applicants_users.id as id',
                'ai.fname as fname',
                'ai.mname as mname',
                'ai.lname as lname',
                'ai.birth_date as dob',
                'disabilities.name as disability',
                'ai.gender as gender',
                'ai.physical_address as physical_address',
                'applicants_users.index_no as index_no',
                'applicants_users.mobile_no as mobile_no',
                'applicants_users.email as email',
                'ai.campus_id as campus',
                'region_info.name as region_info',
                'district_info.name as district_info',
                'countries.name as country_name',
                'region_kin.name as region_kin',
                'district_kin.name as district_kin',
                'nk.physical_address as next_keen_address',
                'nk.mobile_no as next_keen_mobile',
                'nk.email as next_keen_email',
                'relationships.name as relation',
                'nationalities.name as nation',

                DB::raw("CONCAT(nk.fname, ' ', COALESCE(nk.mname, ''), ' ', nk.lname) as next_of_kin_fullname"),
                DB::raw("CASE 
                WHEN applicants_choices.choice1 = $programme_id THEN applicants_choices.choice1 
                WHEN applicants_choices.choice2 = $programme_id THEN applicants_choices.choice2 
                WHEN applicants_choices.choice3 = $programme_id THEN applicants_choices.choice3 
                ELSE NULL 
            END as programme_id"),
                DB::raw('COUNT(CASE WHEN form4_results.status = 1 THEN 1 END) as status_count')
            )
            ->groupBy(
                'applicants_users.id',
                'applicants_users.index_no',
                'ai.fname',
                'ai.mname',
                'ai.lname',
                'ai.gender',
                'nk.fname',
                'nk.mname',
                'nk.lname',
                'applicants_choices.choice1',
                'applicants_choices.choice2',
                'applicants_choices.choice3',
                'ai.birth_date',
                'disabilities.name',
                'applicants_users.email',
                'applicants_users.mobile_no',
                'ai.physical_address',
                'ai.campus_id',
                'region_info.name',
                'district_info.name',
                'nationalities.name',
                'countries.name',
                'region_kin.name',
                'district_kin.name',
                'nk.physical_address',
                'nk.mobile_no',
                'nk.email',
                'relationships.name',
                'nationalities.name',
                'programme_id'

            )
            ->havingRaw('status_count >= 4')
            ->distinct()
            ->get();
        //  dd($selected);

        // Save the selected applicants to the "selected_applicants" table
        foreach ($selected as $applicant) {
            //check if applicant id exist
            $checkapplicants = SelectedDiplomaCertificate::where('applicant_user_id', $applicant->$applicant->id)
                ->where('index_no', $applicant->index_no)->first();
            if ($checkapplicants) {
                return redirect()->back()->withErrors("Applicant with Index No: {$applicant->index_no} is already registered under another programme.");
            }

            SelectedDiplomaCertificate::updateOrCreate(
                ['applicant_user_id' => $applicant->id], // Ensure no duplicate entries for the same applicant
                [
                    'index_no' => $applicant->index_no,
                    'first_name' => $applicant->fname,
                    'middle_name' => $applicant->mname,
                    'last_name' => $applicant->lname,
                    'gender' => $applicant->gender,
                    'dob' => $applicant->dob,
                    'disability' => $applicant->disability,
                    'email' => $applicant->email,
                    'mobile_no' => $applicant->mobile_no,
                    'physical_address' => $applicant->physical_address,
                    'campus_id' => $applicant->campus,
                    'region' => $applicant->region_info,
                    'district' => $applicant->district_info,
                    'nationality' => $applicant->nation,
                    'next_kin_name' => $applicant->next_of_kin_fullname,
                    'next_kin_address' => $applicant->next_keen_address,
                    'next_kin_email' => $applicant->next_keen_email,
                    'next_kin_phone' => $applicant->next_keen_mobile,
                    'next_kin_region' => $applicant->region_kin,
                    'next_kin_district' => $applicant->district_kin,
                    'next_kin_nationality' => $applicant->nation,
                    'next_kin_relationship' => $applicant->relation,
                    'iaa_programme_code' => $applicant->programme_id,
                    'application_year' => today()->year, // Laravel's today() helper
                    'intake' => $intake->id,
                    'window' => $window->id,
                    'status_count' => $applicant->status_count
                ]
            );
            // Update status in applicants_choices table to 1 for the selected applicant
            DB::table('applicants_choices')
                ->where('applicant_user_id', $applicant->id)
                ->update(['status' => 1]);
        }
        // Redirect back or to another page with a success message
        return redirect()->route('applicants-selection.index')->with('success', 'Selected applicants have been saved and status updated.');
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}

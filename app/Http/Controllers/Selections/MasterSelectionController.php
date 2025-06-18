<?php

namespace App\Http\Controllers\Selections;

use App\Models\Campus;
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
use App\Models\SelectedDiplomaCertificate;

class MasterSelectionController extends Controller
{
    //Arusha Campus
    public function arusha(Request $request)
    {
        // Fetch the application level for "Master"
        $level = ApplicationLevel::where('name', 'LIKE', '%master%')->first();

        if (!$level) {
            return redirect()->back()->withErrors('No application level found for Master.');
        }

        // Get the programme and category IDs related to the level
        $programme = Programme::where('application_level_id', $level->id)->get();

        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)
            ->where('active', 1)
            ->pluck('id')
            ->toArray();

        // Step 1: Get the active Academic Year, Intake, and Window
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();

        $window = ApplicationWindow::where([['application_level_id', $level->id], ['active', 1]])->first();

        // Step 2: Check if the required records exist
        if (!$academicYear || !$intake || !$window) {
            return redirect()->back()->withErrors('Academic Year, Intake, or Window not active.');
        }
        // Initialize variables
        $selectedApplicants = collect();
        $programme_id = null;

        // Step 4: Handle Programme ID filter
        if ($request->has('programme_id') && !empty($request->input('programme_id'))) {
            $programme_id = (int) $request->input('programme_id');
        }
        $arushaCampus = Campus::where('name', 'like', '%Arusha%')->pluck('id')->toArray();

        // Step 5: Fetch applicants
        $selectedApplicants = SelectedDiplomaCertificate::list(
            $programme_id,
            $intake->id,
            $window->id,
            $academicYear->id,
            $categoryIds
        )->whereIn('ai.campus_id', $arushaCampus)
            ->get();
        $totalMaster = $selectedApplicants->count();
        // Step 6: Pass data to the view
        return view('Admission.Applicants.selections.masters.index-master-arusha', compact('programme', 'selectedApplicants'));
    }
    public function storeArusha(Request $request)
    {
        // Step 1: Get the active Academic Year, Intake, and Window
        $programme_id = (int) $request->input('programme_id');
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();
        // Fetch the application level for "Master"
        $level = ApplicationLevel::where('name', 'LIKE', '%master%')->first();

        if (!$level) {
            return redirect()->back()->withErrors('No application level found for Master.');
        }
        $window = ApplicationWindow::where([['application_level_id', $level->id], ['active', 1]])->first();

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

        //$programme = Programme::where('application_level_id', $level->id)->get();
        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)->where('active', 1)->pluck('id')->toArray();

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
            )->whereIn('applicants_users.id', $selectedApplicantIds)->get();
        }

        // Step 6: Save the selected applicants to the "selected_applicants" table
        foreach ($selected as $applicant) {
            // Check if applicant id exists
            $checkapplicants = SelectedDiplomaCertificate::where('applicant_user_id', $selectedApplicantIds)
                ->where('index_no', $applicant->index_no)->first();

            if ($checkapplicants) {
                return redirect()->back()->with("error", "Applicant with Index No: {$applicant->index_no} is already registered under another programme.");
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
                    'qualification_no'=>$applicant->qualification_no,
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
            DB::table('applicants_choices')->where('applicant_user_id', $applicant->id)->update(['status' => 1]);
        }
        // Redirect back or to another page with a success message
        return redirect()->route('master.arusha')->with('success', 'Selected applicants have been saved and status updated.');
    }

    public function dar(Request $request)
    {
        // Fetch the application level for "Master"
        $level = ApplicationLevel::where('name', 'LIKE', '%master%')->first();

        if (!$level) {
            return redirect()->back()->withErrors('No application level found for Master.');
        }
        // Get the programme and category IDs related to the level
        $programme = Programme::where('application_level_id', $level->id)->get();
        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)->where('active', 1)->pluck('id')->toArray();

        // Step 1: Get the active Academic Year, Intake, and Window
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();
        $window = ApplicationWindow::where([['application_level_id', $level->id], ['active', 1]])->first();

        // Step 2: Check if the required records exist
        if (!$academicYear || !$intake || !$window) {
            return redirect()->back()->withErrors('Academic Year, Intake, or Window not active.');
        }
        // Initialize variables
        $selectedApplicants = collect();
        $programme_id = null;

        // Step 4: Handle Programme ID filter
        if ($request->has('programme_id') && !empty($request->input('programme_id'))) {
            $programme_id = (int) $request->input('programme_id');
        }
        $darCampus = Campus::where('name', 'like', '%Dar%')->pluck('id')->toArray();

        // Step 5: Fetch applicants
        $selectedApplicants = SelectedDiplomaCertificate::list(
            $programme_id,
            $intake->id,
            $window->id,
            $academicYear->id,
            $categoryIds
        )->whereIn('ai.campus_id', $darCampus)->get();
        $totalMaster = $selectedApplicants->count();
        //print_r($totalMaster);die();
        // Step 6: Pass data to the view
        return view('Admission.Applicants.selections.masters.index-master-dar', compact('programme', 'selectedApplicants'));
    }
    public function storeDar(Request $request)
    {
        // Step 1: Get the active Academic Year, Intake, and Window
        $programme_id = (int) $request->input('programme_id');
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();
        // Fetch the application level for "Master"
        $level = ApplicationLevel::where('name', 'LIKE', '%master%')->first();

        if (!$level) {
            return redirect()->back()->withErrors('No application level found for Master.');
        }
        $window = ApplicationWindow::where([['application_level_id', $level->id], ['active', 1]])->first();

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

        //$programme = Programme::where('application_level_id', $level->id)->get();
        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)->where('active', 1)->pluck('id')->toArray();

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
            )->whereIn('applicants_users.id', $selectedApplicantIds)->get();
        }

        // Step 6: Save the selected applicants to the "selected_applicants" table
        foreach ($selected as $applicant) {
            // Check if applicant id exists
            $checkapplicants = SelectedDiplomaCertificate::where('applicant_user_id', $selectedApplicantIds)->where('index_no', $applicant->index_no)->first();
            if ($checkapplicants) {
                return redirect()->back()->with("error", "Applicant with Index No: {$applicant->index_no} is already registered under another programme.");
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
            DB::table('applicants_choices')->where('applicant_user_id', $applicant->id)->update(['status' => 1]);
        }
        // Redirect back or to another page with a success message
        return redirect()->route('master.dar')->with('success', 'Selected applicants have been saved and status updated.');
    }
    public function babati(Request $request)
    {
        // Fetch the application level for "Master"
        $level = ApplicationLevel::where('name', 'LIKE', '%master%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found for Master.');
        }

        // Get the programme and category IDs related to the level
        $programme = Programme::where('application_level_id', $level->id)->get();
        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)->where('active', 1)->pluck('id')->toArray();
        // Step 1: Get the active Academic Year, Intake, and Window
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();

        $window = ApplicationWindow::where([['application_level_id', $level->id], ['active', 1]])->first();

        // Step 2: Check if the required records exist
        if (!$academicYear || !$intake || !$window) {
            return redirect()->back()->withErrors('Academic Year, Intake, or Window not active.');
        }
        // Initialize variables
        $selectedApplicants = collect();
        $programme_id = null;

        // Step 4: Handle Programme ID filter
        if ($request->has('programme_id') && !empty($request->input('programme_id'))) {
            $programme_id = (int) $request->input('programme_id');
        }
        $babatiCampus = Campus::where('name', 'like', '%babati%')->pluck('id')->toArray();

        // Step 5: Fetch applicants
        $selectedApplicants = SelectedDiplomaCertificate::list(
            $programme_id,
            $intake->id,
            $window->id,
            $academicYear->id,
            $categoryIds
        )->whereIn('ai.campus_id', $babatiCampus)->get();
        $totalMaster = $selectedApplicants->count();
        //print_r($totalMaster);die();
        // Step 6: Pass data to the view
        return view('Admission.Applicants.selections.masters.index-master-babati', compact('programme', 'selectedApplicants'));
    }

    //Babati campus
    public function storeBabati(Request $request)
    {
        // Step 1: Get the active Academic Year, Intake, and Window
        $programme_id = (int) $request->input('programme_id');
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();
        // Fetch the application level for "Master"
        $level = ApplicationLevel::where('name', 'LIKE', '%master%')->first();

        if (!$level) {
            return redirect()->back()->withErrors('No application level found for Master.');
        }
        $window = ApplicationWindow::where([['application_level_id', $level->id], ['active', 1]])->first();

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

        //$programme = Programme::where('application_level_id', $level->id)->get();
        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)->where('active', 1)->pluck('id')->toArray();

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
            )->whereIn('applicants_users.id', $selectedApplicantIds)->get();
        }

        // Step 6: Save the selected applicants to the "selected_applicants" table
        foreach ($selected as $applicant) {
            // Check if applicant id exists
            $checkapplicants = SelectedDiplomaCertificate::where('applicant_user_id', $selectedApplicantIds)
                ->where('index_no', $applicant->index_no)->first();

            if ($checkapplicants) {
                return redirect()->back()->with("error", "Applicant with Index No: {$applicant->index_no} is already registered under another programme.");
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
            DB::table('applicants_choices')->where('applicant_user_id', $applicant->id)->update(['status' => 1]);
        }
        // Redirect back or to another page with a success message
        return redirect()->route('master.babati')->with('success', 'Selected applicants have been saved and status updated.');
    }
    public function dodoma(Request $request)
    {
        // Fetch the application level for "Master"
        $level = ApplicationLevel::where('name', 'LIKE', '%master%')->first();

        if (!$level) {
            return redirect()->back()->withErrors('No application level found for Master.');
        }

        // Get the programme and category IDs related to the level
        $programme = Programme::where('application_level_id', $level->id)->get();

        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)->where('active', 1)->pluck('id')->toArray();
        // Step 1: Get the active Academic Year, Intake, and Window
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();

        $window = ApplicationWindow::where([['application_level_id', $level->id], ['active', 1]])->first();

        // Step 2: Check if the required records exist
        if (!$academicYear || !$intake || !$window) {
            return redirect()->back()->withErrors('Academic Year, Intake, or Window not active.');
        }
        // Initialize variables
        $selectedApplicants = collect();
        $programme_id = null;

        // Step 4: Handle Programme ID filter
        if ($request->has('programme_id') && !empty($request->input('programme_id'))) {
            $programme_id = (int) $request->input('programme_id');
        }
        $dodomaCampus = Campus::where('name', 'like', '%dodoma%')->pluck('id')->toArray();
        // Step 5: Fetch applicants
        $selectedApplicants = SelectedDiplomaCertificate::list(
            $programme_id,
            $intake->id,
            $window->id,
            $academicYear->id,
            $categoryIds
        )->whereIn('ai.campus_id', $dodomaCampus)->get();
        $totalMaster = $selectedApplicants->count();
        //print_r($totalMaster);die();
        // Step 6: Pass data to the view
        return view('Admission.Applicants.selections.masters.index-master-dodoma', compact('programme', 'selectedApplicants'));
    }
    public function storeDodoma(Request $request)
    {
        // Step 1: Get the active Academic Year, Intake, and Window
        $programme_id = (int) $request->input('programme_id');
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();
        // Fetch the application level for "Master"
        $level = ApplicationLevel::where('name', 'LIKE', '%master%')->first();

        if (!$level) {
            return redirect()->back()->withErrors('No application level found for Master.');
        }
        $window = ApplicationWindow::where([['application_level_id', $level->id], ['active', 1]])->first();

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

        //$programme = Programme::where('application_level_id', $level->id)->get();
        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)->where('active', 1)->pluck('id')->toArray();

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
            )->whereIn('applicants_users.id', $selectedApplicantIds)
                ->get();
        }

        // Step 6: Save the selected applicants to the "selected_applicants" table
        foreach ($selected as $applicant) {
            // Check if applicant id exists
            $checkapplicants = SelectedDiplomaCertificate::where('applicant_user_id', $selectedApplicantIds)
                ->where('index_no', $applicant->index_no)->first();

            if ($checkapplicants) {
                return redirect()->back()->with("error", "Applicant with Index No: {$applicant->index_no} is already registered under another programme.");
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
            DB::table('applicants_choices')->where('applicant_user_id', $applicant->id)->update(['status' => 1]);
        }
        // Redirect back or to another page with a success message
        return redirect()->route('master.dodoma')->with('success', 'Selected applicants have been saved and status updated.');
    }
    public function songea(Request $request)
    {
        // Fetch the application level for "Master"
        $level = ApplicationLevel::where('name', 'LIKE', '%master%')->first();

        if (!$level) {
            return redirect()->back()->withErrors('No application level found for Master.');
        }

        // Get the programme and category IDs related to the level
        $programme = Programme::where('application_level_id', $level->id)->get();

        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)->where('active', 1)->pluck('id')->toArray();

        // Step 1: Get the active Academic Year, Intake, and Window
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();

        $window = ApplicationWindow::where([['application_level_id', $level->id], ['active', 1]])->first();

        // Step 2: Check if the required records exist
        if (!$academicYear || !$intake || !$window) {
            return redirect()->back()->withErrors('Academic Year, Intake, or Window not active.');
        }
        // Initialize variables
        $selectedApplicants = collect();
        $programme_id = null;

        // Step 4: Handle Programme ID filter
        if ($request->has('programme_id') && !empty($request->input('programme_id'))) {
            $programme_id = (int) $request->input('programme_id');
        }
        $songeaCampus = Campus::where('name', 'like', '%songea%')->pluck('id')->toArray();

        // Step 5: Fetch applicants
        $selectedApplicants = SelectedDiplomaCertificate::list(
            $programme_id,
            $intake->id,
            $window->id,
            $academicYear->id,
            $categoryIds
        )->whereIn('ai.campus_id', $songeaCampus)->get();
        $totalMaster = $selectedApplicants->count();
        //print_r($totalMaster);die();
        // Step 6: Pass data to the view
        return view('Admission.Applicants.selections.masters.index-master-songea', compact('programme', 'selectedApplicants'));
    }
    public function storeSongea(Request $request)
    {
        // Step 1: Get the active Academic Year, Intake, and Window
        $programme_id = (int) $request->input('programme_id');
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();
        // Fetch the application level for "Master"
        $level = ApplicationLevel::where('name', 'LIKE', '%master%')->first();

        if (!$level) {
            return redirect()->back()->withErrors('No application level found for Master.');
        }
        $window = ApplicationWindow::where([['application_level_id', $level->id], ['active', 1]])->first();

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

        //$programme = Programme::where('application_level_id', $level->id)->get();
        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)->where('active', 1)->pluck('id')->toArray();

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
            )->whereIn('applicants_users.id', $selectedApplicantIds)->get();
        }

        // Step 6: Save the selected applicants to the "selected_applicants" table
        foreach ($selected as $applicant) {
            // Check if applicant id exists
            $checkapplicants = SelectedDiplomaCertificate::where('applicant_user_id', $selectedApplicantIds)
                ->where('index_no', $applicant->index_no)->first();

            if ($checkapplicants) {
                return redirect()->back()->with("error", "Applicant with Index No: {$applicant->index_no} is already registered under another programme.");
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
            DB::table('applicants_choices')->where('applicant_user_id', $applicant->id)->update(['status' => 1]);
        }
        // Redirect back or to another page with a success message
        return redirect()->route('master.songea')->with('success', 'Selected applicants have been saved and status updated.');
    }
}

<?php

namespace App\Http\Controllers\selections;

use App\Models\Intake;
use App\Models\Programme;
use App\Models\Form4Result;
use App\Models\Form6Result;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\ApplicantsInfo;
use App\Models\ApplicantsUser;
use App\Models\EducationLevel;
use App\Models\ApplicantsChoice;
use App\Models\ApplicationLevel;
use App\Models\ApplicationWindow;
use Illuminate\Support\Facades\DB;
use App\Models\ApplicationCategory;
use App\Models\BachelorRequirement;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use PhpParser\Node\VarLikeIdentifier;
use App\Models\SelectedDiplomaCertificate;

class BachelorSelectionsController extends Controller
{
    public function formSix(Request $request)
    {
        // Find the 'bachelor' level
        $level = ApplicationLevel::where('name', 'LIKE', '%bachelor%')->first();

        if (!$level) {
            return redirect()->back()->with('error', 'Bachelor level not found.');
        }

        $programme = Programme::where('application_level_id', $level->id)->get();
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();
        $window = ApplicationWindow::where('active', 1)->first();

        $allSelected = [];  // Array to store selected applicants' data
        $allTotalPoints = [];
        // Get the programme ID from the request
        $programme_id = (int) $request->input('programme_id');

        // Get the education level related to Form 6
        $educationlevel = EducationLevel::where('name', 'LIKE', '%Form six%')->first();

        if (!$educationlevel) {
            return redirect()->back()->with('error', 'Education level not found.');
        }
        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)
            ->where('active', 1)
            ->pluck('id')->toArray();
        // Fetch bachelor requirements for the given programme and education level
        $requirement = BachelorRequirement::where('programme_id', $programme_id)
            ->where('education_level_id', $educationlevel->id)
            ->first();

        // Get all applicants with the given programme ID in their choice1, choice2, or choice3
        $allapp = ApplicantsChoice::whereIn('choice1', [$programme_id])
            ->orWhereIn('choice2', [$programme_id])
            ->orWhereIn('choice3', [$programme_id])
            ->pluck('applicant_user_id')->toArray();

        Log::info('Applicants in programme: ' . json_encode($allapp));

        // Loop through each applicant to process their data
        foreach ($allapp as $applicantId) {
            // Retrieve Form 6 results for the applicant
            $excludedSubjects = ['Basic Applied Mathematics', 'General Studies', 'Islamic Studies', 'Biblical Knowledge'];
            $result6 = Form6Result::where('applicant_user_id', $applicantId)
                ->whereNotIn('subject_name', $excludedSubjects) // Exclude subjects
                ->pluck('subject_name');

            Log::info("Result6 for applicant $applicantId: " . json_encode($result6));

            if ($result6->isEmpty()) {
                return redirect()->back()->with('error', "No Form 6 results found for applicant $applicantId.");
            }

            // Fetch bachelor requirements for the given programme and education level
            $subject_courses = $requirement->pluck('subject_course')->filter()->map(function ($item) {
                return strtoupper($item); // Convert to uppercase
            })->toArray();

            $result6 = collect($result6)->map(function ($item) {
                return strtoupper($item); // Convert to uppercase
            })->toArray();

            $intersectingSubjects = array_intersect($subject_courses, $result6);
            Log::info("Intersecting subjects for applicant $applicantId: " . json_encode($intersectingSubjects));

            if (count($intersectingSubjects) <= 2) {
                return redirect()->back()->with('error', "Applicant $applicantId does not meet the subject requirements.");
            }

            // Define grade points
            $gradePoints = [
                'A' => 5,
                'B' => 4,
                'C' => 3,
                'D' => 2,
                'E' => 1,
                'S' => 0.5,
                'F' => 0
            ];

            // Fetch all grades for the intersecting subjects
            $subjectGrades = Form6Result::where('applicant_user_id', $applicantId)
                ->whereIn('subject_name', $intersectingSubjects)
                ->get(['subject_name', 'grade']); // Get grades for intersecting subjects

            // Group the grades by subject_name
            $groupedGrades = $subjectGrades->groupBy('subject_name');

            // Map through the groups and get the highest grade for each subject
            $highestGrades = $groupedGrades->map(function ($grades, $subjectName) use ($gradePoints) {
                // Sort grades based on grade points and take the highest grade
                $highestGrade = $grades->sortByDesc(function ($grade) use ($gradePoints) {
                    return $gradePoints[$grade->grade] ?? 0;
                })->first();

                return [
                    'subject' => $subjectName,
                    'grade' => $highestGrade->grade,
                    'points' => $gradePoints[$highestGrade->grade] ?? 0
                ];
            });

            // Log the highest grades for each subject
            Log::info("Highest grades for applicant $applicantId: " . json_encode($highestGrades));

            // Sort the subjects by points in descending order
            $sortedGrades = $highestGrades->sortByDesc('points');

            // Get the top two subjects with the highest points
            $topTwoGrades = $sortedGrades->take(2);

            // Log the top two grades
            Log::info("Top two subjects for applicant $applicantId: " . json_encode($topTwoGrades));

            // Calculate the total points for the top two subjects
            $totalPoints = $topTwoGrades->sum('points');

            // Log the total points
            Log::info("Total points for applicant $applicantId (Top 2 subjects): $totalPoints");

            // Get the minimum required points from BachelorRequirement
            $minPoints = BachelorRequirement::where('programme_id', $programme_id)
                ->where('education_level_id', $educationlevel->id)
                ->value('min_advance_aggregate_points');

            Log::info("Minimum required points: $minPoints");

            // Compare total points with the required minimum
            if ($totalPoints < $minPoints) {
                return redirect()->back()->with('error', "Applicant $applicantId does not meet the minimum required points.");
            }

            // Check if Mathematics is required
            if ($requirement->math) {
                // Fetch Advanced Mathematics grade from Form 6 for the applicant
                $advancedMathGrade = Form6Result::where('applicant_user_id', $applicantId)
                    ->where('subject_name', 'LIKE', '%Advanced Mathematics%')
                    ->pluck('grade')->first(); // Fetch grade for Advanced Math

                // Fetch Basic Mathematics grade from Form 4 for the applicant
                $basicMathGrade = Form4Result::where('applicant_user_id', $applicantId)
                    ->where('subject_name', 'LIKE', '%Basic Mathematics%')
                    ->pluck('grade')->first(); // Fetch grade for Basic Math

                Log::info("Advanced Math Grade for applicant $applicantId: " . $advancedMathGrade);
                Log::info("Basic Math Grade for applicant $applicantId: " . $basicMathGrade);

                // Convert grades to points
                $advancedMathPoints = isset($advancedMathGrade) ? ($gradePoints[$advancedMathGrade] ?? 0) : null;
                $basicMathPoints = isset($basicMathGrade) ? ($gradePoints[$basicMathGrade] ?? 0) : null;

                // Check if the applicant meets the Mathematics requirement
                $meetsMathRequirement = false;

                // If Advanced Mathematics grade is available
                if ($advancedMathPoints !== null && $advancedMathPoints >= 0.5) {
                    // Applicant meets the requirement with Advanced Mathematics
                    $meetsMathRequirement = true;
                }
                // If Advanced Mathematics grade is not available, check Basic Mathematics and Total Points
                elseif ($basicMathPoints !== null && $basicMathPoints >= 2) {
                    // Applicant meets requirement with Basic Mathematics if they have a grade D or higher (points >= 2)
                    if ($totalPoints >= 4) {
                        $meetsMathRequirement = true;
                    }
                }

                // If applicant does not meet the requirement
                if (!$meetsMathRequirement) {
                    return redirect()->back()->with('error', "Applicant $applicantId does not meet the Mathematics requirement.");
                }
            }
            $selected = SelectedDiplomaCertificate::list(
                $programme_id,       // Pass just the programme ID (not the full model)
                $intake->id,         // Pass the intake ID
                $window->id,         // Pass the window ID
                $academicYear->id,   // Pass the academic year ID
                $categoryIds         // Pass the category IDs
            )->where('applicants_users.id', $applicantId)->distinct() // Use whereIn to match multiple IDs
                ->get();
            Log::info($selected);
            $allSelected[] = $selected;
        }
        //print_r($allTotalPoints);die();
        return view('admission.applicants.selections.bachelors.index-six', compact('programme', 'allSelected'));
    }
    public function storeSix(Request $request)
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
        $level = ApplicationLevel::where('name', 'LIKE', '%bachelor%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }

        // Get the programme and category IDs related to the level
        //$programme = Programme::where('application_level_id', $level->id)->get();
        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)
            ->where('active', 1)
            ->pluck('id')->toArray();

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
                    'qualification_no'=>$applicant->qualification_no,
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
}

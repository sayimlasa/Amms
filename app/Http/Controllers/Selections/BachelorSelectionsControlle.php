<?php

namespace App\Http\Controllers\Selections;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ApplicantsAcademic;
use App\Models\ApplicantsChoice;
use App\Models\ApplicantsInfo;
use App\Models\ApplicationCategory;
use App\Models\ApplicationLevel;
use App\Models\ApplicationWindow;
use App\Models\BachelorRequirement;
use App\Models\BachelorSelection;
use App\Models\EducationLevel;
use App\Models\Form6Result;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BachelorSelectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function diplomaIndex(Request $request)
    {
        $applicationLevels = ApplicationLevel::where('name', 'LIKE', '%Bachelor%')->pluck('id');
        $programmes        = Programme::whereIn('application_level_id', $applicationLevels)->get();

        $programme_id         = $request->input('programme_id', null);
        $application_level_id = $request->input('application_level_id', null);
        $capacity             = $request->input('capacity', null); // Get capacity from request

        $diplomacategory = ApplicationCategory::where('name', 'LIKE', '%diploma%')
            ->where('application_level_id', $application_level_id)
            ->pluck('id');
        //print_r($diplomacategory);die();
        $diplomalists = $diplomacategory->isNotEmpty()
            ? collect($this->getdiplomalist($diplomacategory[0], $programme_id))
            : collect([]);

        return view('Selection.Bachelor.diplomaindex', compact('programmes', 'applicationLevels'));
    }

    protected function getdiplomalist($category_id, $programme_id)
    {
        $academic_year_id  = AcademicYear::where('active', 1)->value('id');
        $applicationLevels = ApplicationLevel::where('name', 'LIKE', '%Bachelor%')->pluck('id');
        $window_id         = ApplicationWindow::where('application_level_id', $applicationLevels)->where('active', 1)->value('id');
        $intake_id         = ApplicationWindow::where('application_level_id', $applicationLevels)->where('active', 1)->value('intake_id');
        $education_level   = EducationLevel::where('name', 'LIKE', '%diploma%')->value('id');

        $applicants = ApplicantsInfo::where('application_category_id', $category_id)
            ->where('acadmic_year_id', $academic_year_id)
            ->where('intake_id', $intake_id)
            ->get();

        Log::info($applicants);

        $applicant_user_ids = $applicants->pluck('applicant_user_id');

        $courses = ApplicantsAcademic::whereIn('applicant_user_id', $applicant_user_ids)
            ->where('education_level', $education_level)
            ->pluck('course', 'applicant_user_id');

        // Get choices matching the programme_id
        $choices = ApplicantsChoice::whereIn('applicant_user_id', $applicant_user_ids)
            ->where('academic_year_id', $academic_year_id)
            ->where('intake_id', $intake_id)
            ->where('window_id', $window_id)
            ->where('status', 0)
            ->get()
            ->filter(function ($choice) use ($programme_id) {
                return in_array($programme_id, [$choice->choice1, $choice->choice2, $choice->choice3]);
            });

        // Ensure only applicants with a valid choice are included
        $validApplicants = $applicants->filter(function ($applicant) use ($choices) {
            return $choices->contains(function ($choice) use ($applicant) {
                return in_array($applicant->applicant_user_id, [$choice->applicant_user_id]);
            });
        });

        if ($validApplicants->isEmpty()) {
            return collect();
        }

        $bachelorRequirements = BachelorRequirement::where('programme_id', $programme_id)
            ->where('education_level_id', $education_level)
            ->pluck('subject_course');

        // Filter applicants based on course comparison
        $qualifiedApplicants = $validApplicants->filter(function ($applicant) use ($courses, $bachelorRequirements) {
            $course_name = strtolower($courses[$applicant->applicant_user_id] ?? '');
            return $bachelorRequirements->contains(function ($subject_course) use ($course_name) {
                return str_contains(strtolower($course_name), strtolower($subject_course));
            });
        });

        // return ApplicantsInfo::whereIn('applicant_user_id', $qualifiedApplicants->pluck('applicant_user_id'))
        //     ->with('applicantUser')
        //     ->get()
        //     ->map(function ($applicant) use ($choices, $education_level, $programme_id) {
        //         // Get the first matching choice for the applicant
        //         $selectedChoice = $choices->firstWhere('applicant_user_id', $applicant->applicant_user_id);
        //         $applicant->programme_id = $programme_id ?? null;
        //         $applicant->education_level = $education_level;
        //         return $applicant;
        //     });
        $info = ApplicantsInfo::whereIn('applicant_user_id', $qualifiedApplicants->pluck('applicant_user_id'))
            ->with('applicantUser')
            ->get()
            ->map(function ($applicant) use ($choices, $education_level, $programme_id) {
                // Get the first matching choice for the applicant
                $selectedChoice             = $choices->firstWhere('applicant_user_id', $applicant->applicant_user_id);
                $applicant->programme_id    = $programme_id ?? null;
                $applicant->education_level = $education_level;
                return $applicant;
            });

        Log::info($info);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function sixIndex(Request $request)
    {
        $applicationLevels = ApplicationLevel::where('name', 'LIKE', '%bachelor%')->pluck('id');
        $programmes        = Programme::whereIn('application_level_id', $applicationLevels)->get();

        $programme_id         = $request->input('programme_id', null);
        $application_level_id = $request->input('application_level_id', null);
        $capacity             = $request->input('capacity', null); // Get capacity from request

        $diplomacategory = ApplicationCategory::where('name', 'LIKE', '%six%')
            ->where('application_level_id', $application_level_id)
            ->pluck('id');

        $formsixlists = $diplomacategory->isNotEmpty()
            ? collect($this->formSixIndex($diplomacategory[0], $programme_id))
            : collect([]);

        return view('Selection.Bachelor.formsixindex', compact('programmes', 'applicationLevels', 'formsixlists'));
    }
    public function formSixIndex($category_id, $programme_id)
    {
        $academic_year_id  = AcademicYear::where('active', 1)->value('id');
        $applicationLevels = ApplicationLevel::where('name', 'LIKE', '%bachelor%')->pluck('id');
        $window_id         = ApplicationWindow::where('application_level_id', $applicationLevels)->where('active', 1)->value('id');
        $intake_id         = ApplicationWindow::where('application_level_id', $applicationLevels)->where('active', 1)->value('intake_id');
        $education_level   = EducationLevel::where('name', 'LIKE', '%six%')->value('id');

        $applicants = ApplicantsInfo::where('application_category_id', $category_id)
            ->where('acadmic_year_id', $academic_year_id)
            ->where('intake_id', $intake_id)
            ->get();

        $applicant_user_ids = $applicants->pluck('applicant_user_id');

        // Get choices matching the programme_id
        $choices = ApplicantsChoice::whereIn('applicant_user_id', $applicant_user_ids)
            ->where('academic_year_id', $academic_year_id)
            ->where('intake_id', $intake_id)
            ->where('window_id', $window_id)
            ->where('status', 0) // Ensure status matches the valid ones
            ->get()
            ->filter(function ($choice) use ($programme_id) {
                return in_array($programme_id, [$choice->choice1, $choice->choice2, $choice->choice3]);
            });

        // Ensure only applicants with a valid choice are included
        $validApplicants = $applicants->filter(function ($applicant) use ($choices) {
            return $choices->contains(function ($choice) use ($applicant) {
                return in_array($applicant->applicant_user_id, [$choice->applicant_user_id]);
            });
        });

        $bachelorRequirements = BachelorRequirement::where('programme_id', $programme_id)
            ->where('education_level_id', $education_level)
            ->get([
                'subject_course',
                'min_foundation_gpa',
                'min_advance_principle_pass',
                'min_advance_aggregate_points',
                'math',
            ]);

        // Extract unique values for the non-null row
        $singleRow = $bachelorRequirements->whereNotNull('min_foundation_gpa')->first();

        // Merge subject_course values into an array
        $subjectCourses = $bachelorRequirements->pluck('subject_course')->filter()->toArray();

        // Final structured data
        $formattedRequirements = [
            'subject_courses'              => $subjectCourses, // Array of subject courses
            'min_foundation_gpa'           => $singleRow->min_foundation_gpa ?? null,
            'min_advance_principle_pass'   => $singleRow->min_advance_principle_pass ?? null,
            'min_advance_aggregate_points' => $singleRow->min_advance_aggregate_points ?? null,
            'math'                         => $singleRow->math ?? null,
        ];

        $gradeValues = [
            'A' => 5,
            'B' => 4,
            'C' => 3,
            'D' => 2,
            'E' => 1,
        ];

        // Fetch subjects and add grade values
        $subjects = Form6Result::whereIn('applicant_user_id', $applicant_user_ids)
            ->where('status', 1)
            ->whereRaw("subject_name NOT REGEXP 'islamic|bible|christian|basic applied|general studies'")
            ->get()
            ->map(function ($subject) use ($gradeValues) {
                $subject->grade_value = $gradeValues[$subject->grade] ?? 0; // Default to 0 if grade not found
                return $subject;
            });

        Log::info('All Subjects:', $subjects->toArray());
        Log::info('Formatted Requirements:', $formattedRequirements);

        // Step 1: Filter subjects that match required courses
        $matchingSubjects = $subjects->filter(function ($subject) use ($formattedRequirements) {
            foreach ($formattedRequirements['subject_courses'] as $requiredCourse) {
                if (stripos($subject->subject_name, $requiredCourse) !== false) {
                    return true;
                }
            }
            return false;
        });

        Log::info('Matching Subjects:', $matchingSubjects->toArray());

        // Step 2: Count matched subjects and check min_advance_principle_pass
        $matchedCount = $matchingSubjects->count();
        $minAdvancePrinciplePass = $formattedRequirements['min_advance_principle_pass'] ?? 0;

        Log::info("Matched Subjects Count: $matchedCount");
        Log::info("Required Min Advance Principle Pass: $minAdvancePrinciplePass");

        if ($matchedCount < $minAdvancePrinciplePass) {
            Log::warning("Not enough matching subjects. Required: $minAdvancePrinciplePass, Found: $matchedCount");
        }

        // Step 3: Calculate total grade value and compare with min_advance_aggregate_points
        $totalGradeValue = $matchingSubjects->sum(function ($subject) {
            return $subject->grade_value;
        });

        $minAdvanceAggregatePoints = $formattedRequirements['min_advance_aggregate_points'] ?? 0;

        Log::info("Total Grade Value: $totalGradeValue");
        Log::info("Required Min Advance Aggregate Points: $minAdvanceAggregatePoints");

        if ($totalGradeValue < $minAdvanceAggregatePoints) {
            Log::warning("Total grade value is too low. Required: $minAdvanceAggregatePoints, Found: $totalGradeValue");
        }

        // Log final decision
        if ($matchedCount >= $minAdvancePrinciplePass && $totalGradeValue >= $minAdvanceAggregatePoints) {
            Log::info("Requirements met successfully!");
        } else {
            Log::warning("Requirements NOT met.");
        }

        if ($validApplicants->isEmpty()) {
            return collect();
        }

        return ApplicantsInfo::whereIn('applicant_user_id', $validApplicants->pluck('applicant_user_id'))
            ->with('applicantUser')
            ->get()
            ->map(function ($applicant) use ($choices, $education_level, $programme_id) {
                // Get the first matching choice for the applicant
                $selectedChoice             = $choices->firstWhere('applicant_user_id', $applicant->applicant_user_id);
                $applicant->programme_id    = $programme_id ?? null;
                $applicant->education_level = $education_level;
                return $applicant;
            });
    }

    /**
     * Store a newly created resource in storage.
     
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BachelorSelection  $bachelorSelection
     * @return \Illuminate\Http\Response
     */
    public function show(BachelorSelection $bachelorSelection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BachelorSelection  $bachelorSelection
     * @return \Illuminate\Http\Response
     */
    public function edit(BachelorSelection $bachelorSelection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BachelorSelection  $bachelorSelection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BachelorSelection $bachelorSelection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BachelorSelection  $bachelorSelection
     * @return \Illuminate\Http\Response
     */
    public function destroy(BachelorSelection $bachelorSelection)
    {
        //
    }
}

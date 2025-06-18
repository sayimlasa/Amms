<?php

namespace App\Http\Controllers\Selections;

use App\Models\Intake;
use App\Models\Programme;
use App\Models\Form4Result;
use App\Models\Form6Result;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\ApplicantsInfo;
use App\Models\EducationLevel;
use App\Models\ApplicantsChoice;
use App\Models\ApplicationLevel;
use App\Models\ApplicationWindow;
use App\Models\BachelorSelection;
use App\Models\ApplicantsAcademic;
use Illuminate\Support\Facades\DB;
use App\Models\ApplicationCategory;
use App\Models\BachelorRequirement;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\SelectedDiplomaCertificate;

class BachelorSelectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function diplomaIndex(Request $request)
    {
        $applicationLevels = ApplicationLevel::where('name', 'LIKE', '%bachelor%')->pluck('id');
        $programmes        = Programme::whereIn('application_level_id', $applicationLevels)->get();

        $programme_id         = $request->input('programme_id', null);
        $application_level_id = $request->input('application_level_id', null);
        $capacity             = $request->input('capacity', null); // Get capacity from request

        $diplomacategory = ApplicationCategory::where('name', 'LIKE', '%diploma%')
            ->where('application_level_id', $application_level_id)
            ->pluck('id');

        // Log::info($diplomacategory);
        $diplomalists = $diplomacategory->isNotEmpty()
            ? collect($this->getdiplomalist($diplomacategory, $programme_id))
            : collect([]);
        Log::info($diplomalists);
        return view('Selection.Bachelor.diplomaindex', compact('programmes', 'applicationLevels', 'diplomalists'));
    }

    protected function getdiplomalist($category_id, $programme_id)
    {

        $category_ids = $category_id->toArray();
        // Log::info('Category ID Type After Conversion:', ['type' => gettype($category_ids)]);
        // Log::info('Category ID Value After Conversion:', $category_ids);
        $academic_year_id  = AcademicYear::where('active', 1)->value('id');
        $applicationLevels = ApplicationLevel::where('name', 'LIKE', '%bachelor%')->pluck('id');
        $window_id         = ApplicationWindow::where('application_level_id', $applicationLevels)->where('active', 1)->value('id');
        $intake_id         = ApplicationWindow::where('application_level_id', $applicationLevels)->where('active', 1)->value('intake_id');
        $education_level   = EducationLevel::where('name', 'LIKE', '%diploma%')->value('id');

        $query = ApplicantsInfo::whereIn('application_category_id', $category_ids)
            ->where('acadmic_year_id', $academic_year_id)
            ->where('intake_id', $intake_id);

        // Log the raw SQL query and bindings
        // Log::info('SQL Query: ' . $query->toSql(), $query->getBindings());

        // Execute the query to get the results
        $applicants = $query->get();

        // Log the applicants data
        // Log::info('Applicants Data: ', $applicants->toArray());


        $applicant_user_ids = $applicants->pluck('applicant_user_id');

        $courses = ApplicantsAcademic::whereIn('applicant_user_id', $applicant_user_ids)
            ->where('education_level', $education_level)
            ->whereRaw('CAST(gpa_divission AS DECIMAL) >= ?', [3])
            ->pluck('course', 'applicant_user_id');

        $coursesWithUserIds = $courses->map(function ($course, $userId) {
            return ['applicant_user_id' => $userId, 'course' => $course];
        });

        // Log::info('courses with user IDs', $coursesWithUserIds->toArray());

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
        // Log::info('choices',$choices->toArray());
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
            ->whereNotNull('subject_course')
            ->pluck('subject_course');

        $qualifiedApplicants = $validApplicants->filter(function ($applicant) use ($courses, $bachelorRequirements) {
            $course_words = explode(' ', strtolower($courses[$applicant->applicant_user_id] ?? '')); // Split course name into words

            return $bachelorRequirements->contains(function ($subject_course) use ($course_words) {
                $subject_words = explode(' ', strtolower($subject_course)); // Split subject course into words
                $match_count = count(array_intersect($course_words, $subject_words)); // Count common words

                return $match_count >= 2; // Require at least 2 matching words
            });
        });

        Log::info('qualified', $qualifiedApplicants->toArray());

        return ApplicantsInfo::whereIn('applicant_user_id', $qualifiedApplicants->pluck('applicant_user_id'))
            ->with('applicantUser')
            ->get()
            ->map(function ($applicant) use ($choices, $education_level, $programme_id) {
                // Get the first matching choice for the applicant
                $selectedChoice = $choices->firstWhere('applicant_user_id', $applicant->applicant_user_id);
                $applicant->programme_id = $programme_id ?? null;
                $applicant->education_level = $education_level;
                return $applicant;
            });
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

        $formsixcategory = ApplicationCategory::where('name', 'LIKE', '%six%')
            ->where('application_level_id', $application_level_id)
            ->pluck('id');

        $formsixlists = $formsixcategory->isNotEmpty()
            ? collect($this->getformSixList($formsixcategory, $programme_id))
            : collect([]);

        return view('Selection.Bachelor.formsixindex', compact('programmes', 'applicationLevels', 'formsixlists'));
    }


    public function getformSixList($category_id, $programme_id)
    {
        $category_ids = $category_id->toArray();
        $academic_year_id  = AcademicYear::where('active', 1)->value('id');
        $applicationLevels = ApplicationLevel::where('name', 'LIKE', '%bachelor%')->pluck('id');
        $window_id         = ApplicationWindow::where('application_level_id', $applicationLevels)->where('active', 1)->value('id');
        $intake_id         = ApplicationWindow::where('application_level_id', $applicationLevels)->where('active', 1)->value('intake_id');
        $education_level   = EducationLevel::where('name', 'LIKE', '%six%')->value('id');

        $query = ApplicantsInfo::whereIn('application_category_id', $category_ids)
            ->where('acadmic_year_id', $academic_year_id)
            ->where('intake_id', $intake_id);

        // Log the raw SQL query and bindings
        // Log::info('SQL Query: ' . $query->toSql(), $query->getBindings());

        // Execute the query to get the results
        $applicants = $query->get();

        // Log the applicants data
        // Log::info('Applicants Data: ', $applicants->toArray());


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
            'subject_courses'              => $subjectCourses ?? null, // Array of subject courses
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
            ->whereRaw("subject_name NOT REGEXP 'islamic|bible|christian|basic applied|general studies'") // Exclude unwanted subjects
            // ->where('grade', '!=', 'S')  // Exclude grade 'S'
            ->get()
            ->map(function ($subject) use ($gradeValues) {
                $subject->grade_value = $gradeValues[$subject->grade] ?? 0; // Default to 0 if grade not found
                return $subject;
            });

        // Check if math = 1
        if ($formattedRequirements['math'] == 1) {
            // Check if "Advanced Mathematics" is among the subjects
            $advancedMathFound = $subjects->contains(function ($subject) {
                return stripos($subject->subject_name, 'Advanced Mathematics') !== false;
            });

            if ($advancedMathFound) {
                // Log::info('Qualified: Advanced Mathematics found');
            } else {
                // Log::warning('Not Qualified: Advanced Mathematics not found');

                // If "Advanced Mathematics" is not found, check Form4Result for "Mathematics"
                $form4Subjects = Form4Result::whereIn('applicant_user_id', $applicant_user_ids)
                    ->where('status', 1)
                    ->whereRaw("subject_name LIKE '%Mathematics%'")  // Search for Mathematics subject
                    ->get();

                if ($form4Subjects->isNotEmpty()) {
                    // Log::info('Qualified: Mathematics found in Form4Results');
                } else {
                    // Log::warning('Not Qualified: Mathematics not found in Form4Results');
                    // Applicant is NOT qualified if both Advanced Mathematics and Mathematics are not found
                    return collect();  // Returning empty collection to indicate "Not Qualified"
                }
            }
        }

        // Log::info('All Subjects:', $subjects->toArray());
        // Log::info('Formatted Requirements:', $formattedRequirements);

        // Step 1: Filter subjects that match required courses
        $matchingSubjects = $subjects->filter(function ($subject) use ($formattedRequirements) {
            foreach ($formattedRequirements['subject_courses'] as $requiredCourse) {
                if (stripos($subject->subject_name, $requiredCourse) !== false) {
                    return true;
                }
            }
            return false;
        });

        // Log::info('Matching Subjects:', $matchingSubjects->toArray());

        // Step 2: Count matched subjects and check min_advance_principle_pass
        $matchedCount = $matchingSubjects->count();
        $minAdvancePrinciplePass = $formattedRequirements['min_advance_principle_pass'] ?? 0;

        // Log::info("Matched Subjects Count: $matchedCount");
        // Log::info("Required Min Advance Principle Pass: $minAdvancePrinciplePass");

        if ($matchedCount < $minAdvancePrinciplePass) {
            // Log::warning("Not enough matching subjects. Required: $minAdvancePrinciplePass, Found: $matchedCount");
        }

        // Step 3: Calculate total grade value and compare with min_advance_aggregate_points
        $totalGradeValue = $matchingSubjects->sum(function ($subject) {
            return $subject->grade_value;
        });

        $minAdvanceAggregatePoints = $formattedRequirements['min_advance_aggregate_points'] ?? 0;

        // Log::info("Total Grade Value: $totalGradeValue");
        // Log::info("Required Min Advance Aggregate Points: $minAdvanceAggregatePoints");

        if ($totalGradeValue < $minAdvanceAggregatePoints) {
            // Log::warning("Total grade value is too low. Required: $minAdvanceAggregatePoints, Found: $totalGradeValue");
        }

        // Log final decision
        if ($matchedCount >= $minAdvancePrinciplePass && $totalGradeValue >= $minAdvanceAggregatePoints) {
            // Log::info("Requirements met successfully!");
        } else {
            // Log::warning("Requirements NOT met.");
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


    public function foundationIndex(Request $request)
    {
        $applicationLevels = ApplicationLevel::where('name', 'LIKE', '%bachelor%')->pluck('id');
        $programmes        = Programme::whereIn('application_level_id', $applicationLevels)->get();

        $programme_id         = $request->input('programme_id', null);
        $application_level_id = $request->input('application_level_id', null);
        $capacity             = $request->input('capacity', null); // Get capacity from request

        $foundationcategory = ApplicationCategory::where('name', 'LIKE', '%foundation%')
            ->where('application_level_id', $application_level_id)
            ->pluck('id');

        $foundationlists = $foundationcategory->isNotEmpty()
            ? collect($this->getfoundationList($foundationcategory, $programme_id))
            : collect([]);

        return view('Selection.Bachelor.foundationindex', compact('programmes', 'applicationLevels', 'foundationlists'));
    }

    protected function getfoundationList($category_id, $programme_id)
    {
        $category_ids = $category_id->toArray();
        $academic_year_id = AcademicYear::where('active', 1)->value('id');
        $window_id = ApplicationWindow::where('active', 1)->value('id');
        $intake_id = ApplicationWindow::where('active', 1)->value('intake_id');
        $education_level = EducationLevel::where('name', 'LIKE', '%foundation%')->value('id');

        // Get all applicants in the given category and academic year
        $applicants = ApplicantsInfo::whereIn('application_category_id', $category_ids)
            ->where('acadmic_year_id', $academic_year_id)
            ->where('intake_id', $intake_id)
            ->get();

        // Log::info('applicants', $applicants->toArray());
        // Extract applicant_user_ids
        $applicant_user_ids = $applicants->pluck('applicant_user_id');

        // Filter foundation applicants with GPA >= 3
        $foundation = ApplicantsAcademic::whereIn('applicant_user_id', $applicant_user_ids)
            ->where('education_level', $education_level)
            ->whereRaw('CAST(gpa_divission AS DECIMAL) >= ?', [3])
            ->pluck('applicant_user_id');

        // Log::info('foundation', $foundation->toArray());

        // Get choices for only foundation applicants that match the programme_id
        $choices = ApplicantsChoice::whereIn('applicant_user_id', $foundation)
            ->where('academic_year_id', $academic_year_id)
            ->where('intake_id', $intake_id)
            ->where('window_id', $window_id)
            ->where('status', 0)
            ->get()
            ->filter(function ($choice) use ($programme_id) {
                return in_array($programme_id, [$choice->choice1, $choice->choice2, $choice->choice3]);
            });

        // Ensure only foundation applicants with valid choices are included
        $validApplicants = $applicants->whereIn('applicant_user_id', $foundation)
            ->filter(function ($applicant) use ($choices) {
                return $choices->contains('applicant_user_id', $applicant->applicant_user_id);
            });

        if ($validApplicants->isEmpty()) {
            return collect();
        }

        // Retrieve final applicant list with details
        return ApplicantsInfo::whereIn('applicant_user_id', $validApplicants->pluck('applicant_user_id'))
            ->with('applicantUser')
            ->get()
            ->map(function ($applicant) use ($choices, $education_level, $programme_id) {
                $selectedChoice = $choices->firstWhere('applicant_user_id', $applicant->applicant_user_id);
                $applicant->programme_id = $programme_id ?? null;
                $applicant->education_level = $education_level;
                return $applicant;
            });
    }
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
        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)->where('active', 1)->pluck('id')->toArray();
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
                continue;
                //return redirect()->back()->with('error', "No Form 6 results found for applicant $applicantId.");
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
                    continue; // Skip this applicant if they do not meet the Mathematics requirement
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
        return view('selection.Bachelor.index-six', compact('programme', 'allSelected'));
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
                    'qualification_no' => $applicant->qualification_no,
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
                    'application_category_id'=>$applicant->categoryId,
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
        return redirect()->route('bachelor.six')->with('success', 'Selected applicants have been saved and status updated.');
    }
    public function diploma(Request $request)
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
        $educationlevel = EducationLevel::where('name', 'LIKE', '%Diploma%')->first();

        if (!$educationlevel) {
            return redirect()->back()->with('error', 'Education level not found.');
        }
        $categoryIds = ApplicationCategory::where('application_level_id', $level->id)
            ->where('active', 1)
            ->pluck('id')->toArray();
        // Fetch bachelor requirements for the given programme and education level
        $requirement = BachelorRequirement::where('programme_id', $programme_id)
            ->where('education_level_id', $educationlevel->id)->first();

        // Get all applicants with the given programme ID in their choice1, choice2, or choice3
        $applicantUserid = ApplicantsChoice::whereIn('choice1', [$programme_id])
            ->orWhereIn('choice2', [$programme_id])
            ->orWhereIn('choice3', [$programme_id])
            ->pluck('applicant_user_id')->toArray();

        Log::info('Applicants in programme: ' . json_encode($applicantUserid));
        $academic_course = ApplicantsAcademic::where('applicant_user_id', $applicantUserid)
            ->where('education_level', $educationlevel->id)->pluck('course');

        Log::info("Course Name is " . $academic_course);
        //Get the subject_course from bachelor requirement
        $courseRequirement = BachelorRequirement::where('subject_course', 'LIKE', '%' . $academic_course . '%')->get();

         Log::info("Course Requirement is " . json_encode($courseRequirement));


        //print_r($allTotalPoints);die();
        return view('selection.Bachelor.index-diploma', compact('programme'));
    }
}

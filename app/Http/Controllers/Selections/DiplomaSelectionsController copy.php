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
use App\Models\DiplomaRequirement;
use App\Models\DiplomaSelection;
use App\Models\EducationLevel;
use App\Models\Form6Result;
use App\Models\NextOfKin;
use App\Models\Programme;
use App\Models\SelectedDiplomaCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DiplomaSelectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $educationLevels = EducationLevel::whereIn('name', ['Form Six', 'Certificate'])->get();
        $applicationLevels = ApplicationLevel::where('name', 'LIKE', '%odinary diploma%')->pluck('id');
        $programmes = Programme::whereIn('application_level_id', $applicationLevels)->get();

        $programme_id = $request->input('programme_id', null);

        $application_level_id = $request->input('application_level_id', null);

        $forsixcategory = ApplicationCategory::where('name', 'LIKE', '%six%')
            ->where('application_level_id', $application_level_id)
            ->pluck('id');
        $level4category = ApplicationCategory::where('name', 'LIKE', '%nta%')
            ->where('application_level_id', $application_level_id)
            ->pluck('id');

        $forsixlists = $forsixcategory->isNotEmpty() ? collect($this->getformsixlist($forsixcategory[0], $programme_id)) : collect([]);
        $fornta4lists = $level4category->isNotEmpty() ? collect($this->getnta4list($level4category[0], $programme_id)) : collect([]);

        return view('Selection.Diploma.index', compact('programmes', 'applicationLevels', 'forsixlists', 'fornta4lists'));
    }

    protected function getformsixlist($category_id, $programme_id)
    {
        $category_ids = $category_id->toArray();
        $academic_year_id = AcademicYear::where('active', 1)->value('id');
        $window_id = ApplicationWindow::where('active', 1)->value('id');
        $intake_id = ApplicationWindow::where('active', 1)->value('intake_id');
        $education_level = EducationLevel::where('name', 'LIKE', 'form six')->value('id');

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

        $subjects = Form6Result::whereIn('applicant_user_id', $applicant_user_ids)
            ->where('status', 1)
            ->whereRaw("subject_name NOT REGEXP 'islamic|bible|christian|basic applied|general studies'")
            ->get();

        // Get choices matching the programme_id
        $choices = ApplicantsChoice::whereIn('applicant_user_id', $applicant_user_ids)
            ->where('academic_year_id', $academic_year_id)
            ->where('intake_id', $intake_id)
            ->where('window_id', $window_id)
            ->where('status', 0)  // Ensure status matches the valid ones
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

        $qualifiedApplicants = $validApplicants->filter(function ($applicant) use ($subjects, $choices) {
            $applicantSubjects = $subjects->where('applicant_user_id', $applicant->applicant_user_id);
            $sGradeCount = $applicantSubjects->where('grade', 'S')->count();
            $otherGradesCount = $applicantSubjects->where('grade', '!=', 'S')->count();

            // Select the matching choice for the applicant
            $selectedChoice = $choices->firstWhere('applicant_user_id', $applicant->applicant_user_id);
            return ($otherGradesCount > 0 || ($sGradeCount > 0 && $otherGradesCount > 0)) && $selectedChoice;
        });

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

    protected function getnta4list($category_id, $programme_id)
    {
        $category_ids = $category_id->toArray();
        $academic_year_id = AcademicYear::where('active', 1)->value('id');
        $window_id = ApplicationWindow::where('active', 1)->value('id');
        $intake_id = ApplicationWindow::where('active', 1)->value('intake_id');
        $education_level = EducationLevel::where('name', 'LIKE', '%certificate%')->value('id');

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

        $diplomaRequirements = DiplomaRequirement::where('programme_id', $programme_id)
            ->where('education_level_id', $education_level)
            ->pluck('subject_course');

        // Filter applicants based on course comparison
        $qualifiedApplicants = $validApplicants->filter(function ($applicant) use ($courses, $diplomaRequirements) {
            $course_name = strtolower($courses[$applicant->applicant_user_id] ?? '');
            return $diplomaRequirements->contains(function ($subject_course) use ($course_name) {
                return str_contains(strtolower($course_name), strtolower($subject_course));
            });
        });

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $applicants = $request->input('applicants', []);

        $window_id = ApplicationWindow::where('active', 1)->value('id');

        if (!$window_id) {
            Log::warning('No active application window found.');
        }

        if (empty($applicants)) {
            Log::info('No applicants received.');
            return response()->json(['success' => false, 'message' => 'No applicants provided.'], 400);
        }

        foreach ($applicants as $applicant) {
            $applicant_id = $applicant['applicant_id'] ?? null;
            $programme_id = $applicant['programme_id'] ?? null;
            $education_level = $applicant['education_level'] ?? null;

            $applicantinfos = ApplicantsInfo::with([
                'countryOfBirth',
                'placeOfBirth',
                'districtOfBirth',
                'region',
                'district',
                'country',
                'academicYear',
                'campus',
                'intake',
                'nationalit',
                'employer',
                'disability'
            ])->find($applicant_id);

            if (!$applicantinfos) {
                continue; // Skip if no applicant info found
            }

            $nextofkinInfos = NextOfKin::with(['country', 'region', 'district', 'relationship', 'nationalit'])
                ->where('applicant_user_id', $applicantinfos->applicant_user_id)
                ->first();

            $academics = ApplicantsAcademic::where('applicant_user_id', $applicantinfos->applicant_user_id)
                ->where('education_level', $education_level)
                ->pluck('qualification_no');

            // Get the first qualification number, or fallback to index_no
            $qualification_no = $academics->first() ?? $applicantinfos->index_no;

            // Insert or update in selected_diploma_certificates
            $saveToSelected = SelectedDiplomaCertificate::updateOrCreate(
                [
                    'applicant_user_id' => $applicantinfos->applicant_user_id,
                    'iaa_programme_code' => $programme_id,
                    'application_year' => date('Y')
                ],
                [
                    'index_no' => $applicantinfos->index_no,
                    'qualification_no' => $qualification_no,
                    'first_name' => $applicantinfos->fname,
                    'middle_name' => $applicantinfos->mname,
                    'last_name' => $applicantinfos->lname,
                    'dob' => $applicantinfos->birth_date,
                    'gender' => $applicantinfos->gender,
                    'disability' => optional($applicantinfos->disability)->name,
                    'email' => optional($applicantinfos->applicantUser)->email,
                    'mobile_no' => optional($applicantinfos->applicantUser)->mobile_no,
                    'physical_address' => $applicantinfos->physical_address,
                    'campus_id' => $applicantinfos->campus_id,
                    'region' => optional($applicantinfos->region)->name,
                    'district' => optional($applicantinfos->district)->name,
                    'nationality' => optional($applicantinfos->nationalit)->name,
                    'next_kin_name' => optional($nextofkinInfos)->fname . ' ' . optional($nextofkinInfos)->lname,
                    'next_kin_address' => optional($nextofkinInfos)->physical_address,
                    'next_kin_email' => optional($nextofkinInfos)->email,
                    'next_kin_phone' => optional($nextofkinInfos)->mobile_no,
                    'next_kin_region' => optional($nextofkinInfos->region)->name,
                    'next_kin_district' => optional($nextofkinInfos->district)->name,
                    'next_kin_nationality' => optional($nextofkinInfos->nationalit)->name,
                    'next_kin_relationship' => optional($nextofkinInfos->relationship)->name,
                    'nacte_programme_code' => $programme_id,
                    'intake' => optional($applicantinfos->intake)->name,
                    'nta_level' => '4',
                    'window' => $window_id,
                    'nacte_status' => 1,
                ]
            );

            // Update applicant_choices table (set status = 1)
            if ($saveToSelected) {
                ApplicantsChoice::where([
                    'applicant_user_id' => $applicantinfos->applicant_user_id,
                    'index_no' => $applicantinfos->index_no,
                    'intake_id' => $applicantinfos->intake_id,
                    'academic_year_id' => $applicantinfos->acadmic_year_id
                ])->update(['status' => 1]);
            }
        }

        return response()->json(['success' => true]);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DiplomaSelection  $diplomaSelection
     * @return \Illuminate\Http\Response
     */
    public function show(DiplomaSelection $diplomaSelection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DiplomaSelection  $diplomaSelection
     * @return \Illuminate\Http\Response
     */
    public function edit(DiplomaSelection $diplomaSelection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DiplomaSelection  $diplomaSelection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiplomaSelection $diplomaSelection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DiplomaSelection  $diplomaSelection
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiplomaSelection $diplomaSelection)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Selections;

use App\Http\Controllers\Controller;
use App\Models\ApplicationLevel;
use App\Models\BachelorRequirement;
use App\Models\DiplomaRequirement;
use App\Models\EducationLevel;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BachelorRequirementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requirements = BachelorRequirement::all();

        return view('Selection.Settings.programmes-requirements.bachelor.index', compact('requirements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $educationLevels = EducationLevel::whereIn('name', ['Form Six', 'Diploma'])->get();
        $applicationLevels = ApplicationLevel::where('name', 'LIKE', '%bachelor%')->pluck('id');
        $programmes = Programme::whereIn('application_level_id', $applicationLevels)->get();

        return view('Selection.Settings.programmes-requirements.bachelor.create', compact('programmes', 'educationLevels', 'applicationLevels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'programme_id' => 'required|integer|exists:programmes,id',
            'application_level_id' => 'required|integer|exists:application_levels,id',
            'education_level_id' => 'required|integer|exists:education_levels,id',
            'subject_course_diploma' => 'nullable|string', // For Certificate courses
            'min_olevel_pass' => 'nullable|integer', // For Diploma
            'min_olevel_average' => 'nullable|string', // For Diploma
            'min_foundation_gpa_diploma' => 'nullable|numeric', // For Diploma (GPA)
            'subject_course_six' => 'nullable|string', // For Form Six subjects
            'min_advance_principle_pass' => 'nullable|integer', // For Form Six
            'min_advance_aggregate_points' => 'nullable|integer', // For Form Six
            'min_foundation_gpa_six' => 'nullable|numeric', // For Form Six (GPA)
            'math' => 'nullable|boolean', // Math requirement
        ]);

        // Check if a general requirement already exists (excluding subjects)
        $existingRequirement = BachelorRequirement::where([
            'application_level_id' => $request->input('application_level_id'),
            'education_level_id' => $request->input('education_level_id'),
            'programme_id' => $request->input('programme_id'),
        ])->whereNull('subject_course')->first();

        if ($existingRequirement) {
            // Update general requirements only
            $existingRequirement->update([
                'min_olevel_pass' => $request->input('min_olevel_pass'),
                'min_olevel_average' => $request->input('min_olevel_average'),
                'min_foundation_gpa' => $request->input('min_foundation_gpa_diploma'),
                'min_advance_principle_pass' => $request->input('min_advance_principle_pass'),
                'min_advance_aggregate_points' => $request->input('min_advance_aggregate_points'),
                'math' => $request->input('math', 0),
            ]);
        } else {
            // Insert new general requirement
            BachelorRequirement::create([
                'application_level_id' => $request->input('application_level_id'),
                'education_level_id' => $request->input('education_level_id'),
                'programme_id' => $request->input('programme_id'),
                'min_olevel_pass' => $request->input('min_olevel_pass'),
                'min_olevel_average' => $request->input('min_olevel_average'),
                'min_foundation_gpa' => $request->input('min_foundation_gpa_diploma'),
                'min_advance_principle_pass' => $request->input('min_advance_principle_pass'),
                'min_advance_aggregate_points' => $request->input('min_advance_aggregate_points'),
                'math' => $request->input('math', 0),
            ]);
        }

        // Process Certificate Courses (Diploma level)
        if ($request->filled('subject_course_diploma')) {
            $certificateCourses = array_map('trim', explode(',', $request->input('subject_course_diploma')));

            foreach ($certificateCourses as $course) {
                BachelorRequirement::create([
                    'application_level_id' => $request->input('application_level_id'),
                    'education_level_id' => $request->input('education_level_id'),
                    'programme_id' => $request->input('programme_id'),
                    'subject_course' => $course, // Store certificate courses
                ]);
            }
        }

        // Process Form Six Subjects
        if ($request->filled('subject_course_six')) {
            $formSixSubjects = array_map('trim', explode(',', $request->input('subject_course_six')));

            foreach ($formSixSubjects as $subject) {
                BachelorRequirement::create([
                    'application_level_id' => $request->input('application_level_id'),
                    'education_level_id' => $request->input('education_level_id'),
                    'programme_id' => $request->input('programme_id'),
                    'subject_course' => $subject, // Store Form Six subjects
                ]);
            }
        }

        // Check and store Diploma Foundation GPA if provided
        if ($request->filled('min_foundation_gpa_diploma')) {
            BachelorRequirement::create([
                'application_level_id' => $request->input('application_level_id'),
                'education_level_id' => $request->input('education_level_id'),
                'programme_id' => $request->input('programme_id'),
                'min_foundation_gpa' => $request->input('min_foundation_gpa_diploma'), // Store Diploma GPA
            ]);
        }

        // Check and store Form Six GPA if provided
        if ($request->filled('min_foundation_gpa_six')) {
            BachelorRequirement::create([
                'application_level_id' => $request->input('application_level_id'),
                'education_level_id' => $request->input('education_level_id'),
                'programme_id' => $request->input('programme_id'),
                'min_foundation_gpa' => $request->input('min_foundation_gpa_six'), // Store Form Six GPA
            ]);
        }

        // Session flash message and redirect
        session()->flash('success', 'Requirements saved successfully!');
        return redirect()->route('bachelor-requirements.index');
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BachelorRequirement  $bachelorRequirement
     * @return \Illuminate\Http\Response
     */
    public function show(BachelorRequirement $bachelorRequirement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BachelorRequirement  $bachelorRequirement
     * @return \Illuminate\Http\Response
     */
    public function edit($applicationLevelId, $educationLevelId, $programmeId)
    {
        $educationLevels = EducationLevel::whereIn('name', ['Form Six', 'Diploma'])->get();
        $applicationLevels = ApplicationLevel::where('name', 'LIKE', '%bachelor%')->pluck('id');
        $programmes = Programme::whereIn('application_level_id', $applicationLevels)->get();

        // Fetch all bachelor requirements based on the given IDs
        $bachelorRequirements = BachelorRequirement::where('application_level_id', $applicationLevelId)
            ->where('education_level_id', $educationLevelId)
            ->where('programme_id', $programmeId)
            ->get();

        Log::info($bachelorRequirements);
        // Extract min_olevel_pass, min_olevel_average, min_foundation_gpa_diploma, and min_foundation_gpa_six
        $min_olevel_pass = optional($bachelorRequirements->first())->min_olevel_pass;
        $min_olevel_average = optional($bachelorRequirements->first())->min_olevel_average;
        $min_foundation_gpa_diploma = optional($bachelorRequirements->first())->min_foundation_gpa;
        $min_foundation_gpa_six = optional($bachelorRequirements->first())->min_foundation_gpa;
        $min_advance_principle_pass = optional($bachelorRequirements->first())->min_advance_principle_pass;
        $min_advance_aggregate_points = optional($bachelorRequirements->first())->min_advance_aggregate_points;
        $math = optional($bachelorRequirements->first())->math;
        // Convert subject_course into a comma-separated string
        $subjects = $bachelorRequirements->pluck('subject_course')->filter()->implode(', ');
        Log::info($subjects);

        return view('Selection.Settings.programmes-requirements.bachelor.edit', compact(
            'applicationLevels',
            'educationLevels',
            'programmes',
            'subjects',
            'min_olevel_pass',
            'min_olevel_average',
            'min_foundation_gpa_diploma',
            'min_foundation_gpa_six',
            'applicationLevelId',
            'educationLevelId',
            'programmeId',
            'min_advance_aggregate_points',
            'min_advance_principle_pass',
            'math'
        ));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BachelorRequirement  $bachelorRequirement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $applicationLevelId, $educationLevelId, $programmeId)
    {
        // Validate input
        $request->validate([
            'programme_id' => 'required|integer|exists:programmes,id',
            'application_level_id' => 'required|integer|exists:application_levels,id',
            'education_level_id' => 'required|integer|exists:education_levels,id',
            'min_olevel_pass' => 'nullable|integer', // For Diploma
            'min_olevel_average' => 'nullable|string', // For Diploma
            'subject_course' => 'nullable|string', // For Form Six subjects
            'min_advance_principle_pass' => 'nullable|integer', // For Form Six
            'min_advance_aggregate_points' => 'nullable|integer', // For Form Six
            'min_foundation_gpa' => 'nullable|numeric', // For Form Six (GPA)
            'math' => 'nullable|boolean', // Math requirement
        ]);

        // Find existing requirement
        $requirement = BachelorRequirement::where('application_level_id', $applicationLevelId)
            ->where('education_level_id', $educationLevelId)
            ->where('programme_id', $programmeId)
            ->firstOrFail();

        // Update 'min_advance_pass' and 'min_subsidiary_pass'
        $requirement->update([
            'min_olevel_pass' => $request->input('min_olevel_pass'),
            'min_olevel_average' => $request->input('min_olevel_average'),
            'min_foundation_gpa' => $request->input('min_foundation_gpa'),
            'min_advance_principle_pass' => $request->input('min_advance_principle_pass'),
            'min_advance_aggregate_points' => $request->input('min_advance_aggregate_points'),
            'math' => $request->input('math'),
        ]);

        // Handle subject courses update
        if ($request->filled('subject_course')) {
            $subjects = array_map('trim', explode(',', $request->input('subject_course')));

            // Delete existing subjects that are not in the new list
            BachelorRequirement::where('application_level_id', $applicationLevelId)
                ->where('education_level_id', $educationLevelId)
                ->where('programme_id', $programmeId)
                ->whereNotIn('subject_course', $subjects)
                ->delete();

            // Insert new subjects if they don't exist
            foreach ($subjects as $subject) {
                $exists = BachelorRequirement::where('application_level_id', $applicationLevelId)
                    ->where('education_level_id', $educationLevelId)
                    ->where('programme_id', $programmeId)
                    ->where('subject_course', $subject)
                    ->exists();

                if (!$exists) {
                    BachelorRequirement::create([
                        'application_level_id' => $applicationLevelId,
                        'education_level_id' => $educationLevelId,
                        'programme_id' => $programmeId,
                        'subject_course' => $subject,
                    ]);
                }
            }
        }

        session()->flash('success', 'Requirements updated successfully!');

        return redirect()->route('bachelor-requirements.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BachelorRequirement  $bachelorRequirement
     * @return \Illuminate\Http\Response
     */
    public function destroy(BachelorRequirement $bachelorRequirement)
    {
        //
    }
}

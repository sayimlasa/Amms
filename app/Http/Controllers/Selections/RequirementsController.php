<?php

namespace App\Http\Controllers\Selections;

use App\Http\Controllers\Controller;
use App\Models\ApplicationLevel;
use App\Models\Disability;
use App\Models\EducationLevel;
use App\Models\Requirement;
use Illuminate\Http\Request;

class RequirementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requirements = Requirement::all();
 
        return view('Selection.Settings.requirements.index', compact('requirements'));
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $applicationLevels = ApplicationLevel::get();
        $educationLevels = EducationLevel::get();
        return view('Selection.Settings.requirements.create', compact('applicationLevels', 'educationLevels'));
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
        'application_level_id' => 'required|integer|exists:application_levels,id',
        'education_level_id' => 'required|integer|exists:education_levels,id',
        'subject_course' => 'required|string',
    ]);

    // Split input into an array
    $subjects = array_map('trim', explode(',', $request->input('subject_course')));

    foreach ($subjects as $subject) {
        // Check if the subject already exists for the given level combination
        $exists = Requirement::where('application_level_id', $request->input('application_level_id'))
            ->where('education_level_id', $request->input('education_level_id'))
            ->where('subject_course', $subject)
            ->exists();

        if (!$exists) {
            Requirement::create([
                'application_level_id' => $request->input('application_level_id'),
                'education_level_id' => $request->input('education_level_id'),
                'subject_course' => $subject,
            ]);
        }
    }

    session()->flash('success', 'Requirements saved successfully!');

    return redirect()->route('requirements.index');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function show(Requirement $requirement)
    {
        return view('Admission.Settings.disabilities.show', compact('disability'));
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function edit($applicationLevelId, $educationLevelId)
    {
        $applicationLevel = ApplicationLevel::findOrFail($applicationLevelId);
        $educationLevel = EducationLevel::findOrFail($educationLevelId);
    
        // Get subjects as a comma-separated string
        $subjects = Requirement::where('application_level_id', $applicationLevelId)
            ->where('education_level_id', $educationLevelId)
            ->pluck('subject_course')
            ->unique()
            ->implode(', ');
    
        return view('Selection.Settings.requirements.edit', compact('applicationLevel', 'educationLevel', 'subjects', 'applicationLevelId', 'educationLevelId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $applicationLevelId, $educationLevelId)
    {
        $request->validate([
            'subject_course' => 'required|string',
        ]);
    
        // Get new subjects from input
        $newSubjects = array_map('trim', explode(',', $request->input('subject_course')));
    
        // Get existing subjects
        $existingSubjects = Requirement::where('application_level_id', $applicationLevelId)
            ->where('education_level_id', $educationLevelId)
            ->pluck('subject_course')
            ->toArray();
    
        // Delete subjects that are no longer in the input
        Requirement::where('application_level_id', $applicationLevelId)
            ->where('education_level_id', $educationLevelId)
            ->whereNotIn('subject_course', $newSubjects)
            ->delete();
    
        // Insert new subjects that don't already exist
        foreach ($newSubjects as $subject) {
            if (!in_array($subject, $existingSubjects)) {
                Requirement::create([
                    'application_level_id' => $applicationLevelId,
                    'education_level_id' => $educationLevelId,
                    'subject_course' => $subject,
                ]);
            }
        }
    
        session()->flash('success', 'Requirements updated successfully!');
    
        return redirect()->route('requirements.index');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requirement $requirement)
    {
        //
    }
}

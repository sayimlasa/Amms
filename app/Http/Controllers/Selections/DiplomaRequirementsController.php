<?php

namespace App\Http\Controllers\Selections;

use App\Http\Controllers\Controller;
use App\Models\ApplicationLevel;
use App\Models\DiplomaRequirement;
use App\Models\EducationLevel;
use App\Models\Programme;
use App\Models\Requirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DiplomaRequirementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requirements = DiplomaRequirement::all();
 
        return view('Selection.Settings.programmes-requirements.diploma.index', compact('requirements'));
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $educationLevels = EducationLevel::whereIn('name', ['Form Six', 'Certificate'])->get();
        $applicationLevels = ApplicationLevel::where('name', 'LIKE', '%odinary diploma%')->pluck('id');
        $programmes = Programme::whereIn('application_level_id', $applicationLevels)->get();
       
        return view('Selection.Settings.programmes-requirements.diploma.create', compact('programmes', 'educationLevels','applicationLevels'));
    
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
            'subject_course' => 'nullable|string',
            'min_advance_pass' =>'nullable|integer',
            'min_subsidiary_pass' =>'nullable|integer',
        ]);
    
        // Check if a record with the same programme and education level already exists
        $existingRequirement = DiplomaRequirement::where('application_level_id', $request->input('application_level_id'))
            ->where('education_level_id', $request->input('education_level_id'))
            ->where('programme_id', $request->input('programme_id'))
            ->first();
    
        if ($existingRequirement) {
            // If `min_advance_pass` or `min_subsidiary_pass` exist, update them
            $existingRequirement->update([
                'min_advance_pass' => $request->input('min_advance_pass'),
                'min_subsidiary_pass' => $request->input('min_subsidiary_pass'),
            ]);
        } else {
            // Create a new entry if it doesn't exist
            $existingRequirement = DiplomaRequirement::create([
                'application_level_id' => $request->input('application_level_id'),
                'education_level_id' => $request->input('education_level_id'),
                'programme_id' => $request->input('programme_id'),
                'min_advance_pass' => $request->input('min_advance_pass'),
                'min_subsidiary_pass' => $request->input('min_subsidiary_pass'),
            ]);
        }
    
        // Process subjects only if `subject_course` is not empty
        if ($request->filled('subject_course')) {
            $subjects = array_map('trim', explode(',', $request->input('subject_course')));
    
            foreach ($subjects as $subject) {
                // Check if the subject already exists for the given level combination
                $exists = DiplomaRequirement::where('application_level_id', $request->input('application_level_id'))
                    ->where('education_level_id', $request->input('education_level_id'))
                    ->where('programme_id', $request->input('programme_id'))
                    ->where('subject_course', $subject)
                    ->exists();
    
                if (!$exists) {
                    DiplomaRequirement::create([
                        'application_level_id' => $request->input('application_level_id'),
                        'education_level_id' => $request->input('education_level_id'),
                        'programme_id' => $request->input('programme_id'),
                        'subject_course' => $subject,
                    ]);
                }
            }
        }
    
        session()->flash('success', 'Requirements saved successfully!');
    
        return redirect()->route('diploma-requirements.index');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DiplomaRequirement  $diplomaRequirement
     * @return \Illuminate\Http\Response
     */
    public function show(DiplomaRequirement $diplomaRequirement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DiplomaRequirement  $diplomaRequirement
     * @return \Illuminate\Http\Response
     */
    public function edit($applicationLevelId, $educationLevelId, $programmeId)
    {
        // Fetch education levels (only Form Six and Certificate)
        $educationLevels = EducationLevel::whereIn('name', ['Form Six', 'Certificate'])->get();
    
        // Fetch application levels that contain 'ordinary diploma'
        $applicationLevels = ApplicationLevel::where('name', 'LIKE', '%odinary diploma%')->pluck('id');
    
        // Fetch programmes that match the application levels
        $programmes = Programme::whereIn('application_level_id', $applicationLevels)->get();
    
        // Fetch all diploma requirements (including multiple subject_course entries)
        $diplomaRequirements = DiplomaRequirement::where('application_level_id', $applicationLevelId)
            ->where('education_level_id', $educationLevelId)
            ->where('programme_id', $programmeId)
            ->get();
    
        // Extract min_advance_pass and min_subsidiary_pass (assuming they are the same for all entries)
        $min_advance_pass = optional($diplomaRequirements->first())->min_advance_pass;
        $min_subsidiary_pass = optional($diplomaRequirements->first())->min_subsidiary_pass;
    
        // Convert subjects to a comma-separated string
        $subjects = $diplomaRequirements->pluck('subject_course')->filter()->implode(', ');
    
        return view('Selection.Settings.programmes-requirements.diploma.edit', compact(
            'applicationLevels', 'educationLevels', 'programmes',
            'subjects', 'min_advance_pass', 'min_subsidiary_pass',
            'applicationLevelId', 'educationLevelId', 'programmeId'
        ));
    }
    
    
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DiplomaRequirement  $diplomaRequirement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $applicationLevelId, $educationLevelId, $programmeId)
{
    // Validate input
    $request->validate([
        'programme_id' => 'required|integer|exists:programmes,id',
        'application_level_id' => 'required|integer|exists:application_levels,id',
        'education_level_id' => 'required|integer|exists:education_levels,id',
        'subject_course' => 'nullable|string',
        'min_advance_pass' =>'nullable|integer',
        'min_subsidiary_pass' =>'nullable|integer',
    ]);

    // Find existing requirement
    $requirement = DiplomaRequirement::where('application_level_id', $applicationLevelId)
        ->where('education_level_id', $educationLevelId)
        ->where('programme_id', $programmeId)
        ->firstOrFail();

    // Update 'min_advance_pass' and 'min_subsidiary_pass'
    $requirement->update([
        'min_advance_pass' => $request->input('min_advance_pass'),
        'min_subsidiary_pass' => $request->input('min_subsidiary_pass'),
    ]);

    // Handle subject courses update
    if ($request->filled('subject_course')) {
        $subjects = array_map('trim', explode(',', $request->input('subject_course')));

        // Delete existing subjects that are not in the new list
        DiplomaRequirement::where('application_level_id', $applicationLevelId)
            ->where('education_level_id', $educationLevelId)
            ->where('programme_id', $programmeId)
            ->whereNotIn('subject_course', $subjects)
            ->delete();

        // Insert new subjects if they don't exist
        foreach ($subjects as $subject) {
            $exists = DiplomaRequirement::where('application_level_id', $applicationLevelId)
                ->where('education_level_id', $educationLevelId)
                ->where('programme_id', $programmeId)
                ->where('subject_course', $subject)
                ->exists();

            if (!$exists) {
                DiplomaRequirement::create([
                    'application_level_id' => $applicationLevelId,
                    'education_level_id' => $educationLevelId,
                    'programme_id' => $programmeId,
                    'subject_course' => $subject,
                ]);
            }
        }
    }

    session()->flash('success', 'Requirements updated successfully!');

    return redirect()->route('diploma-requirements.index');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DiplomaRequirement  $diplomaRequirement
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiplomaRequirement $diplomaRequirement)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;

class DepartmentsControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();

        return view('Admission.Settings.departments.index', compact('departments'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faculties = Faculty::all();

        return view('Admission.Settings.departments.create', compact('faculties'));
   
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
            'faculty_id' => 'required|exists:faculties,id',
            'name' => 'required|string',
        ]);
    
        $facultyId = $request->faculty_id;
        $names = explode(',', $request->name); // Split names by comma
    
        foreach ($names as $name) {
            $trimmedName = trim($name); // Remove spaces
    
            // Check if the department name already exists for the faculty
            $exists = Department::where('faculty_id', $facultyId)
                ->where('name', $trimmedName)
                ->exists();
    
            if (!$exists && !empty($trimmedName)) {
                Department::create([
                    'faculty_id' => $facultyId,
                    'name' => $trimmedName,
                    'active' => 0, // Default active status
                ]);
            }
        }
    
        session()->flash('success', 'Departments created successfully!');
    
        return redirect()->route('departments.index');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {    
       
        return view('Admission.Settings.departments.show', compact('department'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
{
    $faculties = Faculty::all();
    // Fetch all departments that belong to the same faculty
    $departments = Department::where('faculty_id', $department->faculty_id)->get();

    return view('Admission.Settings.departments.edit', compact('department', 'departments', 'faculties'));
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $faculty_id)
    {
        $request->validate([
            'name' => 'required|string',
            'faculty_id' => 'required|exists:faculties,id',
        ]);
    
        // Split the names and clean up whitespace
        $newNames = array_map('trim', explode(',', $request->name));
        $newNames = array_unique($newNames); // Remove duplicates
    
        // Get current department names in this faculty
        $existingNames = Department::where('faculty_id', $faculty_id)->pluck('name')->toArray();
    
        // Find departments to add (names that are new)
        $toAdd = array_diff($newNames, $existingNames);
    
        // Find departments to remove (existing names that are no longer in the new list)
        $toRemove = array_diff($existingNames, $newNames);
    
        // Insert new departments
        foreach ($toAdd as $name) {
            Department::create([
                'name' => $name,
                'faculty_id' => $faculty_id
            ]);
        }
    
        // Remove departments that are no longer in the list
        Department::where('faculty_id', $faculty_id)
            ->whereIn('name', $toRemove)
            ->delete();
    
        session()->flash('success', 'Departments updated successfully!');
    
        return redirect()->route('departments.index');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }
}

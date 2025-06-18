<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Models\EmploymentStatus;
use Illuminate\Http\Request;

class EmploymentStatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employmentStatuses = EmploymentStatus::all();

        return view('Admission.Settings.employment-statuses.index', compact('employmentStatuses'));
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         
        return view('Admission.Settings.employment-statuses.create');
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string', 
        ]);
    
        // If validation passes, proceed to create the record
        EmploymentStatus::create($validatedData);
    
        // Flash a success message
        session()->flash('success', 'EmploymentStatus created successfully!');
    
        // Redirect to the countries index page
        return redirect()->route('employment-statuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmploymentStatus  $employmentStatus
     * @return \Illuminate\Http\Response
     */
    public function show(EmploymentStatus $employmentStatus)
    {
        return view('Admission.Settings.employment-statuses.show', compact('EmploymentStatus'));
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmploymentStatus  $employmentStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(EmploymentStatus $employmentStatus)
    {
        return view('Admission.Settings.employment-statuses.edit', compact('employmentStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmploymentStatus  $employmentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmploymentStatus $employmentStatus)
    {
        $validatedData = $request->validate([
            'name' => 'required|string', 
        ]);

        $employmentStatus->update($validatedData);
    // Update country
    session()->flash('success', 'EmploymentStatus Updated successfully!');

    return redirect()->route('employment-statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmploymentStatus  $employmentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmploymentStatus $employmentStatus)
    {
        //
    }
}

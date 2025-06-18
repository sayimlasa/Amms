<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Models\MaritalStatus;
use Illuminate\Http\Request;

class MaritalStatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maritalStatuses = MaritalStatus::all();

        return view('Admission.Settings.marital-statuses.index', compact('maritalStatuses'));
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admission.Settings.marital-statuses.create');
    
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
        MaritalStatus::create($validatedData);
    
        // Flash a success message
        session()->flash('success', 'maritalStatus created successfully!');
    
        // Redirect to the countries index page
        return redirect()->route('marital-statuses.index');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\Response
     */
    public function show(MaritalStatus $maritalStatus)
    {
        return view('Admission.Settings.marital-statuses.show', compact('maritalStatus'));
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(MaritalStatus $maritalStatus)
    {
        return view('Admission.Settings.marital-statuses.edit', compact('maritalStatus'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaritalStatus $maritalStatus)
    {
        $validatedData = $request->validate([
            'name' => 'required|string', 
        ]);

        $maritalStatus->update($validatedData);
    // Update country
    session()->flash('success', 'maritalStatus Updated successfully!');

    return redirect()->route('marital-statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaritalStatus  $maritalStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaritalStatus $maritalStatus)
    {
        //
    }
}

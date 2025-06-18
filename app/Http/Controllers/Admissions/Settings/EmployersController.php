<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\EmploymentStatus;
use Illuminate\Http\Request;

class EmployersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employers = Employer::all();

        return view('Admission.Settings.employers.index', compact('employers'));
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = EmploymentStatus::select('id')
        ->where('name', 'LIKE', 'Emp%')
        ->first();
      
        return view('Admission.Settings.employers.create', compact('status'));
    
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
            'mobile_no' => 'required|regex:/^0\d{9,14}$/', 
            'email' => 'required|email', 
            'address' => 'required|string', 
            'emp_status_id' => 'required|exists:employment_statuses,id', 
        ]);
    
        // If validation passes, proceed to create the record
        Employer::create($validatedData);
    
        // Flash a success message
        session()->flash('success', 'Employer created successfully!');
    
        // Redirect to the countries index page
        return redirect()->route('employers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function show(Employer $employer)
    {
        return view('Admission.Settings.employers.show', compact('employer'));
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function edit(Employer $employer)
    {
        return view('Admission.Settings.employers.edit', compact('employer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employer $employer)
    {
        $validatedData = $request->validate([
            'name' => 'required|string', 
            'mobile_no' => 'required|regex:/^0\d{9,14}$/', 
            'email' => 'required|email', 
            'address' => 'required|string' 
        ]);

        $employer->update($validatedData);
    // Update country
    session()->flash('success', 'Employer Updated successfully!');

    return redirect()->route('employers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employer $employer)
    {
        //
    }
}

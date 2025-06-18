<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Models\Disability;
use Illuminate\Http\Request;

class DisabilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disabilities = Disability::all();

        return view('Admission.Settings.disabilities.index', compact('disabilities'));
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('Admission.Settings.disabilities.create');
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // Validate the input
    $validatedData = $request->validate([
        'name' => 'required|string', 
    ]);

    // If validation passes, proceed to create the record
    Disability::create($validatedData);

    // Flash a success message
    session()->flash('success', 'Disability created successfully!');

    // Redirect to the countries index page
    return redirect()->route('disabilities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disability  $disability
     * @return \Illuminate\Http\Response
     */
    public function show(Disability $disability)
    {
        return view('Admission.Settings.disabilities.show', compact('disability'));
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disability  $disability
     * @return \Illuminate\Http\Response
     */
    public function edit(Disability $disability)
    {
        return view('Admission.Settings.disabilities.edit', compact('disability'));
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disability  $disability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disability $disability)
    {
        $validatedData = $request->validate([
            'name' => 'required|string', 
        ]);

        $disability->update($validatedData);
    // Update country
    session()->flash('success', 'Disability Updated successfully!');

    return redirect()->route('disabilities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disability  $disability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disability $disability)
    {
        //
    }
}

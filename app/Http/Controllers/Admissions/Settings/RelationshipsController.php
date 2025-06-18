<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Models\Relationship;
use Illuminate\Http\Request;

class RelationshipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $relationships = Relationship::all();

        return view('Admission.Settings.relationships.index', compact('relationships'));
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admission.Settings.relationships.create');
    
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
    Relationship::create($validatedData);

    // Flash a success message
    session()->flash('success', 'Relationship created successfully!');

    // Redirect to the countries index page
    return redirect()->route('relationships.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Relationship  $relationship
     * @return \Illuminate\Http\Response
     */
    public function show(Relationship $relationship)
    {
        return view('Admission.Settings.relationships.show', compact('relationship'));
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Relationship  $relationship
     * @return \Illuminate\Http\Response
     */
    public function edit(Relationship $relationship)
    {
        return view('Admission.Settings.relationships.edit', compact('relationship'));
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Relationship  $relationship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Relationship $relationship)
    {
        $validatedData = $request->validate([
            'name' => 'required|string', 
        ]);

        $relationship->update($validatedData);
    // Update country
    session()->flash('success', 'Relationship Updated successfully!');

    return redirect()->route('relationships.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relationship  $relationship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Relationship $relationship)
    {
        //
    }
}

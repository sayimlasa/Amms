<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Update\UpdateApplicationLevelRequest;
use App\Models\ApplicationLevel;
use App\Models\Campus;
use Illuminate\Http\Request;

class ApplicationLevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applicationlevels = ApplicationLevel::all();
        return view('Admission.Settings.application-levels.index', compact('applicationlevels'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campuses = Campus::all();
        return view('Admission.Settings.application-levels.create', compact('campuses'));
    }

    /**
     * Store a newly created resource in storage. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $applicationLevel = ApplicationLevel::create($request->except(['campus_id']));

       $applicationLevel->campuses()->attach($request->campus_id);

        session()->flash('success', 'level created successfully!');

        return redirect()->route('application-levels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApplicationLevel  $applicationLevel
     * @return \Illuminate\Http\Response
     */
    public function show(ApplicationLevel $applicationLevel)
    {
        return view('Admission.Settings.application-levels.show', compact('applicationLevel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApplicationLevel  $applicationLevel
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplicationLevel $applicationLevel)
    {
        $campuses = Campus::all();
        return view('Admission.Settings.application-levels.edit', compact('applicationLevel','campuses'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApplicationLevel  $applicationLevel
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, ApplicationLevel $applicationLevel)
    // {
    //     $applicationLevel->update($request->all());
    //     // Update the academic year

        
    //     session()->flash('success', 'level Updated successfully!');
    
    //     return redirect()->route('application-levels.index');
    // }
    public function update(UpdateApplicationLevelRequest $request, $id)
    {
        $applicationLevel = ApplicationLevel::findOrFail($id);
        $applicationLevel->update($request->except(['campus_id']));
    
        // Sync the campuses and intakes
        $applicationLevel->campuses()->sync($request->campus_id);
    
        session()->flash('success', 'level Updated successfully!');
    
        return redirect()->route('application-levels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApplicationLevel  $applicationLevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicationLevel $applicationLevel)
    {
        //
    }
}

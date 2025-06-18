<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Store\StoreProgrammeRequest;
use App\Http\Requests\Settings\Update\UpdateProgrammeRequest;
use App\Models\ApplicationLevel;
use App\Models\Campus;
use App\Models\Intake;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProgrammesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programmes = Programme::with('campuses', 'intakes')->get();

        return view('Admission.Settings.programmes.index', compact('programmes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = ApplicationLevel::all();
        $campuses = Campus::all();
        $intakes = Intake::all();
        return view('Admission.Settings.programmes.create', compact('campuses', 'intakes', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgrammeRequest $request)
    {
        // Create the Programme record (without the campus_id and intake_id fields)
        $programme = Programme::create($request->except(['campus_id', 'intake_id']));

        // Attach campuses and intakes to the Programme using the appropriate pivot tables
        $programme->campuses()->attach($request->campus_id);
        $programme->intakes()->attach($request->intake_id);

        session()->flash('success', 'Programme created successfully!');

        return redirect()->route('programmes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function show(Programme $programme)
    {
        return view('Admission.Settings.programmes.show', compact('programme'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function edit(Programme $programme)
    {
        $levels = ApplicationLevel::all();
        $campuses = Campus::all();
        $intakes = Intake::all();
        return view('Admission.Settings.programmes.edit', compact('campuses', 'intakes', 'levels', 'programme'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProgrammeRequest $request, $id)
{
    $programme = Programme::findOrFail($id);
    $programme->update($request->except(['campus_id', 'intake_id']));

    // Sync the campuses and intakes
    $programme->campuses()->sync($request->campus_id);
    $programme->intakes()->sync($request->intake_id);

    session()->flash('success', 'Programme updated successfully!');
    return redirect()->route('programmes.index');
}

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Programme $programme)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Store\StoreRegionStateRequest;
use App\Http\Requests\Settings\Update\UpdateRegionStateRequest;
use App\Models\Country;
use App\Models\RegionState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegionsStatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regionStates = RegionState::all();

        return view('Admission.Settings.regions-states.index', compact('regionStates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();

        return view('Admission.Settings.regions-states.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegionStateRequest $request)
    {
        RegionState::create($request->all());

        session()->flash('success', 'created successfully!');

        return redirect()->route('regions-states.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RegionState  $regionState
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        $regionState = RegionState::find($id);  // Manually fetch by ID
    
       
        return view('Admission.Settings.regions-states.show', compact('regionState'));

    } 
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RegionState  $regionState
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $regionState = RegionState::find($id);  // Manually fetch by ID

        $countries = Country::all();
    
        return view('Admission.Settings.regions-states.edit', compact('regionState','countries'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RegionState  $regionState
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegionStateRequest $request, $id)
    {
        $regionState = RegionState::find($id);  // Manually fetch by ID

        $regionState->update($request->all());

        session()->flash('success', 'updated successfully!');

        return redirect()->route('regions-states.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RegionState  $regionState
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegionState $regionState)
    {
        //
    }
}

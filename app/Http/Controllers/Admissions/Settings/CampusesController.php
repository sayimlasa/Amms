<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Store\StoreCampusRequest;
use App\Http\Requests\Settings\Update\UpdateCampusRequest;
use App\Models\Campus;
use App\Models\Country;
use App\Models\District;
use App\Models\RegionState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CampusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campuses = Campus::all();

        return view('Admission.Settings.campuses.index', compact('campuses'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();

        return view('Admission.Settings.campuses.create', compact('countries'));
    }
    public function getRegions($country_id)
    {
        // Fetch regions by the country_id
        $regions = RegionState::where('country_id', $country_id)->get();

        // Return regions as a JSON response
        return response()->json($regions);
    }
    
    public function getDistricts($region_id)
    {
        // Fetch regions by the region_id
        $districts = District::where('region_state_id', $region_id)->get();

        // Return districts as a JSON response
        return response()->json($districts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampusRequest $request)
    {
        // Log::info($request->all());
        Campus::create($request->all());

        session()->flash('success', 'Campus created successfully!');

        return redirect()->route('campuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function show(Campus $campus)
    {
        return view('Admission.Settings.campuses.show', compact('campus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function edit(Campus $campus)
    {
        $countries = Country::all();
        
        return view('Admission.Settings.campuses.edit', compact('countries','campus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCampusRequest $request, Campus $campus)
    {
        $campus->update($request->all());

        session()->flash('success', 'Campus updated successfully!');

        return redirect()->route('campuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campus $campus)
    {
        //
    }
}

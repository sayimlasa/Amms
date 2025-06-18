<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Store\StoreDistrictRequest;
use App\Http\Requests\Settings\Update\UpdateDistrictRequest;
use App\Models\Country;
use App\Models\District;
use App\Models\RegionState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DistrictsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts = District::all();

        return view('Admission.Settings.districts.index', compact('districts'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();

        return view('Admission.Settings.districts.create', compact('countries'));
    
    }
    public function getRegions($country_id)
    {
        // Fetch regions by the country_id
        $regions = RegionState::where('country_id', $country_id)->get();

        // Return regions as a JSON response
        return response()->json($regions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDistrictRequest $request)
    {
        District::create($request->all());

        session()->flash('success', 'District created successfully!');

        return redirect()->route('districts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        return view('Admission.Settings.districts.show', compact('district'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        $countries = Country::all();
        

        return view('Admission.Settings.districts.edit', compact('countries','district'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDistrictRequest $request, District $district)
    {
        $district->update($request->all());

        session()->flash('success', 'District Updated successfully!');

    return redirect()->route('districts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        //
    }
}

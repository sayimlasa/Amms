<?php

namespace App\Http\Controllers\Admissions\Applicants;

use App\Http\Controllers\Controller;
use App\Models\ApplicantsInfo;
use App\Models\Country;
use App\Models\Nationality;
use App\Models\NextOfKin;
use App\Models\Relationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NextOfKinsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nextOfKins = NextOfKin::get();

        return view('Admission.Applicants.nextof-kins.index', compact('nextOfKins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $applicants = ApplicantsInfo::whereHas('academicYear', function ($query) {
            $query->where('active', 1);
        })->get();
        $countries = Country::get();
        $relationships = Relationship::get();
        $nationalities = Nationality::get();

        return view('Admission.Applicants.nextof-kins.create', compact('applicants', 'countries', 'relationships', 'nationalities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'index_no' => 'required|string',
            'fname' => 'required|string',
            'mname' => 'required|string',
            'lname' => 'required|string',
            'mobile_no' => 'required|regex:/^0\d{9,14}$/',
            'nationality' => 'required|integer',
            'country_id' => 'required|integer|exists:countries,id',
            'region_id' => 'required|integer|exists:regions_states,id',
            'district_id' => 'required|integer|exists:districts,id',
            'physical_address' => 'required|string',
            'relationship_id' => 'required|exists:relationships,id',
        ]);

        // Extract `index_no` and `applicant_user_id` from the selected value
        $selectedValue = $validatedData['index_no'];
        list($index_no, $applicant_user_id) = explode(',', $selectedValue);

        // Prepare the data for Next of Kin
        $nextOfKinData = [
            'mobile_no' => $validatedData['mobile_no'],
            'fname' => $validatedData['fname'],
            'mname' => $validatedData['mname'],
            'lname' => $validatedData['lname'],
            'nationality' => $validatedData['nationality'],
            'country_id' => $validatedData['country_id'],
            'region_id' => $validatedData['region_id'],
            'district_id' => $validatedData['district_id'],
            'physical_address' => $validatedData['physical_address'],
            'relationship_id' => $validatedData['relationship_id'],
        ];

        // Use `updateOrCreate` to create or update the Next of Kin record
        $nextOfKin = NextOfKin::updateOrCreate(
            [
                'applicant_user_id' => $applicant_user_id, // Find by applicant_user_id
                'index_no' => $index_no, // Ensure index_no matches
            ],
            $nextOfKinData // Update or insert with the provided data
        );

        session()->flash('success', 'Next of Kin added successfully!');

        // Redirect to a specific route or back
        return redirect()->route('nextof-kins.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NextOfKin  $nextOfKin
     * @return \Illuminate\Http\Response
     */
    public function show(NextOfKin $nextOfKin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NextOfKin  $nextOfKin
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nextOfKin = NextOfKin::where('id', $id)->first();
        $applicants = ApplicantsInfo::whereHas('academicYear', function ($query) {
            $query->where('active', 1);
        })->get();
        $nationalities = Nationality::all(); // Fetch nationalities
        $relationships = Relationship::all(); // Fetch relationships
        $countries = Country::all(); // Fetch countries

        return view('Admission.Applicants.nextof-kins.edit', compact('nextOfKin', 'applicants', 'nationalities', 'relationships', 'countries'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NextOfKin  $nextOfKin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nextOfKin = NextOfKin::where('id', $id)->first();
        $validatedData = $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:20',
            'nationality' => 'required|exists:nationalities,id',
            'relationship_id' => 'required|exists:relationships,id',
            'country_id' => 'required|exists:countries,id',
            'region_id' => 'required|exists:regions_states,id',
            'district_id' => 'required|exists:districts,id',
            'physical_address' => 'required|string|max:255',
        ]);

        $nextOfKin->update($validatedData);

        session()->flash('success', 'Next of Kin updated successfully!');

        // Redirect to a specific route or back
        return redirect()->route('nextof-kins.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NextOfKin  $nextOfKin
     * @return \Illuminate\Http\Response
     */
    public function destroy(NextOfKin $nextOfKin)
    {
        //
    }
}

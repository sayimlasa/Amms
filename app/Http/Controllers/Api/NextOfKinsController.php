<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NextOfKin;
use Illuminate\Http\Request;

class NextOfKinsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $nextOfKins = NextOfKin::with('nationalit','country','region','district','relationship')->where('applicant_user_id', $id)->first();

        return response()->json($nextOfKins, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'index_no' => 'required|string',
            'fname' => 'required|string',
            'mname' => 'nullable|string',
            'lname' => 'required|string',
            'mobile_no' => 'required|regex:/^0\d{9,14}$/',
            'nationality' => 'required|integer',
            'country_id' => 'required|integer|exists:countries,id',
            'region_id' => 'required|integer|exists:regions_states,id',
            'district_id' => 'required|integer|exists:districts,id',
            'physical_address' => 'required|string',
            'relationship_id' => 'required|exists:relationships,id',
            'applicant_user_id' => 'required|integer',
        ]);
    
        // Prepare data for creating or updating the Next of Kin record
        $nextOfKinData = [
            'applicant_user_id' => $validatedData['applicant_user_id'],
            'index_no' => $validatedData['index_no'],
            'fname' => $validatedData['fname'],
            'mname' => $validatedData['mname'],
            'lname' => $validatedData['lname'],
            'mobile_no' => $validatedData['mobile_no'],
            'nationality' => $validatedData['nationality'],
            'country_id' => $validatedData['country_id'],
            'region_id' => $validatedData['region_id'],
            'district_id' => $validatedData['district_id'],
            'physical_address' => $validatedData['physical_address'],
            'relationship_id' => $validatedData['relationship_id'],
        ];
    
        // Use `updateOrCreate` to update if exists or create a new record
        $nextOfKin = NextOfKin::updateOrCreate(
            [
                'applicant_user_id' => $validatedData['applicant_user_id'],
                'index_no' => $validatedData['index_no'],
            ],
            $nextOfKinData
        );
    
        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Next of Kin added successfully!',
            'data' => $nextOfKin,
        ], 201);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $nextOfKin = NextOfKin::find($id);

    if (!$nextOfKin) {
        return response()->json([
            'success' => false,
            'message' => 'Next of Kin not found.',
        ], 404);
    }

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

    return response()->json([
        'success' => true,
        'message' => 'Next of Kin updated successfully.',
        'data' => $nextOfKin,
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

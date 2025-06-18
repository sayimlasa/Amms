<?php

namespace App\Http\Controllers\Admissions\Applicants;

use App\Http\Controllers\Controller;
use App\Models\ApplicantsInfo;
use App\Models\Campus;
use App\Models\Country;
use App\Models\Disability;
use App\Models\District;
use App\Models\Employer;
use App\Models\EmploymentStatus;
use App\Models\Intake;
use App\Models\MaritalStatus;
use App\Models\Nationality;
use App\Models\RegionState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApplicantsInfosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applicantsInfos = ApplicantsInfo::whereHas('academicYear', function ($query) {
            $query->where('active', 1);
        })->get();

        return view('Admission.Applicants.applicants-infos.index', compact('applicantsInfos'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApplicantsInfo  $applicantsInfo
     * @return \Illuminate\Http\Response
     */
    public function show(ApplicantsInfo $applicantsInfo)
    {
        return view(
            'Admission.Applicants.applicants-infos.show',compact('applicantsInfo')
        );
    }
    public function edit(ApplicantsInfo $applicantsInfo)
    {
        $countries = Country::get();
        $regions = RegionState::get();
        $districts = District::get();
        $nationalities = Nationality::get();
        $maritalStatuses = MaritalStatus::get();
        $employmentStatuses = EmploymentStatus::get();
        $disabilities = Disability::get();
        $campuses = Campus::get();
        $intakes = Intake::where('active',1)->get();

        return view(
            'Admission.Applicants.applicants-infos.edit',
            compact(
                'applicantsInfo',
                'countries',
                'regions',
                'districts',
                'nationalities',
                'maritalStatuses',
                'employmentStatuses',
                'disabilities',
                'campuses',
                'intakes'
            )
        );
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

    // In your controller
public function getEmployersByStatus($employmentStatusId)
{
    // Fetch employers based on the employment status
    $employers = Employer::where('emp_status_id', $employmentStatusId)->get();

    // Return as JSON response
    return response()->json($employers);
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApplicantsInfo  $applicantsInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplicantsInfo $applicantsInfo)
    {
    
        // Validate the input data
        $validatedData = $request->validate([
            'mobile_no' => 'required|regex:/^0\d{9,14}$/', // Validation for mobile number
            'birth_date' => 'required|date',
            'nationality' => 'required|integer',
            'cob_id' => 'required|integer|exists:countries,id',
            'pob_id' => 'required|integer|exists:regions_states,id',
            'dob_id' => 'required|integer|exists:districts,id',
            'country_id' => 'required|integer|exists:countries,id',
            'region_id' => 'required|integer|exists:regions_states,id',
            'district_id' => 'required|integer|exists:districts,id',
            'physical_address' => 'required|string',
            'employment_status' => 'required|integer',
            'employer_id' => 'nullable|integer',
            'disability_id' => 'required|integer',
            'marital_status_id'=> 'required|integer|exists:marital_statuses,id'
        ]);
    
        // Update ApplicantsInfo model (all fields except mobile_no)
        $applicantsInfo->update([
            'birth_date' => $validatedData['birth_date'],
            'nationality' => $validatedData['nationality'],
            'cob_id' => $validatedData['cob_id'],
            'pob_id' => $validatedData['pob_id'],
            'dob_id' => $validatedData['dob_id'],
            'country_id' => $validatedData['country_id'],
            'region_id' => $validatedData['region_id'],
            'district_id' => $validatedData['district_id'],
            'physical_address' => $validatedData['physical_address'],
            'employment_status' => $validatedData['employment_status'],
            'employer_id' => $validatedData['employer_id'],
            'disability_id' => $validatedData['disability_id'],
            'marital_status_id' => $validatedData['marital_status_id'],
        ]);
    
        // Update ApplicantsUser model (mobile_no field)
        $applicantUser = $applicantsInfo->applicantUser;
        if ($applicantUser) {
            $applicantUser->update([
                'mobile_no' => $validatedData['mobile_no'],
            ]);
        }
    
        // Flash success message
        session()->flash('success', 'Profile Updated successfully!');
    
        // Redirect to index route
        return redirect()->route('applicants-infos.index');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApplicantsInfo  $applicantsInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicantsInfo $applicantsInfo)
    {
        //
    }
}

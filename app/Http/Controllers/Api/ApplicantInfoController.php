<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApplicantsInfo;
use App\Models\ApplicantsUser;
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
use App\Models\Relationship;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class ApplicantInfoController extends Controller
{
    public function applicantInfo(Request $request){
         // Get the authenticated user (assuming Sanctum for API token auth)
         $applicant = $request->user();

         // Retrieve user details
         $applicantInfos = ApplicantsUser::with('applicantInfo')->find($applicant->id);
 
         if (!$applicantInfos) {
             return response()->json([
                 'status' => 'error',
                 'message' => 'User not found',
             ], 404);
         }
 
         return response()->json([
             'status' => 'success',
             'message' => 'User details retrieved successfully',
             'data' => $applicantInfos,
         ]);
    }

    public function getEditData(ApplicantsInfo $applicantsInfo)
    {
        // Fetch all required data for editing applicants info
        $countries = Country::get();
        $regions = RegionState::get();
        $districts = District::get();
        $nationalities = Nationality::get();
        $maritalStatuses = MaritalStatus::get();
        $employmentStatuses = EmploymentStatus::get();
        $disabilities = Disability::get();
        $campuses = Campus::get();
        $intakes = Intake::where('active', 1)->get();
        $employers = Employer::get();

        // Return all data as JSON
        return response()->json([
            'applicantsInfo' => $applicantsInfo,
            'countries' => $countries,
            'regions' => $regions,
            'districts' => $districts,
            'nationalities' => $nationalities,
            'maritalStatuses' => $maritalStatuses,
            'employmentStatuses' => $employmentStatuses,
            'disabilities' => $disabilities,
            'campuses' => $campuses,
            'intakes' => $intakes,
            'employers' => $employers
        ]);
    }

    public function getRelationships()
    {
        // Fetch regions by the country_id
        $relationships = Relationship::get();

        // Return regions as a JSON response
        return response()->json($relationships);
    }
    public function getNationalities()
    {
        // Fetch regions by the country_id
        $nationalities = Nationality::get();

        // Return regions as a JSON response
        return response()->json($nationalities);
    }
    public function getCountries()
    {
        // Fetch regions by the country_id
        $countries = Country::get();

        // Return regions as a JSON response
        return response()->json($countries);
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
        // Fetch districts by the region_id
        $districts = District::where('region_state_id', $region_id)->get();

        // Return districts as a JSON response
        return response()->json($districts);
    }

    public function getEmployersByStatus($employmentStatusId)
    {
        // Fetch employers based on the employment status
        $employers = Employer::where('emp_status_id', $employmentStatusId)->get();

        // Return as JSON response
        return response()->json($employers);
    }

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

        // Return success response as JSON
        return response()->json([
            'message' => 'Profile updated successfully!',
            'applicantsInfo' => $applicantsInfo
        ], 200);
    }
}

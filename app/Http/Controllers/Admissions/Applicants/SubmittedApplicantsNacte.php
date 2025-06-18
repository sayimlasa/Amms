<?php

namespace App\Http\Controllers\Admissions\Applicants;

use Carbon\Carbon;
use App\Models\Campus;
use App\Models\Intake;
use App\Models\Programme;
use App\Models\Disability;
use App\Models\AcademicYear;
use App\Models\TamisemiList;
use Illuminate\Http\Request;
use App\Models\ProgrammeNacte;
use App\Models\ApplicationLevel;
use App\Models\ApplicationWindow;
use App\Models\VerificationNacte;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\SelectedDiplomaCertificate;

class SubmittedApplicantsNacte extends Controller
{

    public function indexArusha()
    {
        $indexNumbers = [];
        $apiResponses = [];
        // Step 3: Get the Application Level and Category IDs
        $level = ApplicationLevel::Where('name', 'LIKE', '%Certificate%')
            //->orWhere('name', 'LIKE', '%Diploma%')
            ->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        // Get the programme and category IDs related to the level
        $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();
        // Get the programme and category IDs related to the level
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->where('nta', $level->id)->get();
        return view('Admission.Applicants.nactevet.submitted-arusha', compact('programme', 'indexNumbers', 'apiResponses'));
    }
    // public function sendNacteArusha(Request $request)
    // {
    //     // Validate the incoming request
    //     $validatedData = $request->validate([
    //         'payment'       => 'required|string',
    //         'intake_id'     => 'required|string',
    //         'programme_id'  => 'required|integer',
    //     ]);

    //     $payment     = $validatedData['payment'];
    //     $intakeId    = $validatedData['intake_id'];
    //     $programmeId = $validatedData['programme_id'];

    //     // Fetch the Arusha Campus ID (adjust the query as needed)
    //     $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();

    //     // Fetch applicants based on the provided conditions
    //     $applicants = ProgrammeNacte::list()
    //         ->where('dip.campus_id', $arushaCampus)
    //         ->where('programme_nactes.campus_id', $arushaCampus)
    //         ->where('programme_nactes.iaa_program_id', $programmeId)
    //         ->where('dip.iaa_programme_code', $programmeId)
    //         ->where('dip.nacte_status', 0)
    //         ->get();

    //     // Check if applicants are available
    //     if ($applicants->isEmpty()) {
    //         return redirect()->route('submitted.arusha')->with('error', "No applicants found for the selected programme.");
    //     }

    //     $authorizationToken = 'd1906e33171c5de66b7a6bce9d669c21a3c5dac2';
    //     $indexNumbers = [];
    //     $apiResponses = [];

    //     foreach ($applicants as $applicant) {
    //         // Process the index number to get form four details
    //         $index = $applicant->index_no;  // Example format: S2993-0013-XXXX
    //         $parts = explode('-', $index);
    //         $firstPart  = $parts[0] . '/' . $parts[1];  // e.g., S2993/0013
    //         $secondPart = $parts[2];

    //         // Form six index number processing
    //         $index6 = $applicant->qualification_no; // Assuming it's "S0456-0003-2013"
    //         $partsindex = explode('-', $index6);
    //         if (count($partsindex) >= 3) {
    //             $firstPart6 = $partsindex[0] . '/' . $partsindex[1];
    //             $secondPart6 = $partsindex[2];
    //         } else {
    //             $firstPart6 = '';
    //             $secondPart6 = '';
    //         }

    //         // Format the date of birth using Carbon
    //         $formattedDob = Carbon::parse($applicant->dob)->format('d-m-Y');

    //         $data = [
    //             [
    //                 "heading" => [
    //                     "authorization" => $authorizationToken,
    //                     "intake" => $intakeId,
    //                     "programme_id" => $applicant->program_nacte_id,
    //                     "application_year" => "2021",
    //                     "level" => "4",
    //                     "payment_reference_number" => $payment
    //                 ],
    //                 "students" => [
    //                     [
    //                         "particulars" => [
    //                             "firstname" => $applicant->first_name,
    //                             "secondname" => $applicant->middle_name,
    //                             "surname" => $applicant->last_name,
    //                             "DOB" => $formattedDob,
    //                             "gender" => "Male",
    //                             "impairement" => $applicant->disability,
    //                             "form_four_indexnumber" => $firstPart,
    //                             "form_four_year" => $secondPart,
    //                             "form_six_indexnumber" => $firstPart6 ?? "",
    //                             "form_six_year" => $secondPart6 ?? "",
    //                             "NTA4_reg" => "",
    //                             "NTA4_grad_year" => "",
    //                             "NTA5_reg" => "",
    //                             "NTA5_grad_year" => "",
    //                             "email_address" => $applicant->email,
    //                             "mobile_number" => $applicant->mobile_no,
    //                             "address" => $applicant->physical_address,
    //                             "region" => $applicant->region,
    //                             "district" => $applicant->district,
    //                             "nationality" => $applicant->nationality,
    //                             "next_kin_name" => $applicant->next_kin_name,
    //                             "next_kin_address" => $applicant->next_kin_address ?? "",
    //                             "next_kin_email_address" => $applicant->next_kin_email ?? "",
    //                             "next_kin_phone" => $applicant->next_kin_phone,
    //                             "next_kin_region" => $applicant->next_kin_region,
    //                             "next_kin_relation" => $applicant->next_kin_relationship
    //                         ]
    //                     ]
    //                 ]
    //             ]
    //         ];

    //         Log::info("Sending data for applicant: " . $index);
    //         $curl = curl_init();

    //         curl_setopt_array($curl, [
    //             CURLOPT_URL => 'https://www.nacte.go.tz/nacteapi/index.php/api/upload',
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => '',
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 0,
    //             CURLOPT_FOLLOWLOCATION => true,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => 'POST',
    //             CURLOPT_POSTFIELDS => json_encode($data),
    //             CURLOPT_HTTPHEADER => [
    //                 'Accept: application/json',
    //                 'Content-Type: application/json'
    //             ],
    //         ]);

    //         $response = curl_exec($curl);
    //         $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    //         if ($response === false) {
    //             Log::error('cURL Error: ' . curl_error($curl));
    //         } else {
    //             if ($httpCode == 200) {
    //                 SelectedDiplomaCertificate::where('index_no', $applicant->index_no)
    //                     ->where('nacte_status', 0)
    //                     ->update(['nacte_status' => 0]);

    //                 $indexNumbers[] = $index; // Append index to array
    //                 $decodedResponse = json_decode($response);
    //                 $apiResponses[] = $decodedResponse->message; // Append response message to array

    //                 Log::info("API response for $index: " . $decodedResponse->message);
    //             }

    //             curl_close($curl);
    //         }
    //     }

    //     // Store the response data in the session and redirect
    //     return redirect()->route('submitted.arusha')->with([
    //         'indexNumbers' => $indexNumbers,
    //         'apiResponses' => $apiResponses
    //     ]);
    // }
    public function sendNacteArusha(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'payment'       => 'required|string',
            'intake_id'     => 'required|string',
            'programme_id'  => 'required|integer',
        ]);

        $payment     = $validatedData['payment'];
        $intakeId    = $validatedData['intake_id'];
        $programmeId = $validatedData['programme_id'];

        // Fetch the Arusha Campus ID (adjust the query as needed)
        $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();

        // Fetch applicants based on the provided conditions
        $applicants = ProgrammeNacte::list()
            ->where('dip.campus_id', $arushaCampus)
            ->where('programme_nactes.campus_id', $arushaCampus)
            ->where('programme_nactes.iaa_program_id', $programmeId)
            ->where('dip.iaa_programme_code', $programmeId)
            ->where('dip.nacte_status', 0)
            ->get();

        // Check if applicants are available
        if ($applicants->isEmpty()) {
            return redirect()->route('submitted.arusha')->with('error', "No applicants found for the selected programme.");
        }

        $authorizationToken = 'd1906e33171c5de66b7a6bce9d669c21a3c5dac2';
        $indexNumbers = [];
        $apiResponses = [];

        foreach ($applicants as $applicant) {
            // Process the index number to get form four details
            $index = $applicant->index_no;  // Example format: S2993-0023-2004, P2993-0023-2004, or EQ2019000863-2012

            // Process the index number
            $indexParts = $this->processIndex($index);
            $firstPart  = $indexParts['firstPart'];
            $secondPart = $indexParts['secondPart'];

            // Process the qualification number in a similar manner
            $index6 = $applicant->qualification_no; // Example format: S0456-0003-2013
            $indexParts6 = $this->processIndex($index6);
            $firstPart6 = $indexParts6['firstPart'];
            $secondPart6 = $indexParts6['secondPart'];

            // Format the date of birth using Carbon
            $formattedDob = Carbon::parse($applicant->dob)->format('d-m-Y');

            $data = [
                [
                    "heading" => [
                        "authorization" => $authorizationToken,
                        "intake" => $intakeId,
                        "programme_id" => $applicant->program_nacte_id,
                        "application_year" => "2021",
                        "level" => "4",
                        "payment_reference_number" => $payment
                    ],
                    "students" => [
                        [
                            "particulars" => [
                                "firstname" => $applicant->first_name,
                                "secondname" => $applicant->middle_name,
                                "surname" => $applicant->last_name,
                                "DOB" => $formattedDob,
                                "gender" => "Male",
                                "impairement" => $applicant->disability,
                                "form_four_indexnumber" => $firstPart,
                                "form_four_year" => $secondPart,
                                "form_six_indexnumber" => $firstPart6 ?? "",
                                "form_six_year" => $secondPart6 ?? "",
                                "NTA4_reg" => "",
                                "NTA4_grad_year" => "",
                                "NTA5_reg" => "",
                                "NTA5_grad_year" => "",
                                "email_address" => $applicant->email,
                                "mobile_number" => $applicant->mobile_no,
                                "address" => $applicant->physical_address,
                                "region" => $applicant->region,
                                "district" => $applicant->district,
                                "nationality" => $applicant->nationality,
                                "next_kin_name" => $applicant->next_kin_name,
                                "next_kin_address" => $applicant->next_kin_address ?? "",
                                "next_kin_email_address" => $applicant->next_kin_email ?? "",
                                "next_kin_phone" => $applicant->next_kin_phone,
                                "next_kin_region" => $applicant->next_kin_region,
                                "next_kin_relation" => $applicant->next_kin_relationship
                            ]
                        ]
                    ]
                ]
            ];

            Log::info("Sending data for applicant: " . $index);
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://www.nacte.go.tz/nacteapi/index.php/api/upload',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json',
                    'Content-Type: application/json'
                ],
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($response === false) {
                Log::error('cURL Error: ' . curl_error($curl));
            } else {
                if ($httpCode == 200) {
                    SelectedDiplomaCertificate::where('index_no', $applicant->index_no)
                        ->where('nacte_status', 0)
                        ->update(['nacte_status' => 1]);

                    $indexNumbers[] = $index; // Append index to array
                    $decodedResponse = json_decode($response);
                    $apiResponses[] = $decodedResponse->message; // Append response message to array

                    Log::info("API response for $index: " . $decodedResponse->message);
                }

                curl_close($curl);
            }
        }

        // Store the response data in the session and redirect
        return redirect()->route('submitted.arusha')->with([
            'indexNumbers' => $indexNumbers,
            'apiResponses' => $apiResponses
        ]);
    }

    /**
     * Process the index number to handle both formats (S2993-0023-2004, P2993-0023-2004, EQ2019000863-2012)
     */
    private function processIndex($index)
    {
        // Initialize variables for the parts
        $firstPart = '';
        $secondPart = '';

        // Check if the index contains a hyphen
        if (strpos($index, '-') !== false) {
            // Split by the hyphen if present
            $parts = explode('-', $index);

            // Check if it's in the EQ format (e.g., EQ2019000863-2012)
            if (strlen($parts[0]) > 2 && substr($parts[0], 0, 2) === 'EQ' && strlen($parts[1]) == 4) {
                // If it's the EQ2019000863-2012 format, separate accordingly
                $firstPart = $parts[0];  // EQ2019000863
                $secondPart = $parts[1];  // 2012
            } elseif (in_array(substr($parts[0], 0, 1), ['S', 'P'])) {
                // For 'S2993-0023-2004' or 'P2993-0023-2004' format
                $firstPart = $parts[0] . '/' . $parts[1];  // e.g., S2993/0023 or P2993/0023
                $secondPart = $parts[2];  // e.g., 2004
            }
        } else {
            // Handle other formats if necessary (e.g., EQ2019000863-2012)
            $firstPart = substr($index, 0, 2) . '/' . substr($index, 2, 7);  // e.g., EQ/2019000
            $secondPart = substr($index, 9);  // e.g., 0863 or similar
        }

        return [
            'firstPart' => $firstPart,
            'secondPart' => $secondPart
        ];
    }

    //ARUSHA CAMPUS
    public function tamisemiArusha(Request $request)
    {
        // Step 1: Get the Application Level and Category IDs
        $level = ApplicationLevel::Where('name', 'LIKE', 'Certificate%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $data = [];
        return view('Admission.Applicants.nactevet.tamisemilist-arusha', compact('programme', 'data'));
    }
    public function tamisemiListArushaStore(Request $request)
    {
        // Step 3: Get the Application Level and Category IDs
        $level = ApplicationLevel::Where('name', 'LIKE', 'Certificate%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');

        $iaacode = ProgrammeNacte::where('program_id', $programId)->pluck('iaa_program_id')->first();

        $apiUrl = "nacte.go.tz/nacteapi/index.php/api/tamisemiconfirmedlist/{$programId}-{$year}-september/XY89819ad63b2247.c8ef6d46f9eca442a0d097e1f2c3ca5ec9689d42dfa357ef8d25bbcb0a3e2291.cbc146eaba5b985bab19c5a487c69cf518575bd8";
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);
        if (!isset($data['params']) || empty($data['params'])) {
            Log::error('No valid data found in API response.');
            return redirect()->back()->withErrors('No data found in API response.');
        }

        // Step 8: Process the API Data
        foreach ($data['params'] as $item) {
            $academicYear = AcademicYear::where('active', 1)->first();
            $intakes = Intake::where('active', 1)->first();
            $window = ApplicationWindow::where('active', 1)->first();

            Log::info('Campus Id: ' . $arushaCampus);

            if (empty($iaacode) || empty($intakes->id) || empty($academicYear->id) || empty($window->id)) {
                Log::error('Invalid foreign key values for username: ' . $item['username']);
                continue;
            }

            // Step 12: Save or Update the Verification Data
            $savedRecord = TamisemiList::updateOrCreate(
                ['username' => $item['username']],
                [
                    'fullname' => $item['fullname'],
                    'application_year' => $item['application_year'],
                    'programe_name' => $item['programe_name'],
                    'institution_name' => $item['institution_name'],
                    'phone_number' => $item['phone_number'],
                    'email' => $item['email'],
                    'address' => $item['address'],
                    'district' => $item['district'],
                    'region' => $item['region'],
                    'Next_of_kin_fullname' => $item['Next_of_kin_fullname'],
                    'Next_of_kin_phone_number' => $item['Next_of_kin_phone_number'],
                    'Next_of_kin_email' => $item['Next_of_kin_email'],
                    'Next_of_kin_address' => $item['Next_of_kin_address'],
                    'Next_of_kin_region' => $item['Next_of_kin_region'],
                    'relationship' => $item['relationship'],
                    'sex' => $item['sex'],
                    // 'date_of_birth' => $item['date_of_birth'],
                    'date_of_birth' => \Carbon\Carbon::createFromFormat('d-m-Y', $item['date_of_birth'])->format('Y-m-d'),
                    'intake_id' => $intakes->id,
                    'academic_year_id' => $academicYear->id,
                    'window_id' => $window->id,
                    'programme_id' => $iaacode,
                    'campus_id' => $arushaCampus,
                ]
            );

            Log::info('Saved or updated record for username: ' . $item['username'], [
                'saved_record' => $savedRecord
            ]);
        }
        Log::info('Decoded Data:', ['data' => $data]);

        // Redirect to the tamisemi.arusha route
        return redirect()->route('tamisemi.arusha')->with(['data' => $data, 'programme' => $programme]);
    }

    public function verification(Request $request)
    {
        // Step 1: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')->orWhere('name', 'LIKE', 'Basic Technician%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $data = [];
        // Step 13: Return the View with the Programme and Data
        return view('Admission.Applicants.nactevet.verification-arusha', compact('programme', 'data'));
    }
    public function storeVerifiedApplicantArusha(Request $request)
    {

        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();

        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        // Step 4: Get Inputs from the Request
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');
        // Step 6: Prepare the API URL
        $apiUrl = "https://www.nacte.go.tz/nacteapi/index.php/api/verificationresults/{$programId}-{$year}-{$intake}/tu3ea571cb59c0ac.42dbe0aa9d42c20903e94cbf27ec6d8fa2d95b86119c73b9a5a2cfce7f36d1a5.a977360cbacc8b46ab2e1baa39bdb75d2d87ebdd";

        // Step 7: Make API Request
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the response
        $data = json_decode($response, true);

        // Check if 'params' exists and contains data
        if (!isset($data['params']) || empty($data['params'])) {
            Log::error('No valid data found in API response.');
            return redirect()->back()->withErrors('No data found in API response.');
        }

        // Step 8: Process the API Data
        foreach ($data['params'] as $item) {
            // Step 9: Fetch Necessary Data
            $academicYear = AcademicYear::where('active', 1)->first();
            $intakes = Intake::where('active', 1)->first();
            $window = ApplicationWindow::where('active', 1)->first();
            // Step 5: Get the IAA code (programme_id)
            $iaacode = ProgrammeNacte::where('program_id', $programId)->pluck('iaa_program_id')->first();


            // Log eligibility to check if it matches the expected value
            Log::info('Eligibility: ' . $item['eligibility']);

            // Check eligibility and set status accordingly
            $status = (isset($item['eligibility']) && strtolower(trim($item['eligibility'])) === "eligible") ? 1 : 0;

            // Log the status to verify it's being set correctly
            Log::info('programme: ' . $iaacode);  // This should log "1" if the eligibility is "Eligible"

            // Step 10: Validate the item before saving
            $validator = Validator::make($item, [
                'username' => 'required|unique:verification_nactes,username',
                'user_id' => 'required|unique:verification_nactes,user_id',
                'verification_status' => 'required',
                'multiple_selection' => 'required',
                'academic_year' => 'required',
                'intake' => 'required',
                'eligibility' => 'required',
                'remarks' => 'required',
            ]);

            if ($validator->fails()) {
                // If validation fails, log the error and skip this item
                Log::error('Validation failed for username: ' . $item['username']);
                Log::error('Validation errors: ' . json_encode($validator->errors()->all()));
                continue;
            }

            // Log the data being saved to ensure it's correct
            Log::info('Saving/updating verification data', [
                'username' => $item['username'],
                'user_id' => $item['user_id'],
                'programme_id' => $iaacode, // Check if this is correct
                'eligibility' => $item['eligibility'],
                'status' => $status,
            ]);

            // Step 11: Check if Foreign Keys are valid
            if (empty($iaacode) || empty($intakes->id) || empty($academicYear->id) || empty($window->id)) {
                Log::error('Invalid foreign key values for username: ' . $item['username']);
                continue;
            }

            // Step 12: Save or Update the Verification Data
            $savedRecord = VerificationNacte::updateOrCreate(
                [
                    'username' => $item['username'],
                    'user_id' => $item['user_id'],
                ],
                [
                    'verification_status' => $item['verification_status'],
                    'multiple_selection' => $item['multiple_selection'],
                    'academic_year' => $item['academic_year'],
                    'intake' => $item['intake'],
                    'eligibility' => $item['eligibility'],
                    'remarks' => $item['remarks'],
                    'status' => $status, // Save 1 if Eligible, else 0
                    'intake_id' => $intakes->id,
                    'academic_year_id' => $academicYear->id,
                    'window_id' => $window->id,
                    'programme_id' => $iaacode,
                    'campus_id' => $arushaCampus,
                    'intake_id' => $intakes->id
                ]
            );

            // Log the result of the save/update operation
            Log::info('Saved or updated record for username: ' . $item['username'], [
                'saved_record' => $savedRecord
            ]);
        }

        // Step 13: Return the View with the Programme and Data
        return redirect()->route('verification.arusha')->with(['data' => $data, 'programme' => $programme]);
    }
    //get pushed blist applicant
    public function pushedListArusha()
    {
        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $data = [];
        // Step 13: Return the View with the Programme and Data
        return view('Admission.Applicants.nactevet.getpushed-arusha', compact('programme', 'data'));
    }
    public function displaypushedlist(Request $request)
    {
        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        // Step 4: Get Inputs from the Request
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');
        // Step 6: Prepare the API URL
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/pushedlist/{$programId}-{$year}-{$intake}/XYdebf7b25553766.be6505a5249505830b920c141bde8a1cab1edaac39c86256f45add270e1dd46e.e62e648f142b31bdc173d57f2f9a261a7642d7f0";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the JSON response into an array
        $decodedData = json_decode($response, true);

        // Log the response (Optional for debugging)
        Log::info('Api response' . $response);
        // Step 7: Pass the decoded data to the view
        return redirect()->route('getpushedlist.arusha')->with('data', $decodedData['params'] ?? []);
    }
    //check payment Balance
    public function checkBalanceArusha()
    {
        $balance = '';
        return view('Admission.Applicants.nactevet.payment-arusha', compact('balance'));
    }
    public function displayBalanceArusha(Request $request)
    {
        $payment = $request->input('payment');
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/payment/{$payment}/yzd469cbcfc4ccbc.02c683830abfefc84de3f7362094987d4faae062416888bc59925a952bb5100e.f589e8dddff3709f4425b274798fc0f88f0856ca";

        // Initialize CURL request to fetch the data
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);
        // Execute the request
        $response = curl_exec($curl);
        curl_close($curl);
        // Decode the JSON response into an array
        $decodedData = json_decode($response, true);
        // Log API response for debugging purposes
        Log::info('Api response: ' . $response);
        // Extract the balance from the response
        $balance = $decodedData['params'][0]['balance'] ?? null;
        // Redirect to the payment page and pass the balance to the view
        return redirect()->route('payment.arusha')->with('balance', $balance);
    }





    //BABATI CAMPUS
    public function indexBabati()
    {
        $indexNumbers = [];
        $apiResponses = [];
        // Step 3: Get the Application Level and Category IDs
        $level = ApplicationLevel::Where('name', 'LIKE', '%Certificate%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        $babatiCampus = Campus::where('name', 'like', '%babati%')->pluck('id')->first();
        // Get the programme and category IDs related to the level
        $programme = ProgrammeNacte::where('campus_id', $babatiCampus)->where('nta', $level->id)->get();
        return view('Admission.Applicants.nactevet.submitted-babati', compact('programme', 'indexNumbers', 'apiResponses'));
    }

    public function sendNacteBabati(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'payment'       => 'required|string',
            'intake_id'     => 'required|string',
            'programme_id'  => 'required|integer',
        ]);
        $payment     = $validatedData['payment'];
        $intakeId    = $validatedData['intake_id'];
        $programmeId = $validatedData['programme_id'];

        // Fetch the Arusha Campus ID (adjust the query as needed)
        $arushaCampus = Campus::where('name', 'like', '%babati%')->pluck('id')->first();

        // Fetch applicants based on the provided conditions
        $applicants = ProgrammeNacte::list()
            ->where('dip.campus_id', $arushaCampus)
            ->where('programme_nactes.campus_id', $arushaCampus)
            ->where('programme_nactes.iaa_program_id', $programmeId)
            ->where('dip.iaa_programme_code', $programmeId)
            ->where('dip.nacte_status', 0)
            ->get();
        //check if applicants available
        if (!$applicants) {
            return redirect()->route('submitted.babati')->with('error', "applicants not exist the programme");
        }
        $authorizationToken = '7e047b8d2e16cea0ab2cd08db5a7489e95545f4e';
        $indexNumbers = [];
        $apiResponses = [];
        foreach ($applicants as $applicant) {
            // Process the index number to get form four details
            $index = $applicant->index_no;  // Example format: S2993-0013-XXXX
            $parts = explode('-', $index);
            // Combine the first two parts with a slash and get the third part separately
            $firstPart  = $parts[0] . '/' . $parts[1];  // e.g., S2993/0013
            $secondPart = $parts[2];
            $index6 = $applicant->qualification_no; // Assuming it's "S0456-0003-2013"
            // Split the string by '-'
            $partsindex = explode('-', $index6);
            // Check if there are at least 3 parts
            if (count($partsindex) >= 3) {
                // Format the first part as S0456/0003
                $firstPart6 = $partsindex[0] . '/' . $partsindex[1];
                // Get the second part as 2013
                $secondPart6 = $partsindex[2];
            } else {
                // Handle error if the format is incorrect
                $firstPart6 = '';
                $secondPart6 = '';
            }
            // Format the date of birth using Carbon
            $formattedDob = Carbon::parse($applicant->dob)->format('d-m-Y');

            $data = [
                [
                    "heading" => [
                        "authorization" => $authorizationToken,
                        "intake" => $intakeId,
                        "programme_id" => $applicant->program_nacte_id,
                        "application_year" => "2021",
                        "level" => "4",
                        "payment_reference_number" => $payment
                    ],
                    "students" => [
                        [
                            "particulars" => [
                                "firstname" => $applicant->first_name,
                                "secondname" => $applicant->middle_name,
                                "surname" => $applicant->last_name,
                                "DOB" => $formattedDob,
                                "gender" => "Male",
                                "impairement" => $applicant->disability,
                                "form_four_indexnumber" => $firstPart,
                                "form_four_year" => $secondPart,
                                "form_six_indexnumber" => $applicant->$firstPart6 ?? "",
                                "form_six_year" => $applicant->$secondPart6 ?? "",
                                "NTA4_reg" => "",
                                "NTA4_grad_year" => "",
                                "NTA5_reg" => "",
                                "NTA5_grad_year" => "",
                                "email_address" => $applicant->email,
                                "mobile_number" => $applicant->mobile_no,
                                "address" => $applicant->physical_address,
                                "region" => $applicant->region,
                                "district" => $applicant->district,
                                "nationality" => $applicant->nationality,
                                "next_kin_name" => $applicant->next_kin_name,
                                "next_kin_address" => $applicant->next_kin_address ?? "",
                                "next_kin_email_address" => $applicant->next_kin_email ?? "",
                                "next_kin_phone" => $applicant->next_kin_phone,
                                "next_kin_region" => $applicant->next_kin_region,
                                "next_kin_relation" => $applicant->next_kin_relationship
                            ]
                        ]
                    ]
                ]
            ];

            // print_r($data);
            // die();
            Log::info("total data: " . print_r($data, true));
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://www.nacte.go.tz/nacteapi/index.php/api/upload',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json',
                    'Content-Type: application/json'
                ],
            ]);

            $response = curl_exec($curl);
            //print_r($response);die();
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($response === false) {
                echo 'cURL Error: ' . curl_error($curl);
            } else {
                if ($httpCode == 200) {
                    SelectedDiplomaCertificate::where('index_no', $applicant->index_no)
                        ->where('nacte_status', 0)
                        ->update(['nacte_status' => 1]);
                    $indexNumbers = $index;
                    $decodedResponse = json_decode($response);
                    $apiResponses = $decodedResponse->message;
                    Log::info("Api response " . $indexNumbers);
                    Log::info("Api response " . $apiResponses);
                    // Ensure the data is an array before passing to session
                }

                curl_close($curl);
            }
        }
        return redirect()->route('submitted.babati')->with([
            'indexNumbers' => $indexNumbers,
            'apiResponses' => $apiResponses
        ]);
    }
    public function tamisemiListBabati(Request $request)
    {
        // Step 1: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')->orWhere('name', 'LIKE', 'Certificate%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%babati%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $data = null;
        return view('Admission.Applicants.nactevet.tamisemilist-arusha', compact('programme', 'data'));
    }
    public function tamisemiListBabatiStore(Request $request)
    {
        // Step 3: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')->orWhere('name', 'LIKE', 'Basic Technician%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        $arushaCampus = Campus::where('name', 'like', '%babati%')->pluck('id')->first();
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');

        $iaacode = ProgrammeNacte::where('program_id', $programId)->pluck('iaa_program_id')->first();

        $apiUrl = "nacte.go.tz/nacteapi/index.php/api/tamisemiconfirmedlist/{$programId}-{$year}-september/xycb3776f8cec039.afc9954f62bc2779e878a6bf0c79b489a76ae1cf4a92112e890999d0a182b006.5afaae34df52bcafe661a4eb555d7c3543b8d4a6";
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);
        if (!isset($data['params']) || empty($data['params'])) {
            Log::error('No valid data found in API response.');
            return redirect()->back()->withErrors('No data found in API response.');
        }

        // Step 8: Process the API Data
        foreach ($data['params'] as $item) {
            $academicYear = AcademicYear::where('active', 1)->first();
            $intakes = Intake::where('active', 1)->first();
            $window = ApplicationWindow::where('active', 1)->first();

            Log::info('Eligibility Status: ' . $arushaCampus);

            // Step 10: Validate the item before saving
            $validator = Validator::make($item, [
                'username' => 'required|unique:tamisemi_lists,username',
                'programme_name' => 'required',
                'fullname' => 'required',
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed for username: ' . $item['username']);
                Log::error('Validation errors: ' . json_encode($validator->errors()->all()));
                continue;
            }

            Log::info('Saving/updating verification data', [
                'username' => $item['username'],
                'fullname' => $item['fullname'],
                'programme_id' => $iaacode,
            ]);

            if (empty($iaacode) || empty($intakes->id) || empty($academicYear->id) || empty($window->id)) {
                Log::error('Invalid foreign key values for username: ' . $item['username']);
                continue;
            }

           
           $normalizedUsername = str_replace('/', '-', $item['username']);
            // Step 12: Save or Update the Verification Data
            $savedRecord = TamisemiList::updateOrCreate(
                    ['username' => $normalizedUsername],
                [
                    'fullname' => $item['fullname'],
                    'appplication_year' => $item['appplication_year'],
                    'programe_name' => $item['programe_name'],
                    'institution_name' => $item['institution_name'],
                    'phone_number' => $item['phone_number'],
                    'email' => $item['email'],
                    'address' => $item['address'],
                    'district' => $item['district'],
                    'region' => $item['region'],
                    'Next_of_kin_fullname' => $item['Next_of_kin_fullname'],
                    'Next_of_kin_phone_number' => $item['Next_of_kin_phone_number'],
                    'Next_of_kin_email' => $item['Next_of_kin_email'],
                    'Next_of_kin_address' => $item['Next_of_kin_address'],
                    'Next_of_kin_region' => $item['Next_of_kin_region'],
                    'relationship' => $item['relationship'],
                    'sex' => $item['sex'],
                    'date_of_birth' => $item['date_of_birth'],
                    'intake_id' => $intakes->id,
                    'academic_year_id' => $academicYear->id,
                    'window_id' => $window->id,
                    'programme_id' => $iaacode,
                    'campus_id' => $arushaCampus,
                ]
            );

            Log::info('Saved or updated record for username: ' . $item['username'], [
                'saved_record' => $savedRecord
            ]);
        }
        Log::info('Decoded Data:', ['data' => $data]);

        // Redirect to the tamisemi.arusha route
        return redirect()->route('tamisemi.babati')->with(['data' => $data, 'programme' => $programme]);
    }
    public function verificationBabati(Request $request)
    {
        // Step 1: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')->orWhere('name', 'LIKE', 'Basic Technician%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%babati%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $data = null;
        // Step 13: Return the View with the Programme and Data
        return view('Admission.Applicants.nactevet.verification-babati', compact('programme', 'data'));
    }
    public function storeVerifiedApplicantBabati(Request $request)
    {
        // Step 1: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')
            ->orWhere('name', 'LIKE', 'Basic Technician%')->first();

        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }

        // Step 2: Get the Babati Campus ID
        $babatiCampus = Campus::where('name', 'like', '%babati%')->pluck('id')->first();

        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $babatiCampus)->orderBy('id', 'desc')->get();

        // Step 4: Get Inputs from the Request
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');

        // Step 5: Get the IAA code (programme_id)
        $iaacode = ProgrammeNacte::where('program_id', $programId)->pluck('iaa_program_id')->first();
        Log::info("applicants users " . $iaacode);
        // Step 6: Prepare the API URL
        $apiUrl = "https://www.nacte.go.tz/nacteapi/index.php/api/verificationresults/{$programId}-{$year}-{$intake}/staa3eaadaf07278.8172bde24e7b89cd248d99679e7881eab7c085f4b04c396d49a892c88fa9f010.f342bd6935d2bc942b50e297430738fb4ea72b06";

        // Step 7: Make API Request
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the response
        $data = json_decode($response, true);

        // Check if 'params' exists and contains data
        if (!isset($data['params']) || empty($data['params'])) {
            Log::error('No valid data found in API response.');
            return redirect()->back()->withErrors('No data found in API response.');
        }

        // Step 8: Process the API Data
        foreach ($data['params'] as $item) {
            // Step 9: Fetch Necessary Data
            $academicYear = AcademicYear::where('active', 1)->first();
            $intakes = Intake::where('active', 1)->first();
            $window = ApplicationWindow::where('active', 1)->first();

            // Log eligibility to check if it matches the expected value
            Log::info('Eligibility: ' . $item['eligibility']);

            // Check eligibility and set status accordingly
            $status = (isset($item['eligibility']) && strtolower(trim($item['eligibility'])) === "eligible") ? 1 : 0;

            // Log the status to verify it's being set correctly
            Log::info('Eligibility Status: ' . $babatiCampus);  // This should log "1" if the eligibility is "Eligible"

            // Step 10: Validate the item before saving
            $validator = Validator::make($item, [
                'username' => 'required|unique:verification_nactes,username',
                'user_id' => 'required|unique:verification_nactes,user_id',
                'verification_status' => 'required',
                'multiple_selection' => 'required',
                'academic_year' => 'required',
                'intake' => 'required',
                'eligibility' => 'required',
                'remarks' => 'required',
            ]);

            if ($validator->fails()) {
                // If validation fails, log the error and skip this item
                Log::error('Validation failed for username: ' . $item['username']);
                Log::error('Validation errors: ' . json_encode($validator->errors()->all()));
                continue;
            }

            // Log the data being saved to ensure it's correct
            Log::info('Saving/updating verification data', [
                'username' => $item['username'],
                'user_id' => $item['user_id'],
                'programme_id' => $iaacode, // Check if this is correct
                'eligibility' => $item['eligibility'],
                'campus_id' => $babatiCampus,
                'status' => $status,
            ]);

            // Step 11: Check if Foreign Keys are valid
            if (empty($iaacode) || empty($intakes->id) || empty($academicYear->id) || empty($window->id)) {
                Log::error('Invalid foreign key values for username: ' . $item['username']);
                continue;
            }
            $index_id  = str_replace('/', '_', $item['username']);
            // Step 12: Save or Update the Verification Data
            $savedRecord = VerificationNacte::updateOrCreate(
                [
                    'username' => $index_id,
                    'user_id' => $item['user_id'],
                ],
                [
                    'verification_status' => $item['verification_status'],
                    'multiple_selection' => $item['multiple_selection'],
                    'academic_year' => $item['academic_year'],
                    'intake' => $item['intake'],
                    'eligibility' => $item['eligibility'],
                    'remarks' => $item['remarks'],
                    'status' => $status, // Save 1 if Eligible, else 0
                    'intake_id' => $intakes->id,
                    'academic_year_id' => $academicYear->id,
                    'window_id' => $window->id,
                    'programme_id' => $iaacode,
                    'campus_id' => $babatiCampus,
                    'intake_id' => $intakes->id
                ]
            );

            // Log the result of the save/update operation
            Log::info('Saved or updated record for username: ' . $item['username'], [
                'saved_record' => $savedRecord
            ]);
        }

        // Step 13: Return the View with the Programme and Data
        return redirect()->route('verification.babati')->with(['data' => $data, 'programme' => $programme]);
    }
    //get pushed blist applicant
    public function pushedListBabati()
    {
        // Step 2: Get the Babati Campus ID
        $babatiCampus = Campus::where('name', 'like', '%babati%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $babatiCampus)->orderBy('id', 'desc')->get();
        $data = [];
        // Step 13: Return the View with the Programme and Data
        return view('Admission.Applicants.nactevet.getpushed-babati', compact('programme', 'data'));
    }
    public function displaypushedlistBabati(Request $request)
    {
        // Step 2: Get the Babati Campus ID
        $babatiCampus = Campus::where('name', 'like', '%babati%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $babatiCampus)->orderBy('id', 'desc')->get();
        // Step 4: Get Inputs from the Request
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');
        // Step 6: Prepare the API URL
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/pushedlist/{$programId}-{$year}-{$intake}/stf988ec0222209c.94f228d0a74cf7a7bf390c683fa4c8e6fd3f4e20d95e30a10e0740762687a8e5.f00945327982eb1e767d92b7dc8a9ec4b9350898";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the JSON response into an array
        $decodedData = json_decode($response, true);

        // Log the response (Optional for debugging)
        Log::info('Api response' . $response);
        // Step 7: Pass the decoded data to the view
        return redirect()->route('getpushedlist.babati')->with('data', $decodedData['params'] ?? []);
    }
    //check payment Balance
    public function checkBalanceBabati()
    {
        $balance = '';
        return view('Admission.Applicants.nactevet.payment-babati', compact('balance'));
    }
    public function displayBalanceBabati(Request $request)
    {
        $payment = $request->input('payment');
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/payment/{$payment}/XYfc000a6ff9e802.214776bc047415d69009d88172968636c29facbe0a3b00839ba2a4922642d301.09d94424234026d7d15553b68edc1b283efaedec";

        // Initialize CURL request to fetch the data
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);
        // Execute the request
        $response = curl_exec($curl);
        curl_close($curl);
        // Decode the JSON response into an array
        $decodedData = json_decode($response, true);
        // Log API response for debugging purposes
        Log::info('Api response: ' . $response);
        // Extract the balance from the response
        $balance = $decodedData['params'][0]['balance'] ?? null;
        // Redirect to the payment page and pass the balance to the view
        return redirect()->route('payment.babati')->with('balance', $balance);
    }



    //DAR CAMPUS
    public function indexDar()
    {
        $indexNumbers = [];
        $apiResponses = [];
        // Step 3: Get the Application Level and Category IDs
        $level = ApplicationLevel::Where('name', 'LIKE', '%Certificate%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        $darCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();
        // Get the programme and category IDs related to the level
        $programme = ProgrammeNacte::where('campus_id', $darCampus)->where('nta', $level->id)->get();
        return view('Admission.Applicants.nactevet.submitted-dar', compact('programme', 'indexNumbers', 'apiResponses'));
    }

    public function sendNacteDar(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'payment'       => 'required|string',
            'intake_id'     => 'required|string',
            'programme_id'  => 'required|integer',
        ]);
        $payment     = $validatedData['payment'];
        $intakeId    = $validatedData['intake_id'];
        $programmeId = $validatedData['programme_id'];

        // Fetch the Arusha Campus ID (adjust the query as needed)
        $arushaCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();

        // Fetch applicants based on the provided conditions
        $applicants = ProgrammeNacte::list()
            ->where('dip.campus_id', $arushaCampus)
            ->where('programme_nactes.campus_id', $arushaCampus)
            ->where('programme_nactes.iaa_program_id', $programmeId)
            ->where('dip.iaa_programme_code', $programmeId)
            ->where('dip.nacte_status', 0)
            ->get();
        //check if applicants available
        Log::info("applicants dar" . $applicants);
        if (!$applicants) {
            return redirect()->route('submitted.dar')->with('error', "applicants not exist the programme");
        }
        $authorizationToken = '62e963ea36413b1b3713f247cc2ec068d9adc072';
        $indexNumbers = [];
        $apiResponses = [];
        foreach ($applicants as $applicant) {
            // Process the index number to get form four details
            $index = $applicant->index_no;  // Example format: S2993-0013-XXXX
            $parts = explode('-', $index);
            // Combine the first two parts with a slash and get the third part separately
            $firstPart  = $parts[0] . '/' . $parts[1];  // e.g., S2993/0013
            $secondPart = $parts[2];
            $index6 = $applicant->qualification_no; // Assuming it's "S0456-0003-2013"
            // Split the string by '-'
            $partsindex = explode('-', $index6);
            // Check if there are at least 3 parts
            if (count($partsindex) >= 3) {
                // Format the first part as S0456/0003
                $firstPart6 = $partsindex[0] . '/' . $partsindex[1];
                // Get the second part as 2013
                $secondPart6 = $partsindex[2];
            } else {
                // Handle error if the format is incorrect
                $firstPart6 = '';
                $secondPart6 = '';
            }
            // Format the date of birth using Carbon
            $formattedDob = Carbon::parse($applicant->dob)->format('d-m-Y');

            $data = [
                [
                    "heading" => [
                        "authorization" => $authorizationToken,
                        "intake" => $intakeId,
                        "programme_id" => $applicant->program_nacte_id,
                        "application_year" => "2021",
                        "level" => "4",
                        "payment_reference_number" => $payment
                    ],
                    "students" => [
                        [
                            "particulars" => [
                                "firstname" => $applicant->first_name,
                                "secondname" => $applicant->middle_name,
                                "surname" => $applicant->last_name,
                                "DOB" => $formattedDob,
                                "gender" => "Male",
                                "impairement" => $applicant->disability,
                                "form_four_indexnumber" => $firstPart,
                                "form_four_year" => $secondPart,
                                "form_six_indexnumber" => $applicant->$firstPart6 ?? "",
                                "form_six_year" => $applicant->$secondPart6 ?? "",
                                "NTA4_reg" => "",
                                "NTA4_grad_year" => "",
                                "NTA5_reg" => "",
                                "NTA5_grad_year" => "",
                                "email_address" => $applicant->email,
                                "mobile_number" => $applicant->mobile_no,
                                "address" => $applicant->physical_address,
                                "region" => $applicant->region,
                                "district" => $applicant->district,
                                "nationality" => $applicant->nationality,
                                "next_kin_name" => $applicant->next_kin_name,
                                "next_kin_address" => $applicant->next_kin_address ?? "",
                                "next_kin_email_address" => $applicant->next_kin_email ?? "",
                                "next_kin_phone" => $applicant->next_kin_phone,
                                "next_kin_region" => $applicant->next_kin_region,
                                "next_kin_relation" => $applicant->next_kin_relationship
                            ]
                        ]
                    ]
                ]
            ];

            // print_r($data);
            // die();
            Log::info("total data: " . print_r($data, true));
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://www.nacte.go.tz/nacteapi/index.php/api/upload',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json',
                    'Content-Type: application/json'
                ],
            ]);

            $response = curl_exec($curl);
            //print_r($response);die();
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($response === false) {
                echo 'cURL Error: ' . curl_error($curl);
            } else {
                if ($httpCode == 200) {
                    SelectedDiplomaCertificate::where('index_no', $applicant->index_no)
                        ->where('nacte_status', 0)
                        ->update(['nacte_status' => 1]);
                    $indexNumbers = $index;
                    $decodedResponse = json_decode($response);
                    $apiResponses = $decodedResponse->message;
                    Log::info("Api response " . $indexNumbers);
                    Log::info("Api response " . $apiResponses);
                    // Ensure the data is an array before passing to session
                }

                curl_close($curl);
            }
        }
        return redirect()->route('submitted.dar')->with([
            'indexNumbers' => $indexNumbers,
            'apiResponses' => $apiResponses
        ]);
    }

    public function tamisemiListDar(Request $request)
    {
        // Step 1: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')->orWhere('name', 'LIKE', 'Basic Technician%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $data = null;
        return view('Admission.Applicants.nactevet.tamisemilist-dar', compact('programme', 'data'));
    }
    public function tamisemiListDarStore(Request $request)
    {
        // Step 3: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')->orWhere('name', 'LIKE', 'Basic Technician%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        $arushaCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');

        $iaacode = ProgrammeNacte::where('program_id', $programId)->pluck('iaa_program_id')->first();

        $apiUrl = "nacte.go.tz/nacteapi/index.php/api/tamisemiconfirmedlist/{$programId}-{$year}-september/LM1ac63c322682a3.3d276167f2ca8c0e4849100749a8218b23fd7c3f676b53ceb703b875171da62c.4f7ad36501f76b0198f7c405be001667d7ac698d";
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);
        if (!isset($data['params']) || empty($data['params'])) {
            Log::error('No valid data found in API response.');
            return redirect()->back()->withErrors('No data found in API response.');
        }

        // Step 8: Process the API Data
        foreach ($data['params'] as $item) {
            $academicYear = AcademicYear::where('active', 1)->first();
            $intakes = Intake::where('active', 1)->first();
            $window = ApplicationWindow::where('active', 1)->first();

            Log::info('Campus id: ' . $arushaCampus);

            //     // Step 10: Validate the item before saving
            //     $validator = Validator::make($item, [
            //         'username' => 'required|unique:tamisemi_lists,username',
            //    //'programme_name' => 'required',
            //         'fullname' => 'required',
            //     ]);

            //     if ($validator->fails()) {
            //         Log::error('Validation failed for username: ' . $item['username']);
            //         Log::error('Validation errors: ' . json_encode($validator->errors()->all()));
            //         continue;
            //     }

            // Log::info('Saving/updating verification data', [
            //     'username' => $item['username'],
            //     'fullname' => $item['fullname'],
            //     'programme_id' => $iaacode,
            // ]);

            if (empty($iaacode) || empty($intakes->id) || empty($academicYear->id)) {
                Log::error('Invalid foreign key values for username: ' . $item['username']);
                continue;
            }

            // Step 12: Save or Update the Verification Data
            $savedRecord = TamisemiList::updateOrCreate(
                ['username' => $item['username']],
                [
                    'fullname' => $item['fullname'],
                    'appplication_year' => $item['appplication_year'],
                    'programe_name' => $item['programe_name'],
                    'institution_name' => $item['institution_name'],
                    'phone_number' => $item['phone_number'],
                    'email' => $item['email'],
                    'address' => $item['address'],
                    'district' => $item['district'],
                    'region' => $item['region'],
                    'Next_of_kin_fullname' => $item['Next_of_kin_fullname'],
                    'Next_of_kin_phone_number' => $item['Next_of_kin_phone_number'],
                    'Next_of_kin_email' => $item['Next_of_kin_email'],
                    'Next_of_kin_address' => $item['Next_of_kin_address'],
                    'Next_of_kin_region' => $item['Next_of_kin_region'],
                    'relationship' => $item['relationship'],
                    'sex' => $item['sex'],
                    'date_of_birth' => $item['date_of_birth'],
                    'intake_id' => $intakes->id,
                    'academic_year_id' => $academicYear->id,
                    'window_id' => $window->id,
                    'programme_id' => $iaacode,
                    'campus_id' => $arushaCampus,
                ]
            );

            Log::info('Saved or updated record for username: ' . $item['username'], [
                'saved_record' => $savedRecord
            ]);
        }
        Log::info('Decoded Data:', ['data' => $data]);

        // Redirect to the tamisemi.arusha route
        return redirect()->route('tamisemi.dar')->with(['data' => $data, 'programme' => $programme]);
    }
    public function verificationDar(Request $request)
    {
        // Step 2: Get the Babati Campus ID
        $darCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $darCampus)->orderBy('id', 'desc')->get();
        $data = [];
        // Step 13: Return the View with the Programme and Data
        return view('Admission.Applicants.nactevet.verification-dar', compact('programme', 'data'));
    }
    public function storeVerifiedApplicantDar(Request $request)
    {
        // Step 2: Get the Babati Campus ID
        $darCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $darCampus)->orderBy('id', 'desc')->get();
        // Step 4: Get Inputs from the Request
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');
        // Step 5: Get the IAA code (programme_id)
        $iaacode = ProgrammeNacte::where('program_id', $programId)->pluck('iaa_program_id')->first();
        // Step 6: Prepare the API URL
        $apiUrl = "https://www.nacte.go.tz/nacteapi/index.php/api/verificationresults/{$programId}-{$year}-{$intake}/ST6698d4e10db8be.e84a5610ba367f06027af1558d89128ef67d91edeebd3bd42d1521e15a5210fd.3cf2c4daad15c0606299499df22f0ff3f4d47930";

        // Step 7: Make API Request
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the response
        $data = json_decode($response, true);

        // Check if 'params' exists and contains data
        if (!isset($data['params']) || empty($data['params'])) {
            Log::error('No valid data found in API response.');
            return redirect()->back()->withErrors('No data found in API response.');
        }

        // Step 8: Process the API Data
        foreach ($data['params'] as $item) {
            // Step 9: Fetch Necessary Data
            $academicYear = AcademicYear::where('active', 1)->first();
            $intakes = Intake::where('active', 1)->first();
            $window = ApplicationWindow::where('active', 1)->first();

            // Log eligibility to check if it matches the expected value
            Log::info('Eligibility: ' . $item['eligibility']);

            // Check eligibility and set status accordingly
            $status = (isset($item['eligibility']) && strtolower(trim($item['eligibility'])) === "eligible") ? 1 : 0;

            // Log the status to verify it's being set correctly
            Log::info('campus Status: ' . $darCampus);
            // Step 10: Validate the item before saving
            $validator = Validator::make($item, [
                'username' => 'required|unique:verification_nactes,username',
                'user_id' => 'required|unique:verification_nactes,user_id',
                'verification_status' => 'required',
                'multiple_selection' => 'required',
                'academic_year' => 'required',
                'intake' => 'required',
                'eligibility' => 'required',
                'remarks' => 'required',
            ]);

            if ($validator->fails()) {
                // If validation fails, log the error and skip this item
                Log::error('Validation failed for username: ' . $item['username']);
                Log::error('Validation errors: ' . json_encode($validator->errors()->all()));
                continue;
            }

            // Log the data being saved to ensure it's correct
            Log::info('Saving/updating verification data', [
                'username' => $item['username'],
                'user_id' => $item['user_id'],
                'programme_id' => $iaacode, // Check if this is correct
                'eligibility' => $item['eligibility'],
                'status' => $status,
            ]);

            // Step 11: Check if Foreign Keys are valid
            if (empty($iaacode) || empty($intakes->id) || empty($academicYear->id) || empty($window->id)) {
                Log::error('Invalid foreign key values for username: ' . $item['username']);
                continue;
            }

            // Step 12: Save or Update the Verification Data
            $savedRecord = VerificationNacte::updateOrCreate(
                [
                    'username' => $item['username'],
                    'user_id' => $item['user_id'],
                ],
                [
                    'verification_status' => $item['verification_status'],
                    'multiple_selection' => $item['multiple_selection'],
                    'academic_year' => $item['academic_year'],
                    'intake' => $item['intake'],
                    'eligibility' => $item['eligibility'],
                    'remarks' => $item['remarks'],
                    'status' => $status, // Save 1 if Eligible, else 0
                    'intake_id' => $intakes->id,
                    'academic_year_id' => $academicYear->id,
                    'window_id' => $window->id,
                    'programme_id' => $iaacode,
                    'campus_id' => $darCampus,
                    'intake_id' => $intakes->id
                ]
            );

            // Log the result of the save/update operation
            Log::info('Saved or updated record for username: ' . $item['username'], [
                'saved_record' => $savedRecord
            ]);
        }
        // Step 13: Return the View with the Programme and Data
        return redirect()->route('verification.dar')->with(['data' => $data, 'programme' => $programme]);
    }
    //get pushed blist applicant
    public function pushedListDar()
    {
        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $data = [];
        // Step 13: Return the View with the Programme and Data
        return view('Admission.Applicants.nactevet.getpushed-dar', compact('programme', 'data'));
    }
    public function displaypushedlistDar(Request $request)
    {
        // Step 2: Get the Babati Campus ID
        $darCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $darCampus)->orderBy('id', 'desc')->get();
        // Step 4: Get Inputs from the Request
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');
        // Step 6: Prepare the API URL
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/pushedlist/{$programId}-{$year}-{$intake}/YZc04dc0cf03ebed.3cf07d40ae37fce87d5d0418dc1bdd242412b373323b4abae29c976bc0f0fa04.b1c70f445e748846fa47ef10b96628c9191087a9";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the JSON response into an array
        $decodedData = json_decode($response, true);

        // Log the response (Optional for debugging)
        Log::info('Api response' . $response);
        // Step 7: Pass the decoded data to the view
        return redirect()->route('getpushedlist.arusha')->with('data', $decodedData['params'] ?? []);
    }
    //check payment Balance
    public function checkBalanceDar()
    {
        $balance = '';
        return view('Admission.Applicants.nactevet.payment-dar', compact('balance'));
    }
    public function displayBalanceDar(Request $request)
    {
        $payment = $request->input('payment');
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/payment/{$payment}/FG58f1a31c584fc4.9c759b25a13e3e81ecceb5e28d0952735d49d21ac4f4c2ae292a4c73585a4da6.0cfc27c8841d2dc9960ca1f3b3d908cf2a96dc94";

        // Initialize CURL request to fetch the data
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);
        // Execute the request
        $response = curl_exec($curl);
        curl_close($curl);
        // Decode the JSON response into an array
        $decodedData = json_decode($response, true);
        // Log API response for debugging purposes
        Log::info('Api response: ' . $response);
        // Extract the balance from the response
        $balance = $decodedData['params'][0]['balance'] ?? null;
        // Redirect to the payment page and pass the balance to the view
        return redirect()->route('payment.dar')->with('balance', $balance);
    }




    //DODOMA CAMPUS
    public function indexDodoma()
    {
        $indexNumbers = [];
        $apiResponses = [];
        // Step 3: Get the Application Level and Category IDs
        $level = ApplicationLevel::Where('name', 'LIKE', '%Certificate%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        $dodomaCampus = Campus::where('name', 'like', '%dodoma%')->pluck('id')->first();
        // Get the programme and category IDs related to the level
        $programme = ProgrammeNacte::where('campus_id', $dodomaCampus)->where('nta', $level->id)->get();
        return view('Admission.Applicants.nactevet.submitted-dar', compact('programme', 'indexNumbers', 'apiResponses'));
    }
    public function sendNacteDodoma(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'payment'       => 'required|string',
            'intake_id'     => 'required|string',
            'programme_id'  => 'required|integer',
        ]);
        $payment     = $validatedData['payment'];
        $intakeId    = $validatedData['intake_id'];
        $programmeId = $validatedData['programme_id'];

        // Fetch the Arusha Campus ID (adjust the query as needed)
        $arushaCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();

        // Fetch applicants based on the provided conditions
        $applicants = ProgrammeNacte::list()
            ->where('dip.campus_id', $arushaCampus)
            ->where('programme_nactes.campus_id', $arushaCampus)
            ->where('programme_nactes.iaa_program_id', $programmeId)
            ->where('dip.iaa_programme_code', $programmeId)
            ->where('dip.nacte_status', 0)
            ->get();
        //check if applicants available
        if (!$applicants) {
            return redirect()->route('submitted.dar')->with('error', "applicants not exist the programme");
        }
        $authorizationToken = '7887fc47337ee359f1c3ee3672ce62cd845d05c9';
        $indexNumbers = [];
        $apiResponses = [];
        foreach ($applicants as $applicant) {
            // Process the index number to get form four details
            $index = $applicant->index_no;  // Example format: S2993-0013-XXXX
            $parts = explode('-', $index);
            // Combine the first two parts with a slash and get the third part separately
            $firstPart  = $parts[0] . '/' . $parts[1];  // e.g., S2993/0013
            $secondPart = $parts[2];
            $index6 = $applicant->qualification_no; // Assuming it's "S0456-0003-2013"
            // Split the string by '-'
            $partsindex = explode('-', $index6);
            // Check if there are at least 3 parts
            if (count($partsindex) >= 3) {
                // Format the first part as S0456/0003
                $firstPart6 = $partsindex[0] . '/' . $partsindex[1];
                // Get the second part as 2013
                $secondPart6 = $partsindex[2];
            } else {
                // Handle error if the format is incorrect
                $firstPart6 = '';
                $secondPart6 = '';
            }
            // Format the date of birth using Carbon
            $formattedDob = Carbon::parse($applicant->dob)->format('d-m-Y');

            $data = [
                [
                    "heading" => [
                        "authorization" => $authorizationToken,
                        "intake" => $intakeId,
                        "programme_id" => $applicant->program_nacte_id,
                        "application_year" => "2021",
                        "level" => "4",
                        "payment_reference_number" => $payment
                    ],
                    "students" => [
                        [
                            "particulars" => [
                                "firstname" => $applicant->first_name,
                                "secondname" => $applicant->middle_name,
                                "surname" => $applicant->last_name,
                                "DOB" => $formattedDob,
                                "gender" => "Male",
                                "impairement" => $applicant->disability,
                                "form_four_indexnumber" => $firstPart,
                                "form_four_year" => $secondPart,
                                "form_six_indexnumber" => $applicant->$firstPart6 ?? "",
                                "form_six_year" => $applicant->$secondPart6 ?? "",
                                "NTA4_reg" => "",
                                "NTA4_grad_year" => "",
                                "NTA5_reg" => "",
                                "NTA5_grad_year" => "",
                                "email_address" => $applicant->email,
                                "mobile_number" => $applicant->mobile_no,
                                "address" => $applicant->physical_address,
                                "region" => $applicant->region,
                                "district" => $applicant->district,
                                "nationality" => $applicant->nationality,
                                "next_kin_name" => $applicant->next_kin_name,
                                "next_kin_address" => $applicant->next_kin_address ?? "",
                                "next_kin_email_address" => $applicant->next_kin_email ?? "",
                                "next_kin_phone" => $applicant->next_kin_phone,
                                "next_kin_region" => $applicant->next_kin_region,
                                "next_kin_relation" => $applicant->next_kin_relationship
                            ]
                        ]
                    ]
                ]
            ];

            // print_r($data);
            // die();
            Log::info("total data: " . print_r($data, true));
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://www.nacte.go.tz/nacteapi/index.php/api/upload',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json',
                    'Content-Type: application/json'
                ],
            ]);

            $response = curl_exec($curl);
            //print_r($response);die();
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($response === false) {
                echo 'cURL Error: ' . curl_error($curl);
            } else {
                if ($httpCode == 200) {
                    SelectedDiplomaCertificate::where('index_no', $applicant->index_no)
                        ->where('nacte_status', 0)
                        ->update(['nacte_status' => 1]);
                    $indexNumbers = $index;
                    $decodedResponse = json_decode($response);
                    $apiResponses = $decodedResponse->message;
                    Log::info("Api response " . $indexNumbers);
                    Log::info("Api response " . $apiResponses);
                    // Ensure the data is an array before passing to session
                }

                curl_close($curl);
            }
        }
        return redirect()->route('submitted.dodoma')->with([
            'indexNumbers' => $indexNumbers,
            'apiResponses' => $apiResponses
        ]);
    }
    public function tamisemiListDodoma(Request $request)
    {
        // Step 1: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')->orWhere('name', 'LIKE', 'Basic Technician%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%dodoma%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $data = null;
        return view('Admission.Applicants.nactevet.tamisemilist-dodoma', compact('programme', 'data'));
    }
    public function tamisemiListDodomaStore(Request $request)
    {
        // Step 3: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')->orWhere('name', 'LIKE', 'Basic Technician%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        $arushaCampus = Campus::where('name', 'like', '%dodoma%')->pluck('id')->first();
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');

        $iaacode = ProgrammeNacte::where('program_id', $programId)->pluck('iaa_program_id')->first();

        $apiUrl = "nacte.go.tz/nacteapi/index.php/api/tamisemiconfirmedlist/{$programId}-{$year}-september/ef44889d37437f58.09107b3d11b0b80aac0a29d7212567f58a352d2bd23b7c0bce7c4f7969d39a9e.401f2f3de5f2753dfe0eb8a57d94135745e7de64";
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);
        if (!isset($data['params']) || empty($data['params'])) {
            Log::error('No valid data found in API response.');
            return redirect()->back()->withErrors('No data found in API response.');
        }

        // Step 8: Process the API Data
        foreach ($data['params'] as $item) {
            $academicYear = AcademicYear::where('active', 1)->first();
            $intakes = Intake::where('active', 1)->first();
            $window = ApplicationWindow::where('active', 1)->first();

            Log::info('Eligibility Status: ' . $arushaCampus);

            // Step 10: Validate the item before saving
            $validator = Validator::make($item, [
                'username' => 'required|unique:tamisemi_lists,username',
                'programme_name' => 'required',
                'fullname' => 'required',
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed for username: ' . $item['username']);
                Log::error('Validation errors: ' . json_encode($validator->errors()->all()));
                continue;
            }

            Log::info('Saving/updating verification data', [
                'username' => $item['username'],
                'fullname' => $item['fullname'],
                'programme_id' => $iaacode,
            ]);

            if (empty($iaacode) || empty($intakes->id) || empty($academicYear->id) || empty($window->id)) {
                Log::error('Invalid foreign key values for username: ' . $item['username']);
                continue;
            }

            // Step 12: Save or Update the Verification Data
            $savedRecord = TamisemiList::updateOrCreate(
                ['username' => $item['username']],
                [
                    'fullname' => $item['fullname'],
                    'appplication_year' => $item['appplication_year'],
                    'programe_name' => $item['programe_name'],
                    'institution_name' => $item['institution_name'],
                    'phone_number' => $item['phone_number'],
                    'email' => $item['email'],
                    'address' => $item['address'],
                    'district' => $item['district'],
                    'region' => $item['region'],
                    'Next_of_kin_fullname' => $item['Next_of_kin_fullname'],
                    'Next_of_kin_phone_number' => $item['Next_of_kin_phone_number'],
                    'Next_of_kin_email' => $item['Next_of_kin_email'],
                    'Next_of_kin_address' => $item['Next_of_kin_address'],
                    'Next_of_kin_region' => $item['Next_of_kin_region'],
                    'relationship' => $item['relationship'],
                    'sex' => $item['sex'],
                    'date_of_birth' => $item['date_of_birth'],
                    'intake_id' => $intakes->id,
                    'academic_year_id' => $academicYear->id,
                    'window_id' => $window->id,
                    'programme_id' => $iaacode,
                    'campus_id' => $arushaCampus,
                ]
            );

            Log::info('Saved or updated record for username: ' . $item['username'], [
                'saved_record' => $savedRecord
            ]);
        }
        Log::info('Decoded Data:', ['data' => $data]);

        // Redirect to the tamisemi.arusha route
        return redirect()->route('tamisemi.dodoma')->with(['data' => $data, 'programme' => $programme]);
    }

    public function verificationDodoma(Request $request)
    {
        // Step 1: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')->orWhere('name', 'LIKE', 'Basic Technician%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%dodoma%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $data = null;
        // Step 13: Return the View with the Programme and Data
        return view('Admission.Applicants.nactevet.verification-dodoma', compact('programme', 'data'));
    }
    public function storeVerifiedApplicantDodoma(Request $request)
    {
        // Step 1: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')
            ->orWhere('name', 'LIKE', 'Basic Technician%')->first();

        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }

        // Step 2: Get the Babati Campus ID
        $babatiCampus = Campus::where('name', 'like', '%dodoma%')->pluck('id')->first();

        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $babatiCampus)->orderBy('id', 'desc')->get();

        // Step 4: Get Inputs from the Request
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');

        // Step 5: Get the IAA code (programme_id)
        $iaacode = ProgrammeNacte::where('program_id', $programId)->pluck('iaa_program_id')->first();
        // Step 6: Prepare the API URL
        $apiUrl = "https://www.nacte.go.tz/nacteapi/index.php/api/verificationresults/{$programId}-{$year}-{$intake}/GHfe89b517fcb94c.965c3ea5070765d3e64b15f104f8979417f0ea8617e8c61f86c8cb70a0d81fc5.340ede80c9f2d6c4e3953328b5b8c51a5fbcf723";

        // Step 7: Make API Request
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the response
        $data = json_decode($response, true);

        // Check if 'params' exists and contains data
        if (!isset($data['params']) || empty($data['params'])) {
            Log::error('No valid data found in API response.');
            return redirect()->back()->withErrors('No data found in API response.');
        }

        // Step 8: Process the API Data
        foreach ($data['params'] as $item) {
            // Step 9: Fetch Necessary Data
            $academicYear = AcademicYear::where('active', 1)->first();
            $intakes = Intake::where('active', 1)->first();
            $window = ApplicationWindow::where('active', 1)->first();

            // Log eligibility to check if it matches the expected value
            Log::info('Eligibility: ' . $item['eligibility']);

            // Check eligibility and set status accordingly
            $status = (isset($item['eligibility']) && strtolower(trim($item['eligibility'])) === "eligible") ? 1 : 0;

            // Log the status to verify it's being set correctly
            Log::info('Eligibility Status: ' . $babatiCampus);  // This should log "1" if the eligibility is "Eligible"

            // Step 10: Validate the item before saving
            $validator = Validator::make($item, [
                'username' => 'required|unique:verification_nactes,username',
                'user_id' => 'required|unique:verification_nactes,user_id',
                'verification_status' => 'required',
                'multiple_selection' => 'required',
                'academic_year' => 'required',
                'intake' => 'required',
                'eligibility' => 'required',
                'remarks' => 'required',
            ]);

            if ($validator->fails()) {
                // If validation fails, log the error and skip this item
                Log::error('Validation failed for username: ' . $item['username']);
                Log::error('Validation errors: ' . json_encode($validator->errors()->all()));
                continue;
            }

            // Log the data being saved to ensure it's correct
            Log::info('Saving/updating verification data', [
                'username' => $item['username'],
                'user_id' => $item['user_id'],
                'programme_id' => $iaacode, // Check if this is correct
                'eligibility' => $item['eligibility'],
                'status' => $status,
            ]);

            // Step 11: Check if Foreign Keys are valid
            if (empty($iaacode) || empty($intakes->id) || empty($academicYear->id) || empty($window->id)) {
                Log::error('Invalid foreign key values for username: ' . $item['username']);
                continue;
            }

            // Step 12: Save or Update the Verification Data
            $savedRecord = VerificationNacte::updateOrCreate(
                [
                    'username' => $item['username'],
                    'user_id' => $item['user_id'],
                ],
                [
                    'verification_status' => $item['verification_status'],
                    'multiple_selection' => $item['multiple_selection'],
                    'academic_year' => $item['academic_year'],
                    'intake' => $item['intake'],
                    'eligibility' => $item['eligibility'],
                    'remarks' => $item['remarks'],
                    'status' => $status, // Save 1 if Eligible, else 0
                    'intake_id' => $intakes->id,
                    'academic_year_id' => $academicYear->id,
                    'window_id' => $window->id,
                    'programme_id' => $iaacode,
                    'campus_id' => $babatiCampus,
                    'intake_id' => $intakes->id
                ]
            );

            // Log the result of the save/update operation
            Log::info('Saved or updated record for username: ' . $item['username'], [
                'saved_record' => $savedRecord
            ]);
        }

        // Step 13: Return the View with the Programme and Data
        return redirect()->route('verification.dodoma')->with(['data' => $data, 'programme' => $programme]);
    }
    //get pushed blist applicant
    public function pushedListDodoma()
    {
        // Step 2: Get the Babati Campus ID
        $dodomaCampus = Campus::where('name', 'like', '%dodoma%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $dodomaCampus)->orderBy('id', 'desc')->get();
        $data = [];
        // Step 13: Return the View with the Programme and Data
        return view('Admission.Applicants.nactevet.getpushed-dodoma', compact('programme', 'data'));
    }
    public function displaypushedlistDodoma(Request $request)
    {
        // Step 2: Get the Babati Campus ID
        $dodomaCampus = Campus::where('name', 'like', '%dodoma%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $dodomaCampus)->orderBy('id', 'desc')->get();
        // Step 4: Get Inputs from the Request
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');
        // Step 6: Prepare the API URL
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/pushedlist/{$programId}-{$year}-{$intake}/AB5befd4c0e94940.e4df7aba39b3eef07e3c4d22f67672d7b636149cee04d2eb59a164359d106119.ef92445a30bc07054892b5ff05f224ce0973b8eb";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the JSON response into an array
        $decodedData = json_decode($response, true);

        // Log the response (Optional for debugging)
        Log::info('Api response' . $response);
        // Step 7: Pass the decoded data to the view
        return redirect()->route('getpushedlist.dodoma')->with('data', $decodedData['params'] ?? []);
    }
    //check payment Balance
    public function checkBalanceDodoma()
    {
        $balance = '';
        return view('Admission.Applicants.nactevet.payment-dodoma', compact('balance'));
    }
    public function displayBalanceDodoma(Request $request)
    {
        $payment = $request->input('payment');
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/payment/{$payment}/NO97f6158f37fa26.e6ad7d6d9e01c7576cddfa070bac34c95679a91080b2009cc538e2f96d2c46a3.304bf1014ce08efd6a18ece8719356765baa1d4f";

        // Initialize CURL request to fetch the data
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);
        // Execute the request
        $response = curl_exec($curl);
        curl_close($curl);
        // Decode the JSON response into an array
        $decodedData = json_decode($response, true);
        // Log API response for debugging purposes
        Log::info('Api response: ' . $response);
        // Extract the balance from the response
        $balance = $decodedData['params'][0]['balance'] ?? null;
        // Redirect to the payment page and pass the balance to the view
        return redirect()->route('payment.dodoma')->with('balance', $balance);
    }
    //songea campus
    public function indexSongea()
    {
        $indexNumbers = [];
        $apiResponses = [];
        // Step 3: Get the Application Level and Category IDs
        $level = ApplicationLevel::Where('name', 'LIKE', '%Certificate%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        $dodomaCampus = Campus::where('name', 'like', '%dodoma%')->pluck('id')->first();
        // Get the programme and category IDs related to the level
        $programme = ProgrammeNacte::where('campus_id', $dodomaCampus)->where('nta', $level->id)->get();
        return view('Admission.Applicants.nactevet.submitted-dar', compact('programme', 'indexNumbers', 'apiResponses'));
    }
    public function sendNacteSongea(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'payment'       => 'required|string',
            'intake_id'     => 'required|string',
            'programme_id'  => 'required|integer',
        ]);
        $payment     = $validatedData['payment'];
        $intakeId    = $validatedData['intake_id'];
        $programmeId = $validatedData['programme_id'];

        // Fetch the Arusha Campus ID (adjust the query as needed)
        $arushaCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();

        // Fetch applicants based on the provided conditions
        $applicants = ProgrammeNacte::list()
            ->where('dip.campus_id', $arushaCampus)
            ->where('programme_nactes.campus_id', $arushaCampus)
            ->where('programme_nactes.iaa_program_id', $programmeId)
            ->where('dip.iaa_programme_code', $programmeId)
            ->where('dip.nacte_status', 0)
            ->get();
        //check if applicants available
        if (!$applicants) {
            return redirect()->route('submitted.dar')->with('error', "applicants not exist the programme");
        }
        $authorizationToken = 'a16ea2fea66e8d65ed481bbbf41cecc865a0bc6b';
        $indexNumbers = [];
        $apiResponses = [];
        foreach ($applicants as $applicant) {
            // Process the index number to get form four details
            $index = $applicant->index_no;  // Example format: S2993-0013-XXXX
            $parts = explode('-', $index);
            // Combine the first two parts with a slash and get the third part separately
            $firstPart  = $parts[0] . '/' . $parts[1];  // e.g., S2993/0013
            $secondPart = $parts[2];
            $index6 = $applicant->qualification_no; // Assuming it's "S0456-0003-2013"
            // Split the string by '-'
            $partsindex = explode('-', $index6);
            // Check if there are at least 3 parts
            if (count($partsindex) >= 3) {
                // Format the first part as S0456/0003
                $firstPart6 = $partsindex[0] . '/' . $partsindex[1];
                // Get the second part as 2013
                $secondPart6 = $partsindex[2];
            } else {
                // Handle error if the format is incorrect
                $firstPart6 = '';
                $secondPart6 = '';
            }
            // Format the date of birth using Carbon
            $formattedDob = Carbon::parse($applicant->dob)->format('d-m-Y');

            $data = [
                [
                    "heading" => [
                        "authorization" => $authorizationToken,
                        "intake" => $intakeId,
                        "programme_id" => $applicant->program_nacte_id,
                        "application_year" => "2021",
                        "level" => "4",
                        "payment_reference_number" => $payment
                    ],
                    "students" => [
                        [
                            "particulars" => [
                                "firstname" => $applicant->first_name,
                                "secondname" => $applicant->middle_name,
                                "surname" => $applicant->last_name,
                                "DOB" => $formattedDob,
                                "gender" => "Male",
                                "impairement" => $applicant->disability,
                                "form_four_indexnumber" => $firstPart,
                                "form_four_year" => $secondPart,
                                "form_six_indexnumber" => $applicant->$firstPart6 ?? "",
                                "form_six_year" => $applicant->$secondPart6 ?? "",
                                "NTA4_reg" => "",
                                "NTA4_grad_year" => "",
                                "NTA5_reg" => "",
                                "NTA5_grad_year" => "",
                                "email_address" => $applicant->email,
                                "mobile_number" => $applicant->mobile_no,
                                "address" => $applicant->physical_address,
                                "region" => $applicant->region,
                                "district" => $applicant->district,
                                "nationality" => $applicant->nationality,
                                "next_kin_name" => $applicant->next_kin_name,
                                "next_kin_address" => $applicant->next_kin_address ?? "",
                                "next_kin_email_address" => $applicant->next_kin_email ?? "",
                                "next_kin_phone" => $applicant->next_kin_phone,
                                "next_kin_region" => $applicant->next_kin_region,
                                "next_kin_relation" => $applicant->next_kin_relationship
                            ]
                        ]
                    ]
                ]
            ];

            // print_r($data);
            // die();
            Log::info("total data: " . print_r($data, true));
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://www.nacte.go.tz/nacteapi/index.php/api/upload',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json',
                    'Content-Type: application/json'
                ],
            ]);

            $response = curl_exec($curl);
            //print_r($response);die();
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($response === false) {
                echo 'cURL Error: ' . curl_error($curl);
            } else {
                if ($httpCode == 200) {
                    SelectedDiplomaCertificate::where('index_no', $applicant->index_no)
                        ->where('nacte_status', 0)
                        ->update(['nacte_status' => 1]);
                    $indexNumbers = $index;
                    $decodedResponse = json_decode($response);
                    $apiResponses = $decodedResponse->message;
                    Log::info("Api response " . $indexNumbers);
                    Log::info("Api response " . $apiResponses);
                    // Ensure the data is an array before passing to session
                }

                curl_close($curl);
            }
        }
        return redirect()->route('submitted.dodoma')->with([
            'indexNumbers' => $indexNumbers,
            'apiResponses' => $apiResponses
        ]);
    }
    public function tamisemiListSongea(Request $request)
    {
        // Step 1: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')->orWhere('name', 'LIKE', 'Basic Technician%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%songea%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $data = null;
        return view('Admission.Applicants.nactevet.tamisemilist-songea', compact('programme', 'data'));
    }
    public function tamisemiListSongeaStore(Request $request)
    {
        // Step 3: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')->orWhere('name', 'LIKE', 'Basic Technician%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        $arushaCampus = Campus::where('name', 'like', '%songea%')->pluck('id')->first();
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');

        $iaacode = ProgrammeNacte::where('program_id', $programId)->pluck('iaa_program_id')->first();

        $apiUrl = "nacte.go.tz/nacteapi/index.php/api/tamisemiconfirmedlist/{$programId}-{$year}-september/xyc5f7efe708d547.2f112c1270251e121f69235a21a22021dd4a3ee2ec84ea8a60385bd294141f70.e46d4139e064e3425c531ff1d5390f6d823f30c4";
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);
        if (!isset($data['params']) || empty($data['params'])) {
            Log::error('No valid data found in API response.');
            return redirect()->back()->withErrors('No data found in API response.');
        }

        // Step 8: Process the API Data
        foreach ($data['params'] as $item) {
            $academicYear = AcademicYear::where('active', 1)->first();
            $intakes = Intake::where('active', 1)->first();
            $window = ApplicationWindow::where('active', 1)->first();

            Log::info('Eligibility Status: ' . $arushaCampus);

            // Step 10: Validate the item before saving
            $validator = Validator::make($item, [
                'username' => 'required|unique:tamisemi_lists,username',
                'programme_name' => 'required',
                'fullname' => 'required',
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed for username: ' . $item['username']);
                Log::error('Validation errors: ' . json_encode($validator->errors()->all()));
                continue;
            }

            Log::info('Saving/updating verification data', [
                'username' => $item['username'],
                'fullname' => $item['fullname'],
                'programme_id' => $iaacode,
            ]);

            if (empty($iaacode) || empty($intakes->id) || empty($academicYear->id) || empty($window->id)) {
                Log::error('Invalid foreign key values for username: ' . $item['username']);
                continue;
            }

            // Step 12: Save or Update the Verification Data
            $savedRecord = TamisemiList::updateOrCreate(
                ['username' => $item['username']],
                [
                    'fullname' => $item['fullname'],
                    'appplication_year' => $item['appplication_year'],
                    'programe_name' => $item['programe_name'],
                    'institution_name' => $item['institution_name'],
                    'phone_number' => $item['phone_number'],
                    'email' => $item['email'],
                    'address' => $item['address'],
                    'district' => $item['district'],
                    'region' => $item['region'],
                    'Next_of_kin_fullname' => $item['Next_of_kin_fullname'],
                    'Next_of_kin_phone_number' => $item['Next_of_kin_phone_number'],
                    'Next_of_kin_email' => $item['Next_of_kin_email'],
                    'Next_of_kin_address' => $item['Next_of_kin_address'],
                    'Next_of_kin_region' => $item['Next_of_kin_region'],
                    'relationship' => $item['relationship'],
                    'sex' => $item['sex'],
                    'date_of_birth' => $item['date_of_birth'],
                    'intake_id' => $intakes->id,
                    'academic_year_id' => $academicYear->id,
                    'window_id' => $window->id,
                    'programme_id' => $iaacode,
                    'campus_id' => $arushaCampus,
                ]
            );

            Log::info('Saved or updated record for username: ' . $item['username'], [
                'saved_record' => $savedRecord
            ]);
        }
        Log::info('Decoded Data:', ['data' => $data]);

        // Redirect to the tamisemi.arusha route
        return redirect()->route('tamisemi.songea')->with(['data' => $data, 'programme' => $programme]);
    }

    public function verificationSongea(Request $request)
    {
        // Step 1: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')->orWhere('name', 'LIKE', 'Basic Technician%')->first();
        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }
        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%songea%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $data = null;
        // Step 13: Return the View with the Programme and Data
        return view('Admission.Applicants.nactevet.verification-arusha', compact('programme', 'data'));
    }
    public function storeVerifiedApplicantSongea(Request $request)
    {
        // Step 1: Get the Application Level and Category IDs
        $level = ApplicationLevel::where('name', 'LIKE', 'diploma%')
            ->orWhere('name', 'LIKE', 'Certificate%')->first();

        if (!$level) {
            return redirect()->back()->withErrors('No application level found.');
        }

        // Step 2: Get the Babati Campus ID
        $songeaCampus = Campus::where('name', 'like', '%songea%')->pluck('id')->first();

        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $songeaCampus)->orderBy('id', 'desc')->get();

        // Step 4: Get Inputs from the Request
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');

        // Step 5: Get the IAA code (programme_id)
        $iaacode = ProgrammeNacte::where('program_id', $programId)->pluck('iaa_program_id')->first();
        // Step 6: Prepare the API URL
        $apiUrl = "https://www.nacte.go.tz/nacteapi/index.php/api/verificationresults/{$programId}-{$year}-{$intake}/YZc4f180ac9f4c98.3aa7b43a5d7c86cd6f492bf36162ab940f97ee67b361343c4e66db2c9a7b3499.89d3e9353f455f4ae28b7f0b0a4d2703fc412d72";
        // Step 7: Make API Request
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the response
        $data = json_decode($response, true);

        // Check if 'params' exists and contains data
        if (!isset($data['params']) || empty($data['params'])) {
            Log::error('No valid data found in API response.');
            return redirect()->back()->withErrors('No data found in API response.');
        }

        // Step 8: Process the API Data
        foreach ($data['params'] as $item) {
            // Step 9: Fetch Necessary Data
            $academicYear = AcademicYear::where('active', 1)->first();
            $intakes = Intake::where('active', 1)->first();
            $window = ApplicationWindow::where('active', 1)->first();

            // Log eligibility to check if it matches the expected value
            Log::info('Eligibility: ' . $item['eligibility']);

            // Check eligibility and set status accordingly
            $status = (isset($item['eligibility']) && strtolower(trim($item['eligibility'])) === "eligible") ? 1 : 0;

            // Log the status to verify it's being set correctly
            Log::info('Eligibility Status: ' . $songeaCampus);  // This should log "1" if the eligibility is "Eligible"

            // Step 10: Validate the item before saving
            $validator = Validator::make($item, [
                'username' => 'required|unique:verification_nactes,username',
                'user_id' => 'required|unique:verification_nactes,user_id',
                'verification_status' => 'required',
                'multiple_selection' => 'required',
                'academic_year' => 'required',
                'intake' => 'required',
                'eligibility' => 'required',
                'remarks' => 'required',
            ]);

            if ($validator->fails()) {
                // If validation fails, log the error and skip this item
                Log::error('Validation failed for username: ' . $item['username']);
                Log::error('Validation errors: ' . json_encode($validator->errors()->all()));
                continue;
            }

            // Log the data being saved to ensure it's correct
            Log::info('Saving/updating verification data', [
                'username' => $item['username'],
                'user_id' => $item['user_id'],
                'programme_id' => $iaacode, // Check if this is correct
                'eligibility' => $item['eligibility'],
                'status' => $status,
            ]);

            // Step 11: Check if Foreign Keys are valid
            if (empty($iaacode) || empty($intakes->id) || empty($academicYear->id) || empty($window->id)) {
                Log::error('Invalid foreign key values for username: ' . $item['username']);
                continue;
            }

            // Step 12: Save or Update the Verification Data
            $savedRecord = VerificationNacte::updateOrCreate(
                [
                    'username' => $item['username'],
                    'user_id' => $item['user_id'],
                ],
                [
                    'verification_status' => $item['verification_status'],
                    'multiple_selection' => $item['multiple_selection'],
                    'academic_year' => $item['academic_year'],
                    'intake' => $item['intake'],
                    'eligibility' => $item['eligibility'],
                    'remarks' => $item['remarks'],
                    'status' => $status, // Save 1 if Eligible, else 0
                    'intake_id' => $intakes->id,
                    'academic_year_id' => $academicYear->id,
                    'window_id' => $window->id,
                    'programme_id' => $iaacode,
                    'campus_id' => $songeaCampus,
                    'intake_id' => $intakes->id
                ]
            );

            // Log the result of the save/update operation
            Log::info('Saved or updated record for username: ' . $item['username'], [
                'saved_record' => $savedRecord
            ]);
        }

        // Step 13: Return the View with the Programme and Data
        return redirect()->route('verification.songea')->with(['data' => $data, 'programme' => $programme]);
    }
    //get pushed blist applicant
    public function pushedListSongea()
    {
        // Step 2: Get the Babati Campus ID
        $arushaCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $arushaCampus)->orderBy('id', 'desc')->get();
        $data = [];
        // Step 13: Return the View with the Programme and Data
        return view('Admission.Applicants.nactevet.getpushed-dar', compact('programme', 'data'));
    }
    public function displaysongeapushedlist(Request $request)
    {
        // Step 2: Get the Babati Campus ID
        $darCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();
        // Step 3: Get the Programmes for the Babati Campus
        $programme = ProgrammeNacte::where('campus_id', $darCampus)->orderBy('id', 'desc')->get();
        // Step 4: Get Inputs from the Request
        $year = $request->input('year');
        $programId = $request->input('programme_id');
        $intake = $request->input('intake');
        // Step 6: Prepare the API URL
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/pushedlist/{$programId}-{$year}-{$intake}/WX13ee0beb6c756a.56796e8cc0a862e928491cf3778db8b6d2fd1adfe5fc6660e4e8130ca4be1252.664c562e78ce0c4e56c7f576025125662a16451e";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the JSON response into an array
        $decodedData = json_decode($response, true);

        // Log the response (Optional for debugging)
        Log::info('Api response' . $response);
        // Step 7: Pass the decoded data to the view
        return redirect()->route('getpushedlist.songea')->with('data', $decodedData['params'] ?? []);
    }
    //check payment Balance
    public function checkBalanceSongea()
    {
        $balance = '';
        return view('Admission.Applicants.nactevet.payment-songea', compact('balance'));
    }
    public function displayBalanceSongea(Request $request)
    {
        $payment = $request->input('payment');
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/payment/{$payment}/uve89579e9fead24.0c4dc0d01d90e350c659eb6f86190a039cf8db9cc1e3889eb52f0c4bfe215a55.3456fbb054014cf67cd51261c2982f40cd078632";

        // Initialize CURL request to fetch the data
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);
        // Execute the request
        $response = curl_exec($curl);
        curl_close($curl);
        // Decode the JSON response into an array
        $decodedData = json_decode($response, true);
        // Log API response for debugging purposes
        Log::info('Api response: ' . $response);
        // Extract the balance from the response
        $balance = $decodedData['params'][0]['balance'] ?? null;
        // Redirect to the payment page and pass the balance to the view
        return redirect()->route('payment.songea')->with('balance', $balance);
    }
}

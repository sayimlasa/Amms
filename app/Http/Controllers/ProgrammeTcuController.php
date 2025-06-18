<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Intake;
use App\Models\Programme;
use App\Models\Form4Result;
use App\Models\Form6Result;
use App\Models\AcademicYear;
use App\Models\ProgrammeTcu;
use Illuminate\Http\Request;
use App\Models\ApplicantsInfo;
use App\Models\ApplicantsUser;
use App\Models\ApplicantsChoice;
use App\Models\ApplicationLevel;
use App\Models\ApplicationCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\SelectedDiplomaCertificate;

class ProgrammeTcuController extends Controller
{

    public function indexArusha()
    {
        $arushaCampus = Campus::where('name', 'like', '%Arusha%')->pluck('id')->first();
        $programmetcu = ProgrammeTcu::where('campus_id', $arushaCampus)->get();
        return view('Admission.Applicants.tcu-programme.arushaprogramme', compact('programmetcu'));
    }
    public function indexDar()
    {
        $arushaCampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first();
        $programmetcu = ProgrammeTcu::where('campus_id', $arushaCampus)->get();
        return view('Admission.Applicants.tcu-programme.darprogramme', compact('programmetcu'));
    }

    public function editArusha($id)
    {
        $program = ProgrammeTcu::findOrFail($id);
        $levels = ApplicationLevel::where('name', 'LIKE', 'bachelor')->get();
        return view('Admission.Applicants.tcu-programme.edit-tcuprogramme', compact('program', 'levels'));
    }
    public function editDar($id)
    {
        $program = ProgrammeTcu::findOrFail($id);
        $levels = ApplicationLevel::where('name', 'LIKE', 'bachelor')->get();
        return view('Admission.Applicants.tcu-programme.edit-tcudarprogramme', compact('program', 'levels'));
    }
    public function updatesArusha(Request $request, $id)
    {
        $request->validate([
            'arusha_program' => 'required|exists:programmes,id',
            'arusha_program_id' => 'required',

        ]);

        $program = ProgrammeTcu::findOrFail($id);
        $program->iaa_program = $request->arusha_program;
        $program->iaa_programme_id = $request->arusha_program_id;
        $program->save();

        return redirect()->route('arusha.tcu')->with('success', 'Arusha programme updated successfully!');
    }
    public function updatesDar(Request $request, $id)
    {
        $request->validate([
            'arusha_program' => 'required|exists:programmes,id',
            'arusha_program_id' => 'required',

        ]);
        $program = ProgrammeTcu::findOrFail($id);
        $program->iaa_program = $request->arusha_program;
        $program->iaa_programme_id = $request->arusha_program_id;
        $program->save();
        return redirect()->route('dar.tcu')->with('success', 'Dar programme updated successfully!');
    }
    public function getConfirmapplicants()
    {
        $arushaCampus = Campus::where('name', 'like', '%Arusha%')->pluck('id')->first();
        Log::info($arushaCampus);
        $programtcu = ProgrammeTcu::where('campus_id', $arushaCampus)->get();
        $applicant = [];
        return view('Admission.Applicants.tcu-programme.getConfirmedApplicant', compact('programtcu', 'applicant'));
    }
    public function getConfirapplicantarusha(Request $request)
    {
        // Get the programme ID from the request
        $programId = $request->input('programme_id');
        // Log the programme ID for debugging purposes
        Log::info("Programme code: " . $programId);

        // Initialize cURL
        $curl = curl_init();
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/applicants/getConfirmed',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "<Request>
            <UsernameToken>
                <Username>IA</Username>
                <SessionToken>k1PrvR7fQUJYF563OtTx</SessionToken>
            </UsernameToken>
            <RequestParameters>
                <ProgrammeCode>{$programId}</ProgrammeCode>
            </RequestParameters>
        </Request>",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml'
            ),
        ));

        // Execute cURL request and get the response
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Get the HTTP status code
        curl_close($curl);
        Log::info('Response Status: ' . $httpCode);
        Log::info('Response: ' . $response);

        // Initialize an empty array to store applicant data
        $applicants = [];
        // Check if the response is successful (StatusCode 200)
        if ($httpCode == 200) {
            // Handle encoding issues
            $response = mb_convert_encoding($response, 'UTF-8', 'auto');
            // Parse the XML response
            $xml = simplexml_load_string($response);
            if ($xml === false) {
                Log::error("Failed to parse XML: " . $response);
                return response()->json(['error' => 'Failed to parse XML response.'], 500);
            }
            // Loop through each Applicant and process the data
            foreach ($xml->Response->ResponseParameters->Applicant as $applicant) {
                $applicants[] = [
                    'f4indexno' => (string) $applicant->f4indexno,
                    'f6indexno' => (string) $applicant->f6indexno,
                    'diploma' => (string) $applicant->DiplomaRegNo,
                    'programmeCode' => (string) $applicant->ProgrammeCode,
                    'admissionStatus' => (string) $applicant->AdmissionStatus,
                ];
            }
        } else {
            Log::error("Failed to get confirmed applicants. HTTP Status Code: $httpCode");
            return response()->json(['error' => 'Failed to retrieve applicants.'], 500);
        }
        Log::info('Parsed applicants data: ' . json_encode($applicants));

        // Return the applicants data as a JSON response
        return redirect()->route('getconfirmed.arusha')->with('applicant', json_encode($applicants));
    }
    public function sendtoArushaTcu()
    {
        $arushaCampus = Campus::where('name', 'like', '%Arusha%')->pluck('id')->first();
        $programtcu = ProgrammeTcu::where('campus_id', $arushaCampus)->get();
       // Log::info("programme is " . $programtcu->count());
        $responsetcu = [];
        $responsecode = [];
        return view('Admission.Applicants.tcu-programme.sendselectedtcu', compact('programtcu', 'responsetcu'));
    }
    public function sendbachelorapplicant(Request $request)
    {
        $arushaCampus = Campus::where('name', 'like', '%Arusha%')->pluck('id')->first();
        $programId = $request->input('programme_id');
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();
        $year = date("Y");

        Log::info("Programme ID " . $programId);
        // Get the applicant IDs for the selected program, year, and intake
        $applicantIds = SelectedDiplomaCertificate::where('iaa_programme_code', $programId)
            ->where('application_year', $year)->where('intake', $intake->id)->where('campus_id', $arushaCampus)
            ->pluck('applicant_user_id');

        Log::info("Applicants are: " . $applicantIds);

        $responsetcu = [];
        $responsecode = [];
        $indexnumber = [];

        // Loop through each applicant
        foreach ($applicantIds as $applicant) {
            // Get F4 results
            $fourresults = Form4Result::where('applicant_user_id', $applicant)->get();
            if ($fourresults->count() > 1) {
                // Display only the first two index_no
                $indexNos = $fourresults->take(2);  // Take first two results
                foreach ($indexNos as $fourresult) {
                    Log::info("F4 Index Number: " . $fourresult->index_no);
                }
            } else {
                // Display only the one index_no
                Log::info("F4 Index Number: " . $fourresults->first()->index_no);
            }

            // Get F6 results
            $sixresults = Form6Result::where('applicant_user_id', $applicant)->take(2)->get();
            if ($sixresults->isEmpty()) {
                Log::info("No F6 Index Number found for applicant ID: $applicant");
            } elseif ($sixresults->count() === 1) {
                Log::info("First F6 Index Number: " . $sixresults[0]->qualification_no);
            } else {
                Log::info("First F6 Index Number: " . $sixresults[0]->qualification_no);
                Log::info("Second F6 Index Number: " . $sixresults[1]->qualification_no);
            }

            // Get applicant's choices
            $applicantChoice = ApplicantsChoice::where('applicant_user_id', $applicant)->first();
            if ($applicantChoice) {
                $tcucode1 = ProgrammeTcu::where('iaa_programme_id', $applicantChoice->choice1)->where('campus_id',$arushaCampus)->first();
                $tcucode2 = ProgrammeTcu::where('iaa_programme_id', $applicantChoice->choice2)->where('campus_id',$arushaCampus)->first();
                $tcucode3 = ProgrammeTcu::where('iaa_programme_id', $applicantChoice->choice3)->where('campus_id',$arushaCampus)->first();

                // Check if choices exist
                if ($tcucode1 && $tcucode2 && $tcucode3) {
                    Log::info("Choice One: " . $tcucode1->tcu_code);
                    Log::info("Choice Two: " . $tcucode2->tcu_code);
                    Log::info("Choice Three: " . $tcucode3->tcu_code);
                } else {
                    Log::error("Some program choices are missing for applicant: $applicant");
                }
            }
            // Selected programme
            $selectedTcuCode = ProgrammeTcu::where('iaa_programme_id', $programId)->where('campus_id',$arushaCampus)->first();
            if ($selectedTcuCode) {
                Log::info("Selected Programme: " . $selectedTcuCode->tcu_code);
            } else {
                Log::error("Selected programme not found for program ID: $programId");
            }

            // Get applicant info
            $applicantUser = ApplicantsUser::where('id', $applicant)->first();
            if ($applicantUser) {
                Log::info("Email: " . $applicantUser->email);
                Log::info("Mobile: " . $applicantUser->mobile_no);
            } else {
                Log::error("Applicant user not found: $applicant");
            }

            // Get applicant additional info
            $applicantInfo = ApplicantsInfo::where('applicant_user_id', $applicant)->first();
            if ($applicantInfo) {
                Log::info("Gender: " . $applicantInfo->gender);
                Log::info("Birth Date: " . $applicantInfo->birth_date);
            } else {
                Log::error("Applicant info not found for applicant: $applicant");
            }

            // Prepare curl request
            $curl = curl_init();

            // Set default values if data is not available
            $f4indexno = $fourresults->first()->index_no;
            $f6indexno = $sixresults->first()->qualification_no;
            $gender = $applicantInfo->gender ?? 'M';  // Default to 'M' if not available
            $mobileNo = $applicantUser->mobile_no ?? '0766345678';  // Use fallback if null
            $email = $applicantUser->email ?? 'example@example.com';  // Use fallback if null
            $birthDate = $applicantInfo->birth_date ?? '2000-01-01';  // Use fallback if null

            $postFields = "
        <Request>
            <UsernameToken>
                <Username>IA</Username>
                <SessionToken>k1PrvR7fQUJYF563OtTx</SessionToken>
            </UsernameToken>
            <RequestParameters>
                <f4indexno>{$f4indexno}</f4indexno>
                <f6indexno>{$sixresults[0]->qualification_no}</f6indexno>
                <Gender>{$gender}</Gender>
                <SelectedProgrammes>{$tcucode1->tcu_code}, {$tcucode2->tcu_code}, {$tcucode3->tcu_code}</SelectedProgrammes>
                <MobileNumber>{$mobileNo}</MobileNumber>
                <OtherMobileNumber>{$applicantUser->mobile_no}</OtherMobileNumber>
                <EmailAddress>{$email}</EmailAddress>
                <Category>A</Category>
                <AdmissionStatus>provisional admission</AdmissionStatus>
                <ProgrammeAdmitted>{$selectedTcuCode->tcu_code}</ProgrammeAdmitted>
                <Reason>eligible</Reason>
                <Nationality>Tanzanian</Nationality>
                <Impairment>None</Impairment>
                <DateOfBirth>{$birthDate}</DateOfBirth>
                <NationalIdNumber>19620228-00001-00001-19</NationalIdNumber>
                <Otherf4indexno>S0001/0001/2009, S0001/0001/2010</Otherf4indexno>
                <Otherf6indexno>{$sixresults[1]->qualification_no}</Otherf6indexno>
            </RequestParameters>
        </Request>";

            curl_setopt_array($curl, [
                CURLOPT_URL => 'http://api.tcu.go.tz/applicants/submitProgramme',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $postFields,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json'
                ],
            ]);

            $response = curl_exec($curl);
            curl_close($curl);
            Log::info("Payload is " . $postFields);
            if ($response) {
                // Parse XML response
                $xml = simplexml_load_string($response);
                Log::info("programme is " . $xml);
                // Convert the SimpleXML object to an array for easier access
                $indexnumber[] = $f4indexno;
                $xmlArray = json_decode(json_encode($xml), true);
                $responsetcu[] = $xmlArray['Response']['ResponseParameters']['StatusCode'];
                $responsecode[] = $xmlArray['Response']['ResponseParameters']['StatusDescription'];

                // Log the response parameters
                Log::info("Response StatusCode: " . $xmlArray['Response']['ResponseParameters']['StatusCode']);
                Log::info("Response StatusDescription: " . $xmlArray['Response']['ResponseParameters']['StatusDescription']);
            } else {
                Log::error("No response received from cURL request.");
            }
        }
        return redirect()->route('sendtcu.arusha')->with([
            'responsetcu' => (array)$responsetcu,
            'responsecode' => (array)$responsecode,
            'indexnumber' => (array) $indexnumber  // Convert to array if not already
        ]);
    }
    //confirm 
    public function confirm()
    {
        return view('Admission.Applicants.tcu-programme.tcu-confirmed');
    }
    public function confirmstore(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'indexno' => 'required|string|max:20', // Adjust validation as needed
            'confirm' => 'required|string|max:20', // Adjust validation as needed
        ]);

        // Capture the inputs
        $indexno = $validatedData['indexno'];
        $confirmcode = $validatedData['confirm'];

        // Build the XML request string with proper string interpolation
        $xmlRequest = '<?xml version="1.0" encoding="UTF-8"?> 
    <Request> 
        <UsernameToken> 
            <Username>IA</Username> 
            <SessionToken>k1PrvR7fQUJYF563OtTx</SessionToken> 
        </UsernameToken> 
        <RequestParameters> 
            <f4indexno>' . $indexno . '</f4indexno> 
            <ConfirmationCode>' . $confirmcode . '</ConfirmationCode> 
        </RequestParameters> 
    </Request>';

        // Initialize cURL session
        $curl = curl_init();

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/admission/confirm', // API endpoint
            CURLOPT_RETURNTRANSFER => true, // Return response as a string
            CURLOPT_ENCODING => '', // Handle all encodings
            CURLOPT_MAXREDIRS => 10, // Max number of redirects
            CURLOPT_TIMEOUT => 0, // No timeout
            CURLOPT_FOLLOWLOCATION => true, // Follow redirects
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // HTTP version
            CURLOPT_CUSTOMREQUEST => 'POST', // POST request
            CURLOPT_POSTFIELDS => $xmlRequest, // The XML request body
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml', // Set content type to XML
            ),
        ));

        // Execute the cURL request and store the response
        $response = curl_exec($curl);

        // Check if the cURL request was successful
        if (curl_errno($curl)) {
            // If there was an error, display it
            echo 'cURL Error: ' . curl_error($curl);
        }

        // Get the HTTP response status code
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Optionally, log the status code and response for debugging
        Log::info("HTTP Status Code: " . $http_status);
        Log::info("Response is : " . $response);

        // Close the cURL session
        curl_close($curl);

        // Parse the XML response
        $xml = simplexml_load_string($response);

        // Convert the SimpleXMLElement object to an array (optional)
        $responseArray = json_decode(json_encode($xml), true);

        // Extract values from the response
        $f4indexno = $responseArray['Response']['ResponseParameters']['f4indexno'];
        $statusCode = $responseArray['Response']['ResponseParameters']['StatusCode'];
        $statusDescription = $responseArray['Response']['ResponseParameters']['StatusDescription'];

        // Pass the parsed data to the view
        return redirect()->route('confirm.arusha')->with([
            'f4indexno' => $f4indexno,
            'statusCode' => $statusCode,
            'statusDescription' => $statusDescription,
        ]);
    }
    public function unconfirm()
    {
        return view('Admission.Applicants.tcu-programme.tcu-unconfirmed');
    }
    public function unconfirmstore(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'indexno' => 'required|string|max:20', // Adjust validation as needed
            'confirm' => 'required|string|max:20', // Adjust validation as needed
        ]);

        // Capture the inputs
        $indexno = $validatedData['indexno'];
        $confirmcode = $validatedData['confirm'];

        // Build the XML request string with proper string interpolation
        $xmlRequest = '<?xml version="1.0" encoding="UTF-8"?> 
    <Request> 
        <UsernameToken> 
            <Username>IA</Username> 
            <SessionToken>k1PrvR7fQUJYF563OtTx</SessionToken> 
        </UsernameToken> 
        <RequestParameters> 
            <f4indexno>' . $indexno . '</f4indexno> 
            <ConfirmationCode>' . $confirmcode . '</ConfirmationCode> 
        </RequestParameters> 
    </Request>';

        // Initialize cURL session
        $curl = curl_init();

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/admission/unconfirm', // API endpoint
            CURLOPT_RETURNTRANSFER => true, // Return response as a string
            CURLOPT_ENCODING => '', // Handle all encodings
            CURLOPT_MAXREDIRS => 10, // Max number of redirects
            CURLOPT_TIMEOUT => 0, // No timeout
            CURLOPT_FOLLOWLOCATION => true, // Follow redirects
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // HTTP version
            CURLOPT_CUSTOMREQUEST => 'POST', // POST request
            CURLOPT_POSTFIELDS => $xmlRequest, // The XML request body
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml', // Set content type to XML
            ),
        ));

        // Execute the cURL request and store the response
        $response = curl_exec($curl);
        Log::info("student is " . $response);
        // Check if the cURL request was successful
        if (curl_errno($curl)) {
            // If there was an error, display it
            echo 'cURL Error: ' . curl_error($curl);
        }

        // Get the HTTP response status code
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Optionally, log the status code and response for debugging
        Log::info("HTTP Status Code: " . $http_status);
        Log::info("Response is : " . $response);

        // Close the cURL session
        curl_close($curl);

        // Parse the XML response
        $xml = simplexml_load_string($response);

        // Convert the SimpleXMLElement object to an array (optional)
        $responseArray = json_decode(json_encode($xml), true);

        // Extract values from the response
        $f4indexno = $responseArray['Response']['ResponseParameters']['f4indexno'];
        $statusCode = $responseArray['Response']['ResponseParameters']['StatusCode'];
        $statusDescription = $responseArray['Response']['ResponseParameters']['StatusDescription'];

        // Pass the parsed data to the view
        return redirect()->route('unconfirm.arusha')->with([
            'f4indexno' => $f4indexno,
            'statusCode' => $statusCode,
            'statusDescription' => $statusDescription,
        ]);
    }
    public function getVerificationStatus(Request $request)
    {
        // Set the programme ID manually, or you can retrieve it from the request if necessary
        $programmeid = "IA001";

        $curl = curl_init();

        // Prepare XML data with the Programme Code dynamically inserted
        $xmlData = <<<XML
    <Request>
        <UsernameToken>
            <Username>IA</Username>
            <SessionToken>k1PrvR7fQUJYF563OtTx</SessionToken>
        </UsernameToken>
        <RequestParameters>
            <ProgrammeCode>{$programmeid}</ProgrammeCode>
        </RequestParameters>
    </Request>
    XML;
        // cURL options
        curl_setopt_array($curl, [
            CURLOPT_URL => 'http://api.tcu.go.tz/applicants/getApplicantVerificationStatus',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,  // Adjust timeout as needed
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $xmlData,  // Sending the XML data in POST request
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/xml',
            ],
        ]);
        // Execute cURL request and capture the response
        $response = curl_exec($curl);

        // Check for cURL errors
        if ($response === false) {
            $errorMessage = curl_error($curl);
            curl_close($curl);
            return response()->json(['error' => 'cURL Error: ' . $errorMessage], 500);
        }
        // Close the cURL session after successful execution
        curl_close($curl);
        // Log the raw response for debugging purposes
        Log::info("Response: " . $response);
        // Ensure the response is not empty before proceeding
        if (empty($response)) {
            return response()->json(['error' => 'Empty response from API'], 500);
        }
        // Parse the XML response into an array
        $xml = simplexml_load_string($response);
        if ($xml === false) {
            return response()->json(['error' => 'Failed to parse XML response'], 500);
        }

        // Convert SimpleXML object to JSON, then decode it into an associative array
        $json = json_encode($xml);
        $arrayResponse = json_decode($json, true);  // Decode JSON into an array

        // Log the parsed response for debugging purposes
        Log::info("Parsed Applicants status: ", $arrayResponse);

        // Pass the parsed response to the Blade view
        return view('Admission.Applicants.tcu-programme.get-verification', compact('arrayResponse'));
    }
    public function getProgrammess()
    {
        // Initialize cURL
        $curl = curl_init();
        // Define cURL options for the request
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/admission/getProgrammes',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0, // No timeout
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '<Request>
                                    <UsernameToken>
                                        <Username>IA</Username>
                                        <SessionToken>k1PrvR7fQUJYF563OtTx</SessionToken>
                                    </UsernameToken>
                                   </Request>',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml'
            ),
        ));
        // Execute cURL request and capture the response
        $response = curl_exec($curl);
        // Close cURL session
        curl_close($curl);
        // Check if the response is false or empty
        if ($response === false) {
            return response()->json(['error' => 'Failed to fetch data from API'], 500);
        }
        // Decode the JSON response
        $arrayResponse = json_decode($response, true);
        // Ensure the 'Programme' data exists and handle if it is empty
        $programmes = isset($arrayResponse['Response']['ResponseParameters']['Programme']) ?
            $arrayResponse['Response']['ResponseParameters']['Programme'] : [];
        // Pass the data to the Blade view
        return view('Admission.Applicants.tcu-programme.get-totaladmittedperprogramme', ['programmes' => $programmes]);
    }
    public function getAdmittedList()
    {
        $arushaCampus = Campus::where('name', 'like', '%Arusha%')->pluck('id')->first();
        Log::info($arushaCampus);
        $programtcu = ProgrammeTcu::where('campus_id', $arushaCampus)->get();
        return view('Admission.Applicants.tcu-programme.tcu-getAdmitted', compact('programtcu'));
    }
    public function getAdmittedApplicants(Request $request)
    {
        // Get the programme ID from the request
        $programId = $request->input('programme_id');
        // Log the programme ID for debugging purposes
        Log::info("Programme code: " . $programId);

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/admission/getAdmitted',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "<Request>
            <UsernameToken>
                <Username>IA</Username>
                <SessionToken>k1PrvR7fQUJYF563OtTx</SessionToken>
            </UsernameToken>
            <RequestParameters>
                <ProgrammeCode>{$programId}</ProgrammeCode>
            </RequestParameters>
        </Request>",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml'
            ),
        ));

        // Execute cURL request and get the response
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Get the HTTP status code
        curl_close($curl);

        Log::info('Response Status: ' . $httpCode);
        Log::info('Response: ' . $response);

        // Initialize an empty array to store applicant data
        $applicants = [];
        // Check if the response is successful (StatusCode 200)
        if ($httpCode == 200) {
            // Handle encoding issues
            $response = mb_convert_encoding($response, 'UTF-8', 'auto');
            // Parse the XML response
            $xml = simplexml_load_string($response);
            if ($xml === false) {
                Log::error("Failed to parse XML: " . $response);
                return response()->json(['error' => 'Failed to parse XML response.'], 500);
            }
            // Loop through each Applicant and process the data
            foreach ($xml->Response->ResponseParameters->Applicant as $applicant) {
                $applicants[] = [
                    'f4indexno' => (string) $applicant->f4indexno,
                    'f6indexno' => (string) $applicant->f6indexno,
                    'mobile' => (string) $applicant->MobileNumber,
                    'email' => (string) $applicant->EmailAddress,
                    'admissionStatus' => (string) $applicant->AdmissionStatus,
                ];
            }
        } else {
            Log::error("Failed to get confirmed applicants. HTTP Status Code: $httpCode");
            return response()->json(['error' => 'Failed to retrieve applicants.'], 500);
        }
        Log::info('Parsed applicants data: ' . json_encode($applicants));

        // Return the applicants data as a JSON response
        return redirect()->route('get.admitted.list')->with('applicant', json_encode($applicants));
    }
    public function getProgrammes(Request $request)
    {
        // Initialize cURL
        $curl = curl_init();

        // Set cURL options

        // Define cURL options for the request
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/admission/getProgrammes',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0, // No timeout
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '<Request>
                            <UsernameToken>
                                <Username>IA</Username>
                                <SessionToken>k1PrvR7fQUJYF563OtTx</SessionToken>
                            </UsernameToken>
                           </Request>',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml'
            ),
        ));
        // Execute cURL request and get the response
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Get the HTTP status code
        curl_close($curl);

        Log::info('Response Status: ' . $httpCode);
        Log::info('Response: ' . $response);

        // Initialize an empty array to store applicant data
        $applicants = [];
        // Check if the response is successful (StatusCode 200)
        if ($httpCode == 200) {
            // Handle encoding issues
            $response = mb_convert_encoding($response, 'UTF-8', 'auto');
            // Parse the XML response
            $xml = simplexml_load_string($response);
            if ($xml === false) {
                Log::error("Failed to parse XML: " . $response);
                return response()->json(['error' => 'Failed to parse XML response.'], 500);
            }
            // Loop through each Applicant and process the data
            foreach ($xml->Response->ResponseParameters->Programme as $applicant) {
                $applicants[] = [
                    'programmecode' => (string) $applicant->ProgrammeCode,
                    'total' => (string) $applicant->NumberOfApplicant,
                ];
            }
        } else {
            Log::error("Failed to get confirmed applicants. HTTP Status Code: $httpCode");
            return response()->json(['error' => 'Failed to retrieve applicants.'], 500);
        }
        Log::info('Parsed applicants data: ' . json_encode($applicants));

        // Return the applicants data as a JSON response
        return redirect()->route('totalnumber')->with('applicant', json_encode($applicants));
        //return view('Admission.Applicants.tcu-programme.get-programme', compact('applicant', json_encode($applicants)));
    }
    public function gettotalnumber()
    {
        return view('Admission.Applicants.tcu-programme.get-programme');
    }
    public function checkstatusarusha()
    {
        return view('Admission.Applicants.tcu-programme.checkstatus-arusha');
    }
    public function checkstorearusha(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'indexno' => 'required|string|max:20', // Adjust validation as needed
        ]);

        // Capture the inputs
        $indexno = $validatedData['indexno'];
        // Build the XML request string with proper string interpolation
        $xmlRequest = '<?xml version="1.0" encoding="UTF-8"?> 
    <Request> 
        <UsernameToken> 
            <Username>IA</Username> 
            <SessionToken>k1PrvR7fQUJYF563OtTx</SessionToken>
        </UsernameToken> 
        <RequestParameters> 
            <f4indexno>' . $indexno . '</f4indexno> 
        </RequestParameters> 
    </Request>';

        // Initialize cURL session
        $curl = curl_init();
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/applicants/checkStatus', // API endpoint
            CURLOPT_RETURNTRANSFER => true, // Return response as a string
            CURLOPT_ENCODING => '', // Handle all encodings
            CURLOPT_MAXREDIRS => 10, // Max number of redirects
            CURLOPT_TIMEOUT => 0, // No timeout
            CURLOPT_FOLLOWLOCATION => true, // Follow redirects
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // HTTP version
            CURLOPT_CUSTOMREQUEST => 'POST', // POST request
            CURLOPT_POSTFIELDS => $xmlRequest, // The XML request body
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml', // Set content type to XML
            ),
        ));

        // Execute the cURL request and store the response
        $response = curl_exec($curl);
        // Check if the cURL request was successful
        if (curl_errno($curl)) {
            // If there was an error, display it
            echo 'cURL Error: ' . curl_error($curl);
        }

        // Get the HTTP response status code
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Optionally, log the status code and response for debugging
        Log::info("HTTP Status Code: " . $http_status);
        Log::info("Response is : " . $response);

        // Close the cURL session
        curl_close($curl);

        // Parse the XML response
        $xml = simplexml_load_string($response);

        // Convert the SimpleXMLElement object to an array (optional)
        $responseArray = json_decode(json_encode($xml), true);

        // Extract values from the response
        $f4indexno = $responseArray['Response']['ResponseParameters']['f4indexno'];
        $statusCode = $responseArray['Response']['ResponseParameters']['StatusCode'];
        $statusDescription = $responseArray['Response']['ResponseParameters']['StatusDescription'];

        // Pass the parsed data to the view
        return redirect()->route('check.status.arusha')->with([
            'f4indexno' => $f4indexno,
            'statusCode' => $statusCode,
            'statusDescription' => $statusDescription,
        ]);
    }
    public function getconfirmcodearusha()
    {
        return view('Admission.Applicants.tcu-programme.getconfirmedarusha');
    }
    public function postconfirmcodearusha(Request $request)
    {
        // Retrieving input data from the request
        $f4indexno = $request->input('indexno');
        $email = $request->input('email');
        $mobile = $request->input('mobile');

        // Initialize cURL session
        $curl = curl_init();

        // Prepare the XML data with proper string interpolation
        $xmlData = '<?xml version="1.0" encoding="UTF-8"?> 
<Request> 
  <UsernameToken> 
    <Username>IA</Username> 
    <SessionToken>k1PrvR7fQUJYF563OtTx</SessionToken> 
  </UsernameToken> 
  <RequestParameters> 
    <f4indexno>' . $f4indexno . '</f4indexno> 
    <MobileNumber>' . $mobile . '</MobileNumber> 
    <EmailAddress>' . $email . '</EmailAddress> 
  </RequestParameters> 
</Request>';

        // cURL setup
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/admission/requestConfirmationCode',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $xmlData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml',
            ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        // Parse the XML response
        $xml = simplexml_load_string($response);

        // Convert the SimpleXMLElement object to an array (optional)
        $responseArray = json_decode(json_encode($xml), true);

        // Extract values from the response
        $f4indexno = $responseArray['Response']['ResponseParameters']['f4indexno'];
        $statusCode = $responseArray['Response']['ResponseParameters']['StatusCode'];
        $statusDescription = $responseArray['Response']['ResponseParameters']['StatusDescription'];

        // Pass the parsed data to the view
        return redirect()->route('get.code.arusha')->with([
            'f4indexno' => $f4indexno,
            'statusCode' => $statusCode,
            'statusDescription' => $statusDescription,
        ]);
    }
    //DAR CAMPUS
    public function getConfirmapplicantsdar()
    {
        $arushaCampus = Campus::where('name', 'like', '%Dar%')->pluck('id')->first();
        Log::info($arushaCampus);
        $programtcu = ProgrammeTcu::where('campus_id', $arushaCampus)->get();
        $applicant = [];
        return view('Admission.Applicants.tcu-programme.getConfirmedApplicantdar', compact('programtcu', 'applicant'));
    }
    public function getConfirapplicantdar(Request $request)
    {
        // Get the programme ID from the request
        $programId = $request->input('programme_id');
        // Log the programme ID for debugging purposes
        Log::info("Programme code: " . $programId);

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/applicants/getConfirmed',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "<Request>
            <UsernameToken>
                <Username>IAD</Username>
                <SessionToken>`9BGrT8RST6BhL6nagJpP`</SessionToken>
            </UsernameToken>
            <RequestParameters>
                <ProgrammeCode>{$programId}</ProgrammeCode>
            </RequestParameters>
        </Request>",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml'
            ),
        ));

        // Execute cURL request and get the response
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Get the HTTP status code
        curl_close($curl);

        Log::info('Response Status: ' . $httpCode);
        Log::info('Response: ' . $response);

        // Initialize an empty array to store applicant data
        $applicants = [];
        // Check if the response is successful (StatusCode 200)
        if ($httpCode == 200) {
            // Handle encoding issues
            $response = mb_convert_encoding($response, 'UTF-8', 'auto');
            // Parse the XML response
            $xml = simplexml_load_string($response);
            if ($xml === false) {
                Log::error("Failed to parse XML: " . $response);
                return response()->json(['error' => 'Failed to parse XML response.'], 500);
            }

            // Loop through each Applicant and process the data
            foreach ($xml->Response->ResponseParameters->Applicant as $applicant) {
                $applicants[] = [
                    'f4indexno' => (string) $applicant->f4indexno,
                    'f6indexno' => (string) $applicant->f6indexno,
                    'diploma' => (string) $applicant->DiplomaRegNo,
                    'programmeCode' => (string) $applicant->ProgrammeCode,
                    'admissionStatus' => (string) $applicant->AdmissionStatus,
                ];
            }
        } else {
            Log::error("Failed to get confirmed applicants. HTTP Status Code: $httpCode");
            return response()->json(['error' => 'Failed to retrieve applicants.'], 500);
        }
        Log::info('Parsed applicants data: ' . json_encode($applicants));

        // Return the applicants data as a JSON response
        return redirect()->route('getconfirmed.arusha')->with('applicant', json_encode($applicants));
    }
    public function sendtoDarTcu()
    {
        $arushaCampus = Campus::where('name', 'like', '%Dar campus%')->pluck('id')->first();
        $programtcu = ProgrammeTcu::where('campus_id', $arushaCampus)->get();
        Log::info("programme is " . $programtcu->count());
        $responsetcu = [];
        $responsecode = [];
        return view('Admission.Applicants.tcu-programme.sendselectedtcudar', compact('programtcu', 'responsetcu'));
    }
    public function sendbachelorapplicantdar(Request $request)
    {
        $darCampus = Campus::where('name', 'like', '%Dar Campus%')->pluck('id')->first();
        $programId = $request->input('programme_id');
        $academicYear = AcademicYear::where('active', 1)->first();
        $intake = Intake::where('active', 1)->first();
        $year = date("Y");

        Log::info("Programme ID " . $programId);
        Log::info("campus " . $darCampus);


        // Get the applicant IDs for the selected program, year, and intake
        $applicantIds = SelectedDiplomaCertificate::where('iaa_programme_code', $programId)
            ->where('application_year', $year)
            ->where('campus_id', $darCampus)
            ->where('intake', $intake->id)
            ->pluck('applicant_user_id');

        Log::info("Applicants are: " . $applicantIds);

        $responsetcu = [];
        $responsecode = [];
        $indexnumber = [];

        // Loop through each applicant
        foreach ($applicantIds as $applicant) {
            // Get F4 results
            $fourresults = Form4Result::where('applicant_user_id', $applicant)
                ->select('index_no')
                ->distinct()
                ->orderBy('id', 'asc')
                ->take(2)
                ->get();

            $firstF4 = $fourresults->get(0)?->index_no ?? '';
            $secondF4 = $fourresults->get(1)?->index_no ?? null;

            if ($firstF4) Log::info("First F4 Index Number: " . $firstF4);
            if ($secondF4) Log::info("Second F4 Index Number: " . $secondF4);
            if (!$firstF4) Log::info("No F4 Index Number found for applicant ID: $applicant");


            // Get Form 6 results
            $sixresults = Form6Result::where('applicant_user_id', $applicant)
                ->select('qualification_no')
                ->distinct()
                ->orderBy('id', 'asc')
                ->take(2)
                ->get();
            $firstF6 = $sixresults->get(0)?->qualification_no ?? '';
            $secondF6 = $sixresults->get(1)?->qualification_no ?? null;
            if ($firstF6) Log::info("First F6 Index Number: " . $firstF6);
            if ($secondF6) Log::info("Second F6 Index Number: " . $secondF6);
            if (!$firstF6) Log::info("No F6 Index Number found for applicant ID: $applicant");

            // Get applicant's choices
            $applicantChoice = ApplicantsChoice::where('applicant_user_id', $applicant)->first();
            if ($applicantChoice) {
                $tcucode1 = ProgrammeTcu::where('iaa_programme_id', $applicantChoice->choice1)->where('campus_id',$darCampus)->first();
                $tcucode2 = ProgrammeTcu::where('iaa_programme_id', $applicantChoice->choice2)->where('campus_id',$darCampus)->first();
                $tcucode3 = ProgrammeTcu::where('iaa_programme_id', $applicantChoice->choice3)->where('campus_id',$darCampus)->first();

                // Check if choices exist
                if ($tcucode1 && $tcucode2 && $tcucode3) {
                    Log::info("Choice One: " .$tcucode1);
                    Log::info("Choice Two: " . $tcucode2->tcu_code);
                    Log::info("Choice Three: " . $tcucode3->tcu_code);
                } else {
                    Log::error("Some program choices are missing for applicant: $applicant");
                }
            }

            // Selected programme
            $selectedTcuCode = ProgrammeTcu::where('iaa_programme_id', $programId)->where('campus_id',$darCampus)->first();
            if ($selectedTcuCode) {
                Log::info("Selected Programme: " . $selectedTcuCode);
            } else {
                Log::error("Selected programme not found for program ID: $programId");
            }

            // Get applicant info
            $applicantUser = ApplicantsUser::where('id', $applicant)->first();
            if ($applicantUser) {
                Log::info("Email: " . $applicantUser->email);
                Log::info("Mobile: " . $applicantUser->mobile_no);
            } else {
                Log::error("Applicant user not found: $applicant");
            }

            // Get applicant additional info
            $applicantInfo = ApplicantsInfo::where('applicant_user_id', $applicant)->first();
            if ($applicantInfo) {
                Log::info("Gender: " . $applicantInfo->gender);
                Log::info("Birth Date: " . $applicantInfo->birth_date);
            } else {
                Log::error("Applicant info not found for applicant: $applicant");
            }

            // Prepare curl request
            $curl = curl_init();

            // Set default values if data is not available
            $gender = $applicantInfo->gender ?? 'M';  // Default to 'M' if not available
            $mobileNo = $applicantUser->mobile_no ?? '0766345678';  // Use fallback if null
            $email = $applicantUser->email ?? 'example@example.com';  // Use fallback if null
            $birthDate = $applicantInfo->birth_date ?? '2000-01-01';  // Use fallback if null

            $postFields = "
        <Request>
            <UsernameToken>
                <Username>IAD</Username>
                <SessionToken>9BGrT8RST6BhL6nagJpP</SessionToken>
            </UsernameToken>
            <RequestParameters>
                <f4indexno>{$firstF4}</f4indexno>
                <f6indexno>{$firstF6}</f6indexno>
                <Gender>{$gender}</Gender>
                <SelectedProgrammes>{$tcucode1->tcu_code}, {$tcucode2->tcu_code}, {$tcucode3->tcu_code}</SelectedProgrammes>
                <MobileNumber>{$mobileNo}</MobileNumber>
                <OtherMobileNumber>{$applicantUser->mobile_no}</OtherMobileNumber>
                <EmailAddress>{$email}</EmailAddress>
                <Category>A</Category>
                <AdmissionStatus>provisional admission</AdmissionStatus>
                <ProgrammeAdmitted>{$selectedTcuCode->tcu_code}</ProgrammeAdmitted>
                <Reason>eligible</Reason>
                <Nationality>Tanzanian</Nationality>
                <Impairment>None</Impairment>
                <DateOfBirth>{$birthDate}</DateOfBirth>
                <NationalIdNumber>19620228-00001-00001-19</NationalIdNumber>
                <Otherf4indexno>{$secondF4}</Otherf4indexno>
                <Otherf6indexno>{$secondF6}</Otherf6indexno>
            </RequestParameters>
        </Request>";

            curl_setopt_array($curl, [
                CURLOPT_URL => 'http://api.tcu.go.tz/applicants/submitProgramme',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $postFields,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json'
                ],
            ]);

            $response = curl_exec($curl);
            curl_close($curl);
            Log::info("My payload is " . $postFields);
            if ($response) {
                // Parse XML response
                $xml = simplexml_load_string($response);
                Log::info("programme is " . $xml);
                // Convert the SimpleXML object to an array for easier access
                $indexnumber[] = $fourresults[0]->index_no;
                $xmlArray = json_decode(json_encode($xml), true);
                $responsetcu[] = $xmlArray['Response']['ResponseParameters']['StatusCode'];
                $responsecode[] = $xmlArray['Response']['ResponseParameters']['StatusDescription'];

                // Log the response parameters
                Log::info("Response StatusCode: " . $xmlArray['Response']['ResponseParameters']['StatusCode']);
                Log::info("Response StatusDescription: " . $xmlArray['Response']['ResponseParameters']['StatusDescription']);
            } else {
                Log::error("No response received from cURL request.");
            }
        }
        return redirect()->route('sendtcu.dar')->with([
            'responsetcu' => (array)$responsetcu,
            'responsecode' => (array)$responsecode,
            'indexnumber' => (array) $indexnumber  // Convert to array if not already
        ]);
    }
    //confirm 
    public function confirmdar()
    {
        return view('Admission.Applicants.tcu-programme.tcu-confirmeddar');
    }
    public function confirmstoredar(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'indexno' => 'required|string|max:20', // Adjust validation as needed
            'confirm' => 'required|string|max:20', // Adjust validation as needed
        ]);

        // Capture the inputs
        $indexno = $validatedData['indexno'];
        $confirmcode = $validatedData['confirm'];

        // Build the XML request string with proper string interpolation
        $xmlRequest = '<?xml version="1.0" encoding="UTF-8"?> 
    <Request> 
        <UsernameToken> 
            <Username>IAD</Username> 
            <SessionToken>9BGrT8RST6BhL6nagJpP</SessionToken>
        </UsernameToken> 
        <RequestParameters> 
            <f4indexno>' . $indexno . '</f4indexno> 
            <ConfirmationCode>' . $confirmcode . '</ConfirmationCode> 
        </RequestParameters> 
    </Request>';

        // Initialize cURL session
        $curl = curl_init();

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/admission/confirm', // API endpoint
            CURLOPT_RETURNTRANSFER => true, // Return response as a string
            CURLOPT_ENCODING => '', // Handle all encodings
            CURLOPT_MAXREDIRS => 10, // Max number of redirects
            CURLOPT_TIMEOUT => 0, // No timeout
            CURLOPT_FOLLOWLOCATION => true, // Follow redirects
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // HTTP version
            CURLOPT_CUSTOMREQUEST => 'POST', // POST request
            CURLOPT_POSTFIELDS => $xmlRequest, // The XML request body
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml', // Set content type to XML
            ),
        ));

        // Execute the cURL request and store the response
        $response = curl_exec($curl);

        // Check if the cURL request was successful
        if (curl_errno($curl)) {
            // If there was an error, display it
            echo 'cURL Error: ' . curl_error($curl);
        }

        // Get the HTTP response status code
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Optionally, log the status code and response for debugging
        Log::info("HTTP Status Code: " . $http_status);
        Log::info("Response is : " . $response);

        // Close the cURL session
        curl_close($curl);

        // Parse the XML response
        $xml = simplexml_load_string($response);

        // Convert the SimpleXMLElement object to an array (optional)
        $responseArray = json_decode(json_encode($xml), true);

        // Extract values from the response
        $f4indexno = $responseArray['Response']['ResponseParameters']['f4indexno'];
        $statusCode = $responseArray['Response']['ResponseParameters']['StatusCode'];
        $statusDescription = $responseArray['Response']['ResponseParameters']['StatusDescription'];

        // Pass the parsed data to the view
        return redirect()->route('confirm.arusha')->with([
            'f4indexno' => $f4indexno,
            'statusCode' => $statusCode,
            'statusDescription' => $statusDescription,
        ]);
    }
    public function unconfirmdar()
    {
        return view('Admission.Applicants.tcu-programme.tcu-unconfirmeddar');
    }
    public function unconfirmstoredar(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'indexno' => 'required|string|max:20', // Adjust validation as needed
            'confirm' => 'required|string|max:20', // Adjust validation as needed
        ]);

        // Capture the inputs
        $indexno = $validatedData['indexno'];
        $confirmcode = $validatedData['confirm'];

        // Build the XML request string with proper string interpolation
        $xmlRequest = '<?xml version="1.0" encoding="UTF-8"?> 
    <Request> 
        <UsernameToken> 
            <Username>IAD</Username> 
            <SessionToken>9BGrT8RST6BhL6nagJpP</SessionToken>
        </UsernameToken> 
        <RequestParameters> 
            <f4indexno>' . $indexno . '</f4indexno> 
            <ConfirmationCode>' . $confirmcode . '</ConfirmationCode> 
        </RequestParameters> 
    </Request>';

        // Initialize cURL session
        $curl = curl_init();

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/admission/unconfirm', // API endpoint
            CURLOPT_RETURNTRANSFER => true, // Return response as a string
            CURLOPT_ENCODING => '', // Handle all encodings
            CURLOPT_MAXREDIRS => 10, // Max number of redirects
            CURLOPT_TIMEOUT => 0, // No timeout
            CURLOPT_FOLLOWLOCATION => true, // Follow redirects
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // HTTP version
            CURLOPT_CUSTOMREQUEST => 'POST', // POST request
            CURLOPT_POSTFIELDS => $xmlRequest, // The XML request body
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml', // Set content type to XML
            ),
        ));

        // Execute the cURL request and store the response
        $response = curl_exec($curl);
        Log::info("student is " . $response);
        // Check if the cURL request was successful
        if (curl_errno($curl)) {
            // If there was an error, display it
            echo 'cURL Error: ' . curl_error($curl);
        }

        // Get the HTTP response status code
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Optionally, log the status code and response for debugging
        Log::info("HTTP Status Code: " . $http_status);
        Log::info("Response is : " . $response);

        // Close the cURL session
        curl_close($curl);

        // Parse the XML response
        $xml = simplexml_load_string($response);

        // Convert the SimpleXMLElement object to an array (optional)
        $responseArray = json_decode(json_encode($xml), true);

        // Extract values from the response
        $f4indexno = $responseArray['Response']['ResponseParameters']['f4indexno'];
        $statusCode = $responseArray['Response']['ResponseParameters']['StatusCode'];
        $statusDescription = $responseArray['Response']['ResponseParameters']['StatusDescription'];

        // Pass the parsed data to the view
        return redirect()->route('unconfirm.arusha')->with([
            'f4indexno' => $f4indexno,
            'statusCode' => $statusCode,
            'statusDescription' => $statusDescription,
        ]);
    }
    public function getVerificationStatusdar(Request $request)
    {
        // Set the programme ID manually, or you can retrieve it from the request if necessary
        $programmeid = "IA001";

        $curl = curl_init();

        // Prepare XML data with the Programme Code dynamically inserted
        $xmlData = <<<XML
    <Request>
        <UsernameToken>
            <Username>IA</Username>
            <SessionToken>k1PrvR7fQUJYF563OtTx</SessionToken>
        </UsernameToken>
        <RequestParameters>
            <ProgrammeCode>{$programmeid}</ProgrammeCode>
        </RequestParameters>
    </Request>
    XML;
        // cURL options
        curl_setopt_array($curl, [
            CURLOPT_URL => 'http://api.tcu.go.tz/applicants/getApplicantVerificationStatus',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,  // Adjust timeout as needed
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $xmlData,  // Sending the XML data in POST request
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/xml',
            ],
        ]);
        // Execute cURL request and capture the response
        $response = curl_exec($curl);

        // Check for cURL errors
        if ($response === false) {
            $errorMessage = curl_error($curl);
            curl_close($curl);
            return response()->json(['error' => 'cURL Error: ' . $errorMessage], 500);
        }
        // Close the cURL session after successful execution
        curl_close($curl);
        // Log the raw response for debugging purposes
        Log::info("Response: " . $response);
        // Ensure the response is not empty before proceeding
        if (empty($response)) {
            return response()->json(['error' => 'Empty response from API'], 500);
        }
        // Parse the XML response into an array
        $xml = simplexml_load_string($response);
        if ($xml === false) {
            return response()->json(['error' => 'Failed to parse XML response'], 500);
        }

        // Convert SimpleXML object to JSON, then decode it into an associative array
        $json = json_encode($xml);
        $arrayResponse = json_decode($json, true);  // Decode JSON into an array

        // Log the parsed response for debugging purposes
        Log::info("Parsed Applicants status: ", $arrayResponse);

        // Pass the parsed response to the Blade view
        return view('Admission.Applicants.tcu-programme.get-verification', compact('arrayResponse'));
    }

    public function getAdmittedListdar()
    {
        $arushaCampus = Campus::where('name', 'like', '%Dar%')->pluck('id')->first();
        Log::info($arushaCampus);
        $programtcu = ProgrammeTcu::where('campus_id', $arushaCampus)->get();
        return view('Admission.Applicants.tcu-programme.tcu-getAdmitteddar', compact('programtcu'));
    }
    public function getAdmittedApplicantsdar(Request $request)
    {
        // Get the programme ID from the request
        $programId = $request->input('programme_id');
        // Log the programme ID for debugging purposes
        Log::info("Programme code: " . $programId);

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/admission/getAdmitted',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "<Request>
            <UsernameToken>
                <Username>IAD</Username>
                <SessionToken>9BGrT8RST6BhL6nagJpP</SessionToken>
            </UsernameToken>
            <RequestParameters>
                <ProgrammeCode>{$programId}</ProgrammeCode>
            </RequestParameters>
        </Request>",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml'
            ),
        ));

        // Execute cURL request and get the response
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Get the HTTP status code
        curl_close($curl);

        Log::info('Response Status: ' . $httpCode);
        Log::info('Response: ' . $response);

        // Initialize an empty array to store applicant data
        $applicants = [];
        // Check if the response is successful (StatusCode 200)
        if ($httpCode == 200) {
            // Handle encoding issues
            $response = mb_convert_encoding($response, 'UTF-8', 'auto');
            // Parse the XML response
            $xml = simplexml_load_string($response);
            if ($xml === false) {
                Log::error("Failed to parse XML: " . $response);
                return response()->json(['error' => 'Failed to parse XML response.'], 500);
            }
            // Loop through each Applicant and process the data
            foreach ($xml->Response->ResponseParameters->Applicant as $applicant) {
                $applicants[] = [
                    'f4indexno' => (string) $applicant->f4indexno,
                    'f6indexno' => (string) $applicant->f6indexno,
                    'mobile' => (string) $applicant->MobileNumber,
                    'email' => (string) $applicant->EmailAddress,
                    'admissionStatus' => (string) $applicant->AdmissionStatus,
                ];
            }
        } else {
            Log::error("Failed to get confirmed applicants. HTTP Status Code: $httpCode");
            return response()->json(['error' => 'Failed to retrieve applicants.'], 500);
        }
        Log::info('Parsed applicants data: ' . json_encode($applicants));

        // Return the applicants data as a JSON response
        return redirect()->route('get.admitted.list')->with('applicant', json_encode($applicants));
    }
    public function getProgrammesdar(Request $request)
    {
        // Initialize cURL
        $curl = curl_init();

        // Set cURL options

        // Define cURL options for the request
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/admission/getProgrammes',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0, // No timeout
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '<Request>
                            <UsernameToken>
                                <Username>IAD</Username>
                                <SessionToken>9BGrT8RST6BhL6nagJpP</SessionToken>
                             </UsernameToken>
                           </Request>',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml'
            ),
        ));
        // Execute cURL request and get the response
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Get the HTTP status code
        curl_close($curl);

        Log::info('Response Status: ' . $httpCode);
        Log::info('Response: ' . $response);

        // Initialize an empty array to store applicant data
        $applicants = [];
        // Check if the response is successful (StatusCode 200)
        if ($httpCode == 200) {
            // Handle encoding issues
            $response = mb_convert_encoding($response, 'UTF-8', 'auto');
            // Parse the XML response
            $xml = simplexml_load_string($response);
            if ($xml === false) {
                Log::error("Failed to parse XML: " . $response);
                return response()->json(['error' => 'Failed to parse XML response.'], 500);
            }
            // Loop through each Applicant and process the data
            foreach ($xml->Response->ResponseParameters->Programme as $applicant) {
                $applicants[] = [
                    'programmecode' => (string) $applicant->ProgrammeCode,
                    'total' => (string) $applicant->NumberOfApplicant,
                ];
            }
        } else {
            Log::error("Failed to get confirmed applicants. HTTP Status Code: $httpCode");
            return response()->json(['error' => 'Failed to retrieve applicants.'], 500);
        }
        Log::info('Parsed applicants data: ' . json_encode($applicants));

        // Return the applicants data as a JSON response
        return redirect()->route('totalnumber')->with('applicant', json_encode($applicants));
        //return view('Admission.Applicants.tcu-programme.get-programme', compact('applicant', json_encode($applicants)));
    }
    public function gettotalnumberdar()
    {
        return view('Admission.Applicants.tcu-programme.get-programmedar');
    }
    public function checkstatusdar()
    {
        return view('Admission.Applicants.tcu-programme.checkstatus-dar');
    }
    public function checkstoredar(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'indexno' => 'required|string|max:20', // Adjust validation as needed
        ]);

        // Capture the inputs
        $indexno = $validatedData['indexno'];

        // Build the XML request string with proper string interpolation
        $xmlRequest = '<?xml version="1.0" encoding="UTF-8"?> 
        <Request> 
            <UsernameToken> 
                <Username>IAD</Username> 
                <SessionToken>9BGrT8RST6BhL6nagJpP</SessionToken>
            </UsernameToken> 
            <RequestParameters> 
                <f4indexno>' . $indexno . '</f4indexno> 
            </RequestParameters> 
        </Request>';

        // Initialize cURL session
        $curl = curl_init();

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/applicants/checkStatus', // API endpoint
            CURLOPT_RETURNTRANSFER => true, // Return response as a string
            CURLOPT_ENCODING => '', // Handle all encodings
            CURLOPT_MAXREDIRS => 10, // Max number of redirects
            CURLOPT_TIMEOUT => 0, // No timeout
            CURLOPT_FOLLOWLOCATION => true, // Follow redirects
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // HTTP version
            CURLOPT_CUSTOMREQUEST => 'POST', // POST request
            CURLOPT_POSTFIELDS => $xmlRequest, // The XML request body
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml', // Set content type to XML
            ),
        ));

        // Execute the cURL request and store the response
        $response = curl_exec($curl);

        // Check if the cURL request was successful
        if (curl_errno($curl)) {
            // If there was an error, display it
            echo 'cURL Error: ' . curl_error($curl);
        }

        // Get the HTTP response status code
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Optionally, log the status code and response for debugging
        Log::info("HTTP Status Code: " . $http_status);
        Log::info("Response is : " . $response);

        // Close the cURL session
        curl_close($curl);

        // Parse the XML response
        $xml = simplexml_load_string($response);

        // Convert the SimpleXMLElement object to an array (optional)
        $responseArray = json_decode(json_encode($xml), true);

        // Extract values from the response
        $f4indexno = $responseArray['Response']['ResponseParameters']['f4indexno'];
        $statusCode = $responseArray['Response']['ResponseParameters']['StatusCode'];
        $statusDescription = $responseArray['Response']['ResponseParameters']['StatusDescription'];

        // Pass the parsed data to the view
        return redirect()->route('check.status.dar')->with([
            'f4indexno' => $f4indexno,
            'statusCode' => $statusCode,
            'statusDescription' => $statusDescription,
        ]);
    }
    public function getconfirmcodedar()
    {
        return view('Admission.Applicants.tcu-programme.getconfirmedarusha');
    }
    public function postconfirmcodedar(Request $request)
    {
        // Retrieving input data from the request
        $f4indexno = $request->input('indexno');
        $email = $request->input('email');
        $mobile = $request->input('mobile');

        // Initialize cURL session
        $curl = curl_init();

        // Prepare the XML data with proper string interpolation
        $xmlData = '<?xml version="1.0" encoding="UTF-8"?> 
<Request> 
  <UsernameToken> 
    <Username>IAD</Username> 
    <SessionToken>9BGrT8RST6BhL6nagJpP</SessionToken> 
  </UsernameToken> 
  <RequestParameters> 
    <f4indexno>' . $f4indexno . '</f4indexno> 
    <MobileNumber>' . $mobile . '</MobileNumber> 
    <EmailAddress>' . $email . '</EmailAddress> 
  </RequestParameters> 
</Request>';

        // cURL setup
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.tcu.go.tz/admission/requestConfirmationCode',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $xmlData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml',
            ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        // Parse the XML response
        $xml = simplexml_load_string($response);

        // Convert the SimpleXMLElement object to an array (optional)
        $responseArray = json_decode(json_encode($xml), true);

        // Extract values from the response
        $f4indexno = $responseArray['Response']['ResponseParameters']['f4indexno'];
        $statusCode = $responseArray['Response']['ResponseParameters']['StatusCode'];
        $statusDescription = $responseArray['Response']['ResponseParameters']['StatusDescription'];

        // Pass the parsed data to the view
        return redirect()->route('get.code.dar')->with([
            'f4indexno' => $f4indexno,
            'statusCode' => $statusCode,
            'statusDescription' => $statusDescription,
        ]);
    }
}

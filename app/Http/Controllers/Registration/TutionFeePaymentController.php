<?php

namespace App\Http\Controllers\Registration;

use App\Models\Campus;
use App\Models\Programme;
use App\Models\TutionFee;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Models\ApplicationLevel;
use App\Models\ApplicantsPayment;
use Illuminate\Support\Facades\DB;
use App\Models\RegistrationPayment;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Intake;
use Dotenv\Util\Regex;

class TutionFeePaymentController extends Controller
{
    public function index(Request $request){
         $programmes=Programme::all();
         $campuses=Campus::all();
         $intakes=Intake::all();
         $academicYears=AcademicYear::all();
//$query = RegistrationPayment::whereNot('control_no', 0);

        $programmeId = $request->input('programme_id');
        $campusId = $request->input('campus_id');
        $gender = $request->input('gender');
        $academic=$request->input('academic_year_id');
        $intake=$request->input('intake_id');
        $registeredpayment = RegistrationPayment::when($programmeId, function ($query) use ($programmeId) {
            $query->where('programme_id', $programmeId);
        })->when($campusId, function ($query) use ($campusId) {
            $query->where('campus_id', $campusId);
        })->when($academic,function($query) use ($academic){
          $query->where('academic_year_id',$academic);
        })->when($intake,function($query) use ($intake){
          $query->where('intake_id',$intake);
        })->whereNot('control_no', 0)->get();
          return view('registrations.registered-payment',compact('registeredpayment','programmes','campuses','intakes','academicYears'));
        
    }
    public function payment()
    {
        $indexnumber = 'S5344-0063-2022';
        $programmeid = 5;
        $program = Programme::where('id', $programmeid)->first();
        $bachelor = ApplicationLevel::where('name', 'LIKE', '%bachelor')->pluck('id');
        Log::info("programme " . $programmeid);

        // Take tuition fee
        $tution = TutionFee::where('level_id', $program->application_level_id)
            ->where('computing', $program->computing)
            ->first();

        Log::info("Total Amount " . $tution->amount);

        // Calculate 40% of the tuition fee
        $totalfee = 0;
        $fortyPercent = $tution->amount * 0.40;
        Log::info("40% of tuition fee: " . $fortyPercent);

        // Check if level_id is 1, then assign loan amount
        if ($tution->level_id == 1) {
            $loanAmount = 400000;  // Assuming loan amount is 400,000 if level_id is 1
            Log::info("Loan Amount: " . $loanAmount);
        } else {
            $loanAmount = 0;  // No loan for other levels
        }

        // Check if student has a loan and adjust total fee
        if ($loanAmount) {
            $totalfee = $fortyPercent - $loanAmount;
        } else {
            $totalfee = $fortyPercent;
        }

        Log::info("Total fee to pay " . $totalfee);
        $totalbeforeperc=$tution->amount;
        $controlpayment = RegistrationPayment::where('index_no', $indexnumber)->whereNot('control_no', 0)->get();
        $applicationfee =ApplicantsPayment::where('index_no', $indexnumber)->whereNot('control_no', 0)->get();

         return view('registrations.createbill', compact('totalfee', 'indexnumber', 'controlpayment','totalbeforeperc','loanAmount','applicationfee'));
    }
    // public function createBillId(Request $request)
    // {
    //     // Validate the incoming request data
    //     $request->validate([
    //         'index_no' => 'required|string',
    //         'amount' => 'required|numeric',
    //     ]);

    //     $indexNumber = $request->input('index_no');
    //     $totalAmount = $request->input('amount');

    //     // Prepare data for the API request
    //     $name = "sayi mlasa";
    //     $phone = '0785987184';
    //     $email = 'sayi.mlasa@gmail.com';
    //     $indexNo = $indexNumber; // Static BillItemRef

    //     $userAuth = "chibe.chris";   // Replace with env('USER_AUTH') for production
    //     $password = "atc@123#2019";  // Replace with env('PASSWORD') for production

    //     // Ensure credentials are available
    //     if (empty($userAuth) || empty($password)) {
    //         return response()->json(['error' => 'API credentials are missing.'], 500);
    //     }

    //     // Request data for the API
    //     $requestData = [
    //         "PyrName" => $name,
    //         "PyrCellNum" => $phone,
    //         "PyrEmail" => $email,
    //         "GfsCode" => ["142201610604"],
    //         "BillItemAmt" => [$totalAmount],
    //         "Ccy" => "TZS",
    //         "UserAuth" => $userAuth,
    //         "Password" => $password,
    //         "BillAmt" => $totalAmount,
    //         "BillItemQuantity" => [1],
    //         "BillDesc" => "Application fees",
    //         "BillItemRef" => [$indexNo],
    //         "ExchangeRateAmount" => "1.00"
    //     ];

    //     // Convert array to JSON
    //     $jsonRequest = json_encode($requestData);
    //     Log::info("Request Payload: " . $jsonRequest);

    //     // API URL
    //     $url = 'http://196.41.62.108:8080/engine/public/api/bill/create';

    //     // Send the request via cURL to create a new bill
    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonRequest);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //     // Execute the request and handle errors
    //     $result = curl_exec($ch);
    //     if (curl_errno($ch)) {
    //         curl_close($ch);
    //         return response()->json(['error' => 'cURL Error: ' . curl_error($ch)], 500);
    //     }

    //     // Get HTTP response code
    //     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //     curl_close($ch);

    //     if ($httpCode != 200) {
    //         return response()->json(['error' => 'API request failed with status code ' . $httpCode], 500);
    //     }

    //     // Decode the response
    //     $apiResponse = json_decode($result, true);
    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         return response()->json(['error' => 'Error decoding API response.'], 500);
    //     }

    //     // Check if 'billId' exists in the response
    //     if (isset($apiResponse['billId'])) {
    //         $billId = $apiResponse['billId'];
    //         Log::info("Bill ID: " . $billId);

    //         // Create payment record in the database
    //         $payment = RegistrationPayment::create([
    //             'control_no' => '0',  // Default control number
    //             'billId' => $billId,
    //             'index_no' => $indexNo,
    //             'amount' => $totalAmount,
    //             'date_request' => now(),
    //         ]);

    //         Log::info('Tuition payment details: ', ['payment' => $payment]);
    //     }

    //     // Check if the bill already exists in the database by `index_no`
    //     $existingPayment = DB::table('registration_payments')->where('index_no', $indexNo)->first();

    //     if ($existingPayment) {
    //         // Bill exists, check if a control number has been generated
    //         if (!$existingPayment->control_no || $existingPayment->control_no === '0') {
    //             // API request for control number generation
    //             $controlData = ['bil' => $existingPayment->billId];
    //             $controlUrl = "http://196.41.62.108:8080/control_api.php";

    //             $handle = curl_init($controlUrl);
    //             curl_setopt($handle, CURLOPT_POST, true);
    //             curl_setopt($handle, CURLOPT_POSTFIELDS, $controlData);
    //             curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

    //             // Execute control API request
    //             $controlResponse = curl_exec($handle);
    //             if (curl_errno($handle)) {
    //                 curl_close($handle);
    //                 return response()->json(['error' => 'cURL Error: ' . curl_error($handle)], 500);
    //             }

    //             curl_close($handle);

    //             // Decode the control response
    //             $apiControlResponse = json_decode($controlResponse, true);
    //             if (json_last_error() !== JSON_ERROR_NONE) {
    //                 return response()->json(['error' => 'Error decoding control API response.'], 500);
    //             }

    //             $controlNumber = $apiControlResponse['control'];
    //             $error = $apiControlResponse['error'];
    //             Log::info('Control Number: ' . $controlNumber);

    //             // If control number is valid, update the database
    //             if ($error == 0 && $controlNumber != 7101) {
    //                 $controlNo=DB::table('registration_payments')
    //                     ->where('billId', $existingPayment->billId)
    //                     ->update(['control_no' => $controlNumber],
    //                               ['date_request'=>now()]);
    //                   Log::info($controlNo);          
    //             }
    //         }
    //     }
    //      return redirect()->route('payment.tution')->with('success','Bill created and payment processed successfully');
    //     //return response()->json(['message' => 'Bill created and payment processed successfully.'], 200);
    // }
    public function createBillId(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'index_no' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $indexNumber = $request->input('index_no');
        $totalAmount = $request->input('amount');

        // Prepare data for the API request
        $name = "sayi mlasa";
        $phone = '0785987184';
        $email = 'sayi.mlasa@gmail.com';
        $indexNo = $indexNumber; // Static BillItemRef

        $userAuth = "chibe.chris";   // Replace with env('USER_AUTH') for production
        $password = "atc@123#2019";  // Replace with env('PASSWORD') for production

        // Ensure credentials are available
        if (empty($userAuth) || empty($password)) {
            return response()->json(['error' => 'API credentials are missing.'], 500);
        }

        // Request data for the API
        $requestData = [
            "PyrName" => $name,
            "PyrCellNum" => $phone,
            "PyrEmail" => $email,
            "GfsCode" => ["142201610604"],
            "BillItemAmt" => [$totalAmount],
            "Ccy" => "TZS",
            "UserAuth" => $userAuth,
            "Password" => $password,
            "BillAmt" => $totalAmount,
            "BillItemQuantity" => [1],
            "BillDesc" => "Application fees",
            "BillItemRef" => [$indexNo],
            "ExchangeRateAmount" => "1.00"
        ];

        // Convert array to JSON
        $jsonRequest = json_encode($requestData);
        Log::info("Request Payload: " . $jsonRequest);

        // API URL
        $url = 'http://196.41.62.108:8080/engine/public/api/bill/create';

        // Send the request via cURL to create a new bill
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonRequest);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute the request and handle errors
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            curl_close($ch);
            return response()->json(['error' => 'cURL Error: ' . curl_error($ch)], 500);
        }

        // Get HTTP response code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode != 200) {
            return response()->json(['error' => 'API request failed with status code ' . $httpCode], 500);
        }

        // Decode the response
        $apiResponse = json_decode($result, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Error decoding API response.'], 500);
        }

        // Check if 'billId' exists in the response
        if (isset($apiResponse['billId'])) {
            $billId = $apiResponse['billId'];
            Log::info("Bill ID: " . $billId);

            // Create payment record in the database
            $payment = RegistrationPayment::create([
                'control_no' => '0',  // Default control number
                'billId' => $billId,
                'index_no' => $indexNo,
                'amount' => $totalAmount,
                'date_request' => now(),
            ]);

            Log::info('Tuition payment details: ', ['payment' => $payment]);
        }

        // Check if the bill already exists in the database by `index_no`
        $existingPayment = DB::table('registration_payments')->where('index_no', $indexNo)->first();
        if ($existingPayment) {
            // Bill exists, check if a control number has been generated
            if (!$existingPayment->control_no || $existingPayment->control_no === '0') {
                // API request for control number generation
                $controlData = ['bil' => $existingPayment->billId];
                $controlUrl = "http://196.41.62.108:8080/control_api.php";

                $handle = curl_init($controlUrl);
                curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $controlData);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

                // Execute control API request
                $controlResponse = curl_exec($handle);
                if (curl_errno($handle)) {
                    curl_close($handle);
                    return response()->json(['error' => 'cURL Error: ' . curl_error($handle)], 500);
                }

                curl_close($handle);

                // Decode the control response
                $apiControlResponse = json_decode($controlResponse, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json(['error' => 'Error decoding control API response.'], 500);
                }

                $controlNumber = $apiControlResponse['control'];
                $error = $apiControlResponse['error'];
                Log::info('Control Number: ' . $controlNumber);

                // If control number is valid, update the database
                if ($error == 0 && $controlNumber != 7101) {
                    // Save the new control number only if it's not '0'
                    if ($controlNumber != '0') {
                        DB::table('registration_payments')
                            ->where('billId', $existingPayment->billId)
                            ->update(['control_no' => $controlNumber, 'date_request' => now()]);

                        Log::info('Control Number Updated: ' . $controlNumber);
                    }
                }
            }
        }

        // Return a success message after processing
        return redirect()->route('payment.tution')->with('success', 'Bill created and payment processed successfully');
    }
}

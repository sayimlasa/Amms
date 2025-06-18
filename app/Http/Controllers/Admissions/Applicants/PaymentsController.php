<?php

namespace App\Http\Controllers\Admissions\Applicants;

use Illuminate\Http\Request;
use App\Models\ApplicantsPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class PaymentsController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('applicants_user_control_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $controlno = ApplicantsPayment::all();
        return  view('Admission.Applicants.payments.index', compact('controlno'));
    }


    public function create()
    {
        return view("Admission.Applicants.payments.create");
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'email' => 'required|email',
            'mobile' => 'required|string|max:15',
        ]);

        // Prepare data for the API request
        $name = $validated['name'];
        $ph = $validated['mobile'];
        $email = $validated['email'];
        $index_no = "S2992_0330_2020"; // Static BillItemRef
        $amount = $validated['amount']; // Dynamic amount from user input

        // Fetch API credentials securely from environment variables
        $userAuth = "chibe.chris";   // Replace with env('USER_AUTH') for production
        $password = "atc@123#2019";  // Replace with env('PASSWORD') for production

        // Ensure credentials are available
        if (empty($userAuth) || empty($password)) {
            return response()->json(['error' => 'API credentials are missing.'], 500);
        }

        // Check if the bill already exists in the database by `index_id`
        $existingPayment = DB::table('applicants_payments')->where('index_id', $index_no)->first();

        if ($existingPayment) {
            // Bill exists, but we need to check if a control number has been generated
            if (!$existingPayment->control_number || $existingPayment->control_number === '0') {
                // If no control number is assigned, generate and update it

                // API request for control number generation
                $data = ['bil' => $existingPayment->billId];
                $url = "http://196.41.62.108:8080/control_api.php";

                $handle = curl_init($url);
                curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

                // Execute control API request
                $respond = curl_exec($handle);
                if (curl_errno($handle)) {
                    return response()->json(['error' => 'cURL Error: ' . curl_error($handle)], 500);
                }
                curl_close($handle);

                // Decode the response
                $api_response = json_decode($respond, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json(['error' => 'Error decoding control API response.'], 500);
                }

                $c = $api_response['control'];
                $error = $api_response['error'];

                // If control number is valid, update it
                if ($error == 0 && $c != 7101) {
                    DB::table('applicants_payments')
                        ->where('billId', $existingPayment->billId)
                        ->update(['control_number' => $c]);

                    return redirect()->route('application-fee.index')->with('success', 'Control number updated successfully.');
                } else {
                    // If there's an error or the response indicates deletion (c == 7101), delete the record
                    DB::table('applicants_payments')->where('billId', $existingPayment->billId)->delete();
                    return redirect()->back()->with('error', 'Failed to update control number. Bill deleted.');
                }
            } else {
                // If the control number already exists, no need to generate it again
                return redirect()->route('application-fee.index')->with('success', 'Control number already generated.');
            }
        } else {
            // No existing bill, create a new one

            // Request data for the API
            $requestData = [
                "PyrName" => $name,
                "PyrCellNum" => $ph,
                "PyrEmail" => $email,
                "GfsCode" => ["142201610604"],
                "BillItemAmt" => [$amount],
                "Ccy" => "TZS",
                "UserAuth" => $userAuth,
                "Password" => $password,
                "BillAmt" => $amount,
                "BillItemQuantity" => [1],
                "BillDesc" => "Application feess",
                "BillItemRef" => [$index_no],
                "ExchangeRateAmount" => "1.00"
            ];

            // Convert array to JSON
            $jsonRequest = json_encode($requestData);

            // Send the request via cURL to create a new bill
            $url = 'http://196.41.62.108:8080/engine/public/api/bill/create';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonRequest);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            // Execute the request and handle errors
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                return response()->json(['error' => 'cURL Error: ' . curl_error($ch)], 500);
            }

            // Get HTTP response code
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode != 200) {
                return response()->json(['error' => 'API request failed with status code ' . $httpCode], 500);
            }

            // Close cURL session
            curl_close($ch);

            // Decode the response
            $apiResponse = json_decode($result, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json(['error' => 'Error decoding API response.'], 500);
            }

            // Check if 'billId' exists
            if (isset($apiResponse['billId'])) {
                $billId = $apiResponse['billId'];
                //print_r($billId);die();
                // Create payment record
                ApplicantsPayment::create([
                    'control_number' => '0',  // Default control number
                    'billId' => $billId,
                    'name' => $name,
                    'index_id' => $index_no,
                    'amount' => $amount,
                    'generated_at' => now(),
                ]);

                return redirect()->route('application-fee.index')->with('success', 'Bill created successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to create bill.');
            }
        }
    }
    //CREATE BILL ID OF USER
    public function createBillId(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'email' => 'required|email',
            'mobile' => 'required|string|max:15',
        ]);

        // Prepare data for the API request
        $name = $validated['name'];
        $ph = $validated['mobile'];
        $email = $validated['email'];
        $index_no = "S29988_0366_2020"; // Static BillItemRef
        $amount = $validated['amount']; // Dynamic amount from user input

        // Fetch API credentials securely from environment variables
        $userAuth = "chibe.chris";   // Replace with env('USER_AUTH') for production
        $password = "atc@123#2019";  // Replace with env('PASSWORD') for production

        // Ensure credentials are available
        if (empty($userAuth) || empty($password)) {
            return response()->json(['error' => 'API credentials are missing.'], 500);
        }

        // Step 1: Check if bill already exists in the database by index_no
        $existingPayment = DB::table('applicants_payments')->where('index_id', $index_no)->first();

        if ($existingPayment) {
            // If the bill exists, check if the control number exists
            if ($existingPayment->billId) {
                // If the billId exists, return success message or proceed as needed
                return redirect()->route('application-fee.index')->with('success', 'Bill already exists with billId: ' . $existingPayment->billId);
            } else {
                // If no billId exists, proceed to generate a new control number or handle accordingly
                return redirect()->route('application-fee.index')->with('error', 'Bill exists, but no valid control number is generated.');
            }
        }

        // Step 2: If the bill doesn't exist, proceed to create a new bill

        // Request data for the API
        $requestData = [
            "PyrName" => $name,
            "PyrCellNum" => $ph,
            "PyrEmail" => $email,
            "GfsCode" => ["142201610604"],
            "BillItemAmt" => [$amount],
            "Ccy" => "TZS",
            "UserAuth" => $userAuth,
            "Password" => $password,
            "BillAmt" => $amount,
            "BillItemQuantity" => [1],
            "BillDesc" => "Application fes",
            "BillItemRef" => [$index_no],
            "ExchangeRateAmount" => "1.00"
        ];

        // Convert array to JSON
        $jsonRequest = json_encode($requestData);

        // Send the request via cURL to create a new bill
        $url = 'http://196.41.62.108:8080/engine/public/api/bill/create';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonRequest);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute the request and handle errors
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return response()->json(['error' => 'cURL Error: ' . curl_error($ch)], 500);
        }

        // Get HTTP response code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode != 200) {
            return response()->json(['error' => 'API request failed with status code ' . $httpCode], 500);
        }

        // Close cURL session
        curl_close($ch);

        // Decode the response
        $apiResponse = json_decode($result, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Error decoding API response.'], 500);
        }

        // Step 3: Check if 'billId' exists in the response
        if (isset($apiResponse['billId'])) {
            $billId = $apiResponse['billId'];
        //print_r($billId);die();
            // Create payment record
            ApplicantsPayment::create([
                'control_number' => '0',  // Default control number
                'billId' => $billId,
                'name' => $name,
                'index_id' => $index_no,
                'amount' => $amount,
                'generated_at' => now(),
            ]);

            return redirect()->route('application-fee.index')->with('success', 'Bill created successfully with billId: ' . $billId);
        } else {
            return redirect()->back()->with('error', 'Failed to create bill. Response did not contain billId.');
        }
    }
    //GENERATE CONTROL NUMBER
    public function generateControlNumber()
    {
        $index_no = "S29988_0366_2020"; // Static BillItemRef
        // Fetch API credentials securely from environment variables
        $userAuth = "chibe.chris";   // Replace with env('USER_AUTH') for production
        $password = "atc@123#2019";  // Replace with env('PASSWORD') for production

        // Ensure credentials are available
        if (empty($userAuth) || empty($password)) {
            return response()->json(['error' => 'API credentials are missing.'], 500);
        }

        // Check if the bill already exists in the database by `index_id`
        $existingPayment = DB::table('applicants_payments')->where('index_id', $index_no)->first();

        if ($existingPayment) {
            // Bill exists, but we need to check if a control number has been generated
            if (!$existingPayment->control_number || $existingPayment->control_number === '0') {
                // If no control number is assigned, generate and update it

                // API request for control number generation
                $data = ['bil' => $existingPayment->billId];
                $url = "http://196.41.62.108:8080/control_api.php";

                $handle = curl_init($url);
                curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

                // Execute control API request
                $respond = curl_exec($handle);
                if (curl_errno($handle)) {
                    return response()->json(['error' => 'cURL Error: ' . curl_error($handle)], 500);
                }
                curl_close($handle);

                // Decode the response
                $api_response = json_decode($respond, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json(['error' => 'Error decoding control API response.'], 500);
                }

                $c = $api_response['control'];
                $error = $api_response['error'];

                // If control number is valid, update it
                if ($error == 0 && $c != 7101) {
                    DB::table('applicants_payments')
                        ->where('billId', $existingPayment->billId)
                        ->update(['control_number' => $c]);

                    return redirect()->route('application-fee.index')->with('success', 'Control number generated successfully.');
                } else {
                    // If there's an error or the response indicates deletion (c == 7101), delete the record
                    DB::table('applicants_payments')->where('billId', $existingPayment->billId)->delete();
                    return redirect()->back()->with('error', 'Failed to update control number. Bill deleted.');
                }
            } else {
                // If the control number already exists, no need to generate it again
                return redirect()->route('application-fee.index')->with('success', 'Control number already generated.');
            }
        }
    }
    //view Control and payment status
    public function show($id)
    {
        abort_if(Gate::denies('applicants_user_control_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $p = ApplicantsPayment::find($id);
        return view('Admission.Applicants.payments.show', compact('p'));
    }
    public function destroy($id)
    {
        abort_if(Gate::deies('applicants_user_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $controlno = ApplicantsPayment::find($id);
        $controlno->delete();
        return redirect()->route('application-fee.index')->with('sucess', 'Control Number successfully deleted');
    }

    //function check status
    public function checkPaymentStatus($controlNumber)
    {
        // Initialize cURL session
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://196.41.62.108:8080/engine/public/api/v1/transactions/filter',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(['control_number' => $controlNumber]),
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_HEADER => true, // Include the headers in the response
        ));

        // Execute the request and get the response
        $response = curl_exec($curl);
        $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Get the HTTP status code

        // Check for cURL error
        if ($response === false) {
            $error = curl_error($curl);
            curl_close($curl);
            return redirect()->back()->with('error', 'Failed to get payment status. Error: ' . $error);
        }
        // Close cURL session
        curl_close($curl);

        // Check if HTTP status is 200
        if ($httpStatusCode !== 200) {
            return redirect()->back()->with('error', 'Failed to connect to API. HTTP Status: ' . $httpStatusCode);
        }
        // Extract the body of the response (excluding headers)
        $body = substr($response, curl_getinfo($curl, CURLINFO_HEADER_SIZE));
        $apiResponse = json_decode($body, true);

        // Check if JSON decoding was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->back()->with('error', 'Error decoding payment status response.');
        }
        $apiResponse = json_decode($body, true);
        // Check the payment status from the response
        if ($httpStatusCode == 200) {
            // Extract the transaction date and time (TrxDtTm)
            $trxDtTm = isset($apiResponse['TrxDtTm']) ? $apiResponse['TrxDtTm'] : null;
            $pay_ref = isset($apiResponse['PayRefId']) ? $apiResponse['PayRefId'] : null;
            $receipt_no = isset($apiResponse['PspReceiptNumber']) ? $apiResponse['PspReceiptNumber'] : null;
            $pay_channel = isset($apiResponse['UsdPayChnl']) ? $apiResponse['UsdPayChnl'] : null;
            $pay_method = isset($apiResponse['PyrCellNum']) ? $apiResponse['PyrCellNum'] : null;

            // Ensure TrxDtTm exists and is a valid date
            if ($trxDtTm) {
                // Format the date to ensure it's compatible with your database (use Carbon for date formatting)
                try {
                    $datePaid = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $trxDtTm)->format('Y-m-d H:i:s');
                    //print_r($datePaid);die();
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Invalid transaction date format.');
                }

                // Update the payment status and date_paid in the database
                DB::beginTransaction();
                try {
                    DB::table('applicants_payments')
                        ->where('control_number', $controlNumber)
                        ->update([
                            'status' => 1,
                            'date_paid' => $datePaid,
                            'pay_ref' => $pay_ref,
                            'receipt_no' => $receipt_no,
                            'pay_channel' => $pay_channel,
                            'pay_method' => $pay_method
                        ]);
                    DB::commit();
                    return redirect()->route('application-fee.show')->with('success', 'Payment status and date updated successfully.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Error updating payment status and date.');
                }
            } else {
                return redirect()->back()->with('error', 'Transaction date not available.');
            }
        } else {
            return redirect()->route('application-fee.index')->with('error', 'Payment not found or failed.');
        }
    }
    public function refresh($bill)
    {
        $index_no = "S2993_0330_2020"; // Static BillItemRef
        // Fetch API credentials securely from environment variables
        $userAuth = "chibe.chris";   // Replace with env('USER_AUTH') for production
        $password = "atc@123#2019";  // Replace with env('PASSWORD') for production

        // Ensure credentials are available
        if (empty($userAuth) || empty($password)) {
            return response()->json(['error' => 'API credentials are missing.'], 500);
        }
        // Check if the bill already exists in the database by `index_id`
        $existingPayment = DB::table('applicants_payments')
            ->where('index_id', $index_no)   // Check for index_id
            ->where('billId', $bill)          // Check for billId
            ->first();
        //print_r($existingPayment);die();
        if ($existingPayment) {
            // Bill exists, but we need to check if a control number has been generated
            if (!$existingPayment->control_number || $existingPayment->control_number === '0') {
                // If no control number is assigned, generate and update it

                // API request for control number generation
                $data = ['bil' => $existingPayment->billId];
                $url = "http://196.41.62.108:8080/control_api.php";

                $handle = curl_init($url);
                curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

                // Execute control API request
                $respond = curl_exec($handle);
                if (curl_errno($handle)) {
                    return response()->json(['error' => 'cURL Error: ' . curl_error($handle)], 500);
                }
                curl_close($handle);

                // Decode the response
                $api_response = json_decode($respond, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json(['error' => 'Error decoding control API response.'], 500);
                }

                $c = $api_response['control'];
                $error = $api_response['error'];

                // If control number is valid, update it
                if ($error == 0 && $c != 7101) {
                    DB::table('applicants_payments')
                        ->where('billId', $existingPayment->billId)
                        ->update(['control_number' => $c]);

                    return redirect()->route('application-fee.index')->with('success', 'Control number updated successfully.');
                } else {
                    // If there's an error or the response indicates deletion (c == 7101), delete the record
                    DB::table('applicants_payments')->where('billId', $existingPayment->billId)->delete();
                    return redirect()->back()->with('error', 'Failed to update control number. Bill deleted.');
                }
            } else {
                // If the control number already exists, no need to generate it again
                return redirect()->route('application-fee.index')->with('success', 'Control number already generated.');
            }
        }
    }
    //ITS API POST
    public function savebyApi(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'email' => 'required|email',
            'mobile' => 'required|string|max:15',
        ]);
    
        // Prepare data for the API request
        $name = $validated['name'];
        $ph = $validated['mobile'];
        $email = $validated['email'];
        $index_no = "S2992_0290_2020"; // Static BillItemRef (example, replace with actual dynamic ID)
        $amount = $validated['amount']; // Dynamic amount from user input
    
        // Fetch API credentials securely from environment variables
        $userAuth = "chibe.chris";  // Replace with env('USER_AUTH') for production
        $password = "atc@123#2019"; // Replace with env('PASSWORD') for production
    
        // Check if the bill already exists in the database by `index_id`
        $existingPayment = DB::table('applicants_payments')->where('index_id', $index_no)->first();
    
        if ($existingPayment) {
            // If the payment record exists, check if it already has a control number
            if (!$existingPayment->control_number || $existingPayment->control_number === '0') {
                // API request to get the control number for an existing bill
                $response = Http::post('http://196.41.62.108:8080/control_api.php', [
                    'bil' => $existingPayment->billId
                ]);
    
                if ($response->failed()) {
                    return response()->json(['error' => 'API request failed: ' . $response->body()], 500);
                }
    
                $apiResponse = $response->json();
                
                // If the control number is successfully retrieved
                if ($apiResponse['error'] == 0 && $apiResponse['control'] != 7101) {
                    // Update the control number in the existing payment record
                    DB::table('applicants_payments')
                        ->where('billId', $existingPayment->billId)
                        ->update(['control_number' => $apiResponse['control']]);
    
                    return response()->json(['message' => 'Control number updated successfully.'], 200);
                } else {
                    // If the API failed to provide control number, delete the bill
                    DB::table('applicants_payments')->where('billId', $existingPayment->billId)->delete();
                    return response()->json(['error' => 'Failed to update control number. Bill deleted.'], 400);
                }
            } else {
                // If control number already exists, return success message
                return response()->json(['message' => 'Control number already generated.'], 200);
            }
        } else {
            // If no existing record found for the given index_id, create a new bill and control number
            $response = Http::post('http://196.41.62.108:8080/engine/public/api/bill/create', [
                'PyrName' => $name,
                'PyrCellNum' => $ph,
                'PyrEmail' => $email,
                'GfsCode' => ['142201610604'],
                'BillItemAmt' => [$amount],
                'Ccy' => 'TZS',
                'UserAuth' => $userAuth,
                'Password' => $password,
                'BillAmt' => $amount,
                'BillItemQuantity' => [1],
                'BillDesc' => 'Application fees',
                'BillItemRef' => [$index_no],
                'ExchangeRateAmount' => '1.00'
            ]);
    
            if ($response->failed()) {
                return response()->json(['error' => 'API request failed: ' . $response->body()], 500);
            }
    
            $apiResponse = $response->json();
    
            // If the bill is successfully created in the external system
            if (isset($apiResponse['billId'])) {
                ApplicantsPayment::create([
                    'control_number' => '0',  // Default control number
                    'billId' => $apiResponse['billId'],
                    'name' => $name,
                    'index_id' => $index_no,
                    'amount' => $amount,
                    'generated_at' => now(),
                ]);
                // Generate control number using another API (or logic if needed)
                $controlResponse = Http::post('http://196.41.62.108:8080/control_api.php', [
                    'bil' => $apiResponse['billId']
                ]);
    
                if ($controlResponse->failed()) {
                    return response()->json(['error' => 'Failed to generate control number.'], 500);
                }
    
                $controlApiResponse = $controlResponse->json();
               print_r($controlApiResponse);die();
                // If the control number is successfully retrieved
                if ($controlApiResponse['error'] == 0 && $controlApiResponse['control'] != 7101) {
                    // Save the new billId and control number into the ApplicantsPayment model
                    ApplicantsPayment::create([
                        'control_number' => $controlApiResponse['control'], // Set control number from API
                        'billId' => $apiResponse['billId'],
                        'name' => $name,
                        'index_id' => $index_no,
                        'amount' => $amount,
                        'generated_at' => now(),  // Automatically sets the current timestamp
                    ]);
    
                    return response()->json(['message' => 'Bill created successfully and control number generated.'], 201);
                } else {
                    return response()->json(['error' => 'Failed to generate control number after bill creation.'], 500);
                }
            } else {
                return response()->json(['error' => 'Failed to create bill.'], 400);
            }
        }
    }
    
}

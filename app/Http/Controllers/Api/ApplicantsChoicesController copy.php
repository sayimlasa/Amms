<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ApplicantsChoice;
use App\Models\ApplicationCategory;
use App\Models\ApplicationProgress;
use App\Models\ApplicationWindow;
use App\Models\Intake;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DateTime;
use DateTimeZone;

class ApplicantsChoicesController extends Controller
{
    public function getApplicantChoice(Request $request)
    {

        $validatedData = $request->validate([
            'category_id' => 'required|integer',
            'campus_id' => 'required|integer'
        ]);
        $application_level = ApplicationCategory::select('application_level_id')->where('id', $validatedData['category_id'])->first();

        if ($application_level) {
            // Assuming $validatedData contains the campus_id
            $choices = Programme::where('application_level_id', $application_level->application_level_id)
                ->whereHas('campuses', function ($query) use ($validatedData) {
                    // Filter by the campus_id from validatedData
                    $query->where('campus_id', $validatedData['campus_id']);
                })
                ->get();
        }

        return response()->json([
            'success' => true,
            'choices' => $choices
        ]);
    }

    public function storeApplicantChoice(Request $request)
    {
        dd($request->all());
        try {
            // Fetch the active academic year
            $academicYear = AcademicYear::where('active', 1)->first();
            $intake = Intake::where('active', 1)->first();
            $window = ApplicationWindow::where('active', 1)->first();
            if (!$academicYear) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active academic year found.',
                ], 404);
            }
            if (!$window) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active window found.',
                ], 404);
            }
            if (!$intake) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active intake found.',
                ], 404);
            }

            // Validate the request data
            $validatedData = $request->validate([
                'applicant_user_id' => 'required|integer',
                'index_no' => 'required|string',
                'choice1' => 'required|integer',
                'choice2' => 'required|integer',
                'choice3' => 'required|integer',
            ]);
            $application_step = "Choices";

            // Add the academic year ID to the validated data
            $validatedData['academic_year_id'] = $academicYear->id;

            // Use the "create or update" logic
            $applicantChoice = ApplicantsChoice::updateOrCreate(
                [
                    'applicant_user_id' => $validatedData['applicant_user_id'],
                    'index_no' => $validatedData['index_no'],
                    'academic_year_id' => $validatedData['academic_year_id'],
                ],
                [
                    'intake_id' => $intake->id,
                    'window_id' => $window->id,
                    'choice1' => $validatedData['choice1'],
                    'choice2' => $validatedData['choice2'],
                    'choice3' => $validatedData['choice3'],
                ]
            );
            //SEND TO TCU
            if ($applicantChoice) {
                // Ensure progress is updated only after a successful operation
                $progressUpdated = $this->addApplicantTotcu(
                    $validatedData['applicant_user_id'],
                    $validatedData['academic_year_id'],
                    $application_step,
                    $validatedData['index_no']
                );

                if (!$progressUpdated) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to update application progress after saving choices.',
                    ], 500);
                }
            }
              if ($applicantChoice) {
                // Ensure progress is updated only after a successful operation
                $progressUpdated = $this->createOrUpdateApplicationProgress(
                    $validatedData['applicant_user_id'],
                    $validatedData['academic_year_id'],
                    $application_step,
                    $validatedData['index_no']
                );

                if (!$progressUpdated) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to update application progress after saving choices.',
                    ], 500);
                }
            }
            // Return success response
            return response()->json([
                'success' => true,
                'message' => $applicantChoice->wasRecentlyCreated
                    ? 'You have successfully completed the application process. Thank you!.'
                    : 'You have successfully completed the application process. Thank you!.',
                'data' => $applicantChoice,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error in storing applicant choice: ' . $e->getMessage());

            // Return generic error response
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }

    public function createOrUpdateApplicationProgress($applicant_user_id, $academic_year_id, $application_step, $index_no)
    {
        try {
            // Check if application progress for the user and step exists
            $progress = ApplicationProgress::where('applicant_user_id', $applicant_user_id)
                ->where('academic_year_id', $academic_year_id)
                ->where('application_step', $application_step)
                ->first();

            if ($progress) {
                $progress->update([
                    'status' => 'completed',
                ]);
            } else {
                ApplicationProgress::create([
                    'applicant_user_id' => $applicant_user_id,
                    'index_no' => $index_no,
                    'academic_year_id' => $academic_year_id,
                    'application_step' => $application_step,
                    'status' => 'completed',
                ]);
            }

            // Return true if no exceptions were thrown
            return true;
        } catch (\Exception $e) {
            Log::error("Error updating application progress: " . $e->getMessage());
            return false; // Return false if an error occurs
        }
    }

    public function getSelectedChoices(Request $request)
    {
        // Fetch the active academic year
        $academicYear = AcademicYear::where('active', 1)->first();

        if (!$academicYear) {
            // Return an error if no active academic year is found
            return response()->json([
                'success' => false,
                'message' => 'No active academic year found.',
            ], 404);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'applicant_user_id' => 'required|integer',
            'index_no' => 'required|string',
        ]);

        // Retrieve the selected choices for the given applicant and academic year
        $selectedChoices = ApplicantsChoice::select('choice1', 'choice2', 'choice3')
            ->where('applicant_user_id', $validatedData['applicant_user_id'])
            ->where('index_no', $validatedData['index_no'])
            ->where('academic_year_id', $academicYear->id)
            ->first(); // Use first() to get a single record

        if (!$selectedChoices) {
            // If no choices are found, return a 404 error
            return response()->json([
                'success' => false,
                'message' => 'No selected choices found for this applicant.',
            ], 404);
        }

        // Return the selected choices if found
        return response()->json([
            'success' => true,
            'selected' => $selectedChoices,
        ], 200);
    }

    protected function sendSms($username, $password, $mobile_no)
    {
        $key = "e1WisEhOtfVvBaVQ2j3p5wJPa4X6xj6Jp6C83Jd0";
        $phone = $mobile_no;
        $ph = '255' . ltrim($phone, '0');
        $phon = $ph;
        $message = $message = "You have completed the apllication, please wait for selection, Thank you!";;

        // Set datetime in EAT timezone
        $t = (new DateTime('now', new DateTimeZone('Africa/Nairobi')))->format('Y-m-d H:i:s');

        $data = array(
            "recipients" => $phon,
            "message" => $message,
            "datetime" => $t,
            "mobile_service_id" => "507",
            "sender_id" => "IAA"
        );

        $datajson = json_encode($data);
        $url = "http://msdg.ega.go.tz/msdg/public/quick_sms";
        $id = "schibelenje@iaa.ac.tz";
        $type = "api";

        $handle = curl_init($url);

        $da = array("data" => $datajson, "datetime" => $t);

        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handle, CURLOPT_POSTFIELDS, $da);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
            'X-Auth-Request-Hash:' . $this->getRequestHash($datajson, $key),
            'X-Auth-Request-Id:' . $id,
            'X-Auth-Request-Type:' . $type
        ));

        $result = curl_exec($handle);

        // Log the response safely
        // Log::info("SMS API Response: " . $result);

        // Decode and log the response as an object
        $sms_de = json_decode($result);
        // Log::info("Decoded Response: " . json_encode($sms_de));

        curl_close($handle);
    }

    // Request hash helper
    protected function getRequestHash($data, $key)
    {
        return base64_encode(hash_hmac('sha256', $data, $key, true));
    }
}

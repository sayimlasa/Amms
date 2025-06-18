<?php

namespace App\Http\Controllers\Registration;

use App\Models\Campus;
use App\Models\Intake;
use App\Models\Employer;
use App\Models\Programme;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\ApplicantsInfo;
use App\Models\EmploymentStatus;
use App\Models\VerifyQualification;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class VerifyQualificationController extends Controller
{
    public function indexRegistered(Request $request)
    {
        $programmes = Programme::all();
        $campuses = Campus::all();
        $intakes = Intake::all();
        $academicYears = AcademicYear::all();
        //$query = RegistrationPayment::whereNot('control_no', 0);

        $programmeId = $request->input('programme_id');
        $campusId = $request->input('campus_id');
        $blended = $request->input('blended');
        $academic = $request->input('academic_year_id');
        $intake = $request->input('intake_id');

        $registered = VerifyQualification::when($programmeId, function ($query) use ($programmeId) {
            $query->where('programme_id', $programmeId);
        })->when($campusId, function ($query) use ($campusId) {
            $query->where('campus_id', $campusId);
        })->when($academic, function ($query) use ($academic) {
            $query->where('academic_year_id', $academic);
        })->when($intake, function ($query) use ($intake) {
            $query->where('intake_id', $intake);
        })->when($blended, function ($query) use ($blended) {
            $query->where('blended', $blended);
        })->get();
        return view('registrations.registered-student', compact('registered', 'programmes', 'intakes', 'campuses', 'academicYears'));
    }
    public function verify()
    {
        $indexnumber = 'S2894-0061-2012';
        $indexExists = ApplicantsInfo::where('index_no', $indexnumber)->first();
        if (!$indexExists) {
            return back()->with('error', 'Index number does not exist.');
        }
        // Fetch empl oyment status for 'Unemployed' and 'Employed'
        $employmee = EmploymentStatus::where('name', 'LIKE', '%Unemployed%')->pluck('id')->first();
        $employmeepolisimagereza = EmploymentStatus::where('name', 'LIKE', '%Employed%')->pluck('id')->first();

        // Get the campusId based on index number, employment status and employer info
        $campusId = $this->getCampusId($indexnumber, $employmee, $employmeepolisimagereza);
        $programId = 4;
        $program = Programme::find($programId); // Retrieve program details

        // Get the current year
        $currentYear = date('Y');

        // Get the last used number (can be stored in session or database)
        $lastUsedNumber = session('lastUsedNumber', 0);

        // If the year has changed, reset the counter
        if (session('lastUsedYear') != $currentYear) {
            $lastUsedNumber = 0;
            session(['lastUsedYear' => $currentYear]);
        }
        // Increment the number for the program
        $newNumber = $lastUsedNumber + 1;
        // Pad the number to 4 digits (e.g., 0001, 0002, ...)
        $formattedRandomNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        // Generate the registration number
        $registrationNumber = $program->short . '-' . $campusId . '-' . $formattedRandomNumber . '-' . $currentYear;
        // Check if the registration number already exists in the database
        $existingRegistration = \App\Models\VerifyQualification::where('regno', $registrationNumber)
            ->where('index_no', $indexnumber)->first();

        // If the registration number already exists, increment and try again
        if ($existingRegistration) {
            $newNumber++;
            $formattedRandomNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            //$registrationNumber = $programCode . '-' . $campusId . '-' . $formattedRandomNumber . '-' . $currentYear;
            $registrationNumber = $program->short . '-' . $campusId . '-' . $formattedRandomNumber . '-' . $currentYear;
        }
        // Update the session with the latest used number for the program
        session(['lastUsedNumber' => $newNumber]);

        return view('registrations.verify-qualification', compact('registrationNumber'));
    }

    private function getCampusId($indexnumber, $employmee, $employmeepolisimagereza)
    {
        // Try to fetch the campus ID for an unemployed applicant
        $campus = ApplicantsInfo::where('index_no', $indexnumber)
            ->where('employment_status', $employmee)->pluck('campus_id')->first();

        // If campusId for unemployed applicant is found, return it
        if ($campus) {
            return str_pad($campus, 2, '0', STR_PAD_LEFT);
        }

        // Fetch police employer info
        $polisi = Employer::where('name', 'LIKE', '%polisi%')->first();

        // If campusId for an employed applicant working in the police force is found, return 06
        $campuspolisi = ApplicantsInfo::where('index_no', $indexnumber)
            ->where('employment_status', $employmeepolisimagereza)
            ->where('employer_id', $polisi->id)
            ->first();

        if ($campuspolisi) {
            return str_pad(6, 2, '0', STR_PAD_LEFT);
        }
        // Fetch magereza employer info
        $magereza = Employer::where('name', 'LIKE', '%magereza%')->first();

        // If campusId for an employed applicant working in the magereza department is found, return 07
        $campusmagereza = ApplicantsInfo::where('index_no', $indexnumber)
            ->where('employment_status', '=', $employmeepolisimagereza)
            ->where('employer_id', $magereza->id)
            ->first();

        // Default to '07' if no police or magereza matches found
        return $campusmagereza ? str_pad(7, 2, '0', STR_PAD_LEFT) : str_pad(7, 2, '0', STR_PAD_LEFT);
    }
    // Controller method

    // Validate the form input
    public function store(Request $request)
    {
        // Validate the form input
        $validated = $request->validate([
            'study_mode_fulltime' => 'nullable|boolean',
            'study_mode_blended' => 'nullable|boolean',
            'qualification_form_four' => 'nullable|boolean',
            'qualification_form_six' => 'nullable|boolean',
            'qualification_diploma' => 'nullable|boolean',
            'qualification_bachelor' => 'nullable|boolean',
            'qualification_bachelor_transcript' => 'nullable|boolean',
            'qualification_medical_form' => 'nullable|boolean',
            'qualification_birth_certificate' => 'nullable|boolean',
            'registration_number' => 'required|string|max:255|unique:verify_qualifications,regno',
        ]); // unique rule for the Verify_qualifications table

        $qualification = VerifyQualification::updateOrCreate(
            ['regno' => $request->registration_number], // Condition to find the record (based on regno in this case)
            [
                'studymode' => $validated['study_mode_fulltime'],
                'blended' => $request->has('study_mode_blended'),
                'necta_iv' => $request->has('qualification_form_four'),
                'necta_vi' => $request->has('qualification_form_six'),
                'diploma' => $request->has('qualification_diploma'),
                'bachelor_certificate' => $request->has('qualification_bachelor'),
                'bachelor_transcript' => $request->has('qualification_bachelor_transcript'),
                'medical_form' => $request->has('qualification_medical_form'),
                'birth_certificate' => $request->has('qualification_birth_certificate'),
            ]
        );

        Log::info($qualification);
        // Redirect back or to another route with success message
        return redirect()->route('registered-student')->with('success', 'registered Setting Saved Successfully');
    }
}

<?php

namespace App\Http\Controllers\Admissions\Applicants;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ApplicantAttachment;
use App\Models\ApplicantsAcademic;
use App\Models\ApplicantsChoice;
use App\Models\ApplicantsInfo;
use App\Models\ApplicantsPayment;
use App\Models\Campus;
use App\Models\Employer;
use App\Models\NextOfKin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IncompleteApplicationsController extends Controller
{
     public function allCampuses()
    {
        // Get the active academic year ID
        $academicYear = AcademicYear::where('active', 1)->pluck('id')->first();
        // Get all completed applicants for the given academic year
        $completed = ApplicantsChoice::select('applicant_user_id', 'index_no')
            ->where('academic_year_id', $academicYear)
            ->get(); // Get the collection of completed applicants

        // Loop through each completed applicant and fetch their info
        $applicants = ApplicantsInfo::with(
            'applicantUser',
            'applicationCategory',
            'countryOfBirth',
            'placeOfBirth',
            'districtOfBirth',
            'maritalStatus',
            'region',
            'district',
            'country',
            'campus',
            'intake',
            'nationalit',
            'employer',
            'disability',
            'employmentStatus'
        )
            ->whereIn('applicant_user_id', $completed->pluck('applicant_user_id')) // Use whereIn for an array of user IDs
            ->whereNotIn('index_no', $completed->pluck('index_no')) // Use whereIn for an array of index numbers
            ->where('acadmic_year_id', $academicYear) // Filter by academic year
            ->get();

        // Return the view with the applicants data
        return view('Admission.Applicants.submited-applications.partial_info_campus', compact('applicants'));
    }
    public function arushaCampus()
    {
        // Get the active academic year ID
        $academicYear = AcademicYear::where('active', 1)->pluck('id')->first(); // Ensure we get the first ID value

        // Get the excluded employers based on the name
        $polisi = Employer::where('name', 'like', '%police%')->pluck('id');
        $magereza = Employer::where('name', 'like', '%magereza%')->pluck('id');
        $excludedEmployers = $polisi->merge($magereza); // Merge both collections into one

        // Get the Arusha campus ID
        $arushacampus = Campus::where('name', 'like', '%arusha%')->pluck('id')->first(); // Ensure we get the first ID value

        // Get all completed applicants for the given academic year
        $completed = ApplicantsChoice::select('applicant_user_id', 'index_no')
            ->where('academic_year_id', $academicYear)
            ->get(); // Get the collection of completed applicants

        // Loop through each completed applicant and fetch their info
        $applicants = ApplicantsInfo::with(
            'applicantUser',
            'applicationCategory',
            'countryOfBirth',
            'placeOfBirth',
            'districtOfBirth',
            'maritalStatus',
            'region',
            'district',
            'country',
            'campus',
            'intake',
            'nationalit',
            'employer',
            'disability',
            'employmentStatus'
        )
            ->whereNotIn('applicant_user_id', $completed->pluck('applicant_user_id')) // Use whereIn for an array of user IDs
            ->whereNotIn('index_no', $completed->pluck('index_no')) // Use whereIn for an array of index numbers
            ->where('campus_id', $arushacampus) // Filter by campus
            ->where('acadmic_year_id', $academicYear) // Filter by academic year
            ->where(function ($query) use ($excludedEmployers) {
                $query->whereNull('employer_id') // Null employer ID check
                    ->orWhereNotIn('employer_id', $excludedEmployers); // Exclude specific employers
            })
            ->get();

        // Return the view with the applicants data
        return view('Admission.Applicants.incomplete-applications.partial_info', compact('applicants'));
    }
    public function babatiCampus()
    {
        // Get the active academic year ID
        $academicYear = AcademicYear::where('active', 1)->pluck('id')->first(); // Ensure we get the first ID value

        // Get the excluded employers based on the name
        $polisi = Employer::where('name', 'like', '%police%')->pluck('id');
        $magereza = Employer::where('name', 'like', '%magereza%')->pluck('id');
        $excludedEmployers = $polisi->merge($magereza); // Merge both collections into one

        // Get the Arusha campus ID
        $babaticampus = Campus::where('name', 'like', '%babati%')->pluck('id')->first(); // Ensure we get the first ID value

        // Get all completed applicants for the given academic year
        $completed = ApplicantsChoice::select('applicant_user_id', 'index_no')
            ->where('academic_year_id', $academicYear)
            ->get(); // Get the collection of completed applicants

        // Loop through each completed applicant and fetch their info
        $applicants = ApplicantsInfo::with(
            'applicantUser',
            'applicationCategory',
            'countryOfBirth',
            'placeOfBirth',
            'districtOfBirth',
            'maritalStatus',
            'region',
            'district',
            'country',
            'campus',
            'intake',
            'nationalit',
            'employer',
            'disability',
            'employmentStatus'
        )
            ->whereNotIn('applicant_user_id', $completed->pluck('applicant_user_id')) // Use whereIn for an array of user IDs
            ->whereNotIn('index_no', $completed->pluck('index_no')) // Use whereIn for an array of index numbers
            ->where('campus_id', $babaticampus) // Filter by campus
            ->where('acadmic_year_id', $academicYear) // Filter by academic year
            ->where(function ($query) use ($excludedEmployers) {
                $query->whereNull('employer_id') // Null employer ID check
                    ->orWhereNotIn('employer_id', $excludedEmployers); // Exclude specific employers
            })
            ->get();

        // Return the view with the applicants data
        return view('Admission.Applicants.incomplete-applications.partial_info', compact('applicants'));
    }
    public function dodomaCampus()
    {
        // Get the active academic year ID
        $academicYear = AcademicYear::where('active', 1)->pluck('id')->first(); // Ensure we get the first ID value

        // Get the excluded employers based on the name
        $polisi = Employer::where('name', 'like', '%police%')->pluck('id');
        $magereza = Employer::where('name', 'like', '%magereza%')->pluck('id');
        $excludedEmployers = $polisi->merge($magereza); // Merge both collections into one

        // Get the Arusha campus ID
        $dodomacampus = Campus::where('name', 'like', '%dodoma%')->pluck('id')->first(); // Ensure we get the first ID value

        // Get all completed applicants for the given academic year
        $completed = ApplicantsChoice::select('applicant_user_id', 'index_no')
            ->where('academic_year_id', $academicYear)
            ->get(); // Get the collection of completed applicants

        // Loop through each completed applicant and fetch their info
        $applicants = ApplicantsInfo::with(
            'applicantUser',
            'applicationCategory',
            'countryOfBirth',
            'placeOfBirth',
            'districtOfBirth',
            'maritalStatus',
            'region',
            'district',
            'country',
            'campus',
            'intake',
            'nationalit',
            'employer',
            'disability',
            'employmentStatus'
        )
            ->whereNotIn('applicant_user_id', $completed->pluck('applicant_user_id')) // Use whereIn for an array of user IDs
            ->whereNotIn('index_no', $completed->pluck('index_no')) // Use whereIn for an array of index numbers
            ->where('campus_id', $dodomacampus) // Filter by campus
            ->where('acadmic_year_id', $academicYear) // Filter by academic year
            ->where(function ($query) use ($excludedEmployers) {
                $query->whereNull('employer_id') // Null employer ID check
                    ->orWhereNotIn('employer_id', $excludedEmployers); // Exclude specific employers
            })
            ->get();

        // Return the view with the applicants data
        return view('Admission.Applicants.incomplete-applications.partial_info', compact('applicants'));
    }

    public function darCampus()
    {
        // Get the active academic year ID
        $academicYear = AcademicYear::where('active', 1)->pluck('id')->first(); // Ensure we get the first ID value

        // Get the excluded employers based on the name
        $polisi = Employer::where('name', 'like', '%police%')->pluck('id');
        $magereza = Employer::where('name', 'like', '%magereza%')->pluck('id');
        $excludedEmployers = $polisi->merge($magereza); // Merge both collections into one

        // Get the Arusha campus ID
        $darcampus = Campus::where('name', 'like', '%dar%')->pluck('id')->first(); // Ensure we get the first ID value

        // Get all completed applicants for the given academic year
        $completed = ApplicantsChoice::select('applicant_user_id', 'index_no')
            ->where('academic_year_id', $academicYear)
            ->get(); // Get the collection of completed applicants

        // Loop through each completed applicant and fetch their info
        $applicants = ApplicantsInfo::with(
            'applicantUser',
            'applicationCategory',
            'countryOfBirth',
            'placeOfBirth',
            'districtOfBirth',
            'maritalStatus',
            'region',
            'district',
            'country',
            'campus',
            'intake',
            'nationalit',
            'employer',
            'disability',
            'employmentStatus'
        )
            ->whereNotIn('applicant_user_id', $completed->pluck('applicant_user_id')) // Use whereIn for an array of user IDs
            ->whereNotIn('index_no', $completed->pluck('index_no')) // Use whereIn for an array of index numbers
            ->where('campus_id', $darcampus) // Filter by campus
            ->where('acadmic_year_id', $academicYear) // Filter by academic year
            ->where(function ($query) use ($excludedEmployers) {
                $query->whereNull('employer_id') // Null employer ID check
                    ->orWhereNotIn('employer_id', $excludedEmployers); // Exclude specific employers
            })
            ->get();

        // Return the view with the applicants data
        return view('Admission.Applicants.incomplete-applications.partial_info', compact('applicants'));
    }
    public function songeaCampus()
    {
        // Get the active academic year ID
        $academicYear = AcademicYear::where('active', 1)->pluck('id')->first(); // Ensure we get the first ID value

        // Get the excluded employers based on the name
        $polisi = Employer::where('name', 'like', '%police%')->pluck('id');
        $magereza = Employer::where('name', 'like', '%magereza%')->pluck('id');
        $excludedEmployers = $polisi->merge($magereza); // Merge both collections into one

        // Get the Arusha campus ID
        $songeacampus = Campus::where('name', 'like', '%songea%')->pluck('id')->first(); // Ensure we get the first ID value

        // Get all completed applicants for the given academic year
        $completed = ApplicantsChoice::select('applicant_user_id', 'index_no')
            ->where('academic_year_id', $academicYear)
            ->get(); // Get the collection of completed applicants

        // Loop through each completed applicant and fetch their info
        $applicants = ApplicantsInfo::with(
            'applicantUser',
            'applicationCategory',
            'countryOfBirth',
            'placeOfBirth',
            'districtOfBirth',
            'maritalStatus',
            'region',
            'district',
            'country',
            'campus',
            'intake',
            'nationalit',
            'employer',
            'disability',
            'employmentStatus'
        )
            ->whereNotIn('applicant_user_id', $completed->pluck('applicant_user_id')) // Use whereIn for an array of user IDs
            ->whereNotIn('index_no', $completed->pluck('index_no')) // Use whereIn for an array of index numbers
            ->where('campus_id', $songeacampus) // Filter by campus
            ->where('acadmic_year_id', $academicYear) // Filter by academic year
            ->where(function ($query) use ($excludedEmployers) {
                $query->whereNull('employer_id') // Null employer ID check
                    ->orWhereNotIn('employer_id', $excludedEmployers); // Exclude specific employers
            })
            ->get();

        // Return the view with the applicants data
        return view('Admission.Applicants.incomplete-applications.partial_info', compact('applicants'));
    }

    public function polisi()
    {
        // Get the active academic year ID
        $academicYear = AcademicYear::where('active', 1)->pluck('id')->first(); // Ensure we get the first ID value

        // Get the excluded employers based on the name
        $polisi = Employer::where('name', 'like', '%police%')->pluck('id');

        // Get the Arusha campus ID

        // Get all completed applicants for the given academic year
        $completed = ApplicantsChoice::select('applicant_user_id', 'index_no')
            ->where('academic_year_id', $academicYear)
            ->get(); // Get the collection of completed applicants

        // Loop through each completed applicant and fetch their info
        $applicants = ApplicantsInfo::with(
            'applicantUser',
            'applicationCategory',
            'countryOfBirth',
            'placeOfBirth',
            'districtOfBirth',
            'maritalStatus',
            'region',
            'district',
            'country',
            'campus',
            'intake',
            'nationalit',
            'employer',
            'disability',
            'employmentStatus'
        )
            ->whereNotIn('applicant_user_id', $completed->pluck('applicant_user_id')) // Use whereIn for an array of user IDs
            ->whereNotIn('index_no', $completed->pluck('index_no')) // Use whereIn for an array of index numbers
            ->where('employer_id', $polisi) // Filter by campus
            ->where('acadmic_year_id', $academicYear)
            ->get();

        // Return the view with the applicants data
        return view('Admission.Applicants.incomplete-applications.partial_info', compact('applicants'));
    }

    public function magereza()
    {
        // Get the active academic year ID
        $academicYear = AcademicYear::where('active', 1)->pluck('id')->first(); // Ensure we get the first ID value

        // Get the excluded employers based on the name
        $magereza = Employer::where('name', 'like', '%magereza%')->pluck('id');

        // Get all completed applicants for the given academic year
        $completed = ApplicantsChoice::select('applicant_user_id', 'index_no')
            ->where('academic_year_id', $academicYear)
            ->get(); // Get the collection of completed applicants

        // Loop through each completed applicant and fetch their info
        $applicants = ApplicantsInfo::with(
            'applicantUser',
            'applicationCategory',
            'countryOfBirth',
            'placeOfBirth',
            'districtOfBirth',
            'maritalStatus',
            'region',
            'district',
            'country',
            'campus',
            'intake',
            'nationalit',
            'employer',
            'disability',
            'employmentStatus'
        )
            ->whereNotIn('applicant_user_id', $completed->pluck('applicant_user_id')) // Use whereIn for an array of user IDs
            ->whereNotIn('index_no', $completed->pluck('index_no')) // Use whereIn for an array of index numbers
            ->where('employer_id', $magereza) // Filter by campus
            ->where('acadmic_year_id', $academicYear) 
            ->get();

        // Return the view with the applicants data
        return view('Admission.Applicants.incomplete-applications.partial_info', compact('applicants'));
    }
    public function detailedInfo($applicant_user_id, $index_no)
{
    // Get the active academic year ID
    $academicYear = AcademicYear::where('active', 1)->pluck('id')->first(); // Ensure we get the first ID value

    // Fetch applicant information
    $applicantInfos = ApplicantsInfo::with(
        'applicantUser',
        'countryOfBirth',
        'placeOfBirth',
        'districtOfBirth',
        'maritalStatus',
        'region',
        'district',
        'country',
        'campus',
        'intake',
        'nationalit',
        'employer',
        'disability',
        'employmentStatus'
    )
        ->where('applicant_user_id', $applicant_user_id)
        ->where('index_no', $index_no)
        ->where('acadmic_year_id', $academicYear)
        ->first();

    // If no applicant info is found, set a default empty object or null
    $applicantInfos = $applicantInfos ?: (object)[];

    // Fetch NextOfKin info
    $nextOfKin = NextOfKin::with(
        'region',
        'district',
        'country',
        'relationship'
    )
        ->where('applicant_user_id', $applicant_user_id)
        ->where('index_no', $index_no)
        ->first();

    // If no next of kin info is found, set to null
    $nextOfKin = $nextOfKin ?: null;

    // Fetch payment info
    $payment = ApplicantsPayment::where('applicant_user_id', $applicant_user_id)
        ->where('index_no', $index_no)
        ->where('academic_year_id', $academicYear)
        ->first();

    // If no payment info is found, set to null
    $payment = $payment ?: null;

    // Fetch choice info
    $choice = ApplicantsChoice::with(
        'programmeChoice1',
        'programmeChoice2'
    )
        ->where('applicant_user_id', $applicant_user_id)
        ->where('index_no', $index_no)
        ->where('academic_year_id', $academicYear)
        ->first();

    // If no choice info is found, set to null
    $choice = $choice ?: null;

    // Fetch academic details
    $academics = ApplicantsAcademic::where('applicant_user_id', $applicant_user_id)
        // ->where('index_no', $index_no)
        ->get();

    // If no academic details are found, set to an empty collection
    $academics = $academics ?: collect();

    // Fetch form4 results
    $form4_results = DB::table('form4_results')
        ->whereIn('applicant_user_id', $academics->pluck('applicant_user_id'))
        ->get();

    // Fetch form6 results
    $form6_results = DB::table('form6_results')
        ->whereIn('applicant_user_id', $academics->pluck('applicant_user_id'))
        ->get();
        Log::info( $form6_results);
    

    // Fetch attachments
    $attachments = ApplicantAttachment::where('applicant_user_id', $applicant_user_id)
        ->where('index_no', $index_no)
        ->get();

    // If no attachments are found, set to an empty collection
    $attachments = $attachments ?: collect();

    // Return the view with the necessary data
    return view('Admission.Applicants.incomplete-applications.detailed_info', compact(
        'applicantInfos', 'nextOfKin', 'payment', 'choice', 'academics', 'form4_results', 'form6_results', 'attachments'
    ));
}

}

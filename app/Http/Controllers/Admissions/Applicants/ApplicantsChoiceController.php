<?php

namespace App\Http\Controllers\Admissions\Applicants;

use App\Models\Intake;
use App\Models\Programme;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\ApplicantsChoice;
use App\Models\ApplicationLevel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ApplicantsChoiceController extends Controller
{
    public function index()
    {
        $applicantschoice = ApplicantsChoice::all();
        $programs = Programme::all();
        $intake = Intake::all();
        $academic = AcademicYear::all();
        return  view('Admission.Applicants.applicants-choices.index', compact('applicantschoice', 'programs', 'academic', 'intake'));
    }

    public function getLevels(Request $request)
    {
        // // Get the search term
        // $searchTerm = $request->input('search');

        // // Fetch levels from the database based on the search term (you can adjust this based on your model and database)
        // $levels = Programme::where('name', 'LIKE', "%$searchTerm%")->get();
        // // Format the data as Select2 expects
        // $data = $levels->map(function ($level) {
        //     return [
        //         'id' => $level->id,  // ID to send in the request
        //         'text' => $level->name // Name to display in the dropdown
        //     ];
        // });

        // return response()->json(['results' => $data]);
        {
            // Get the search term or level ID from the request
            $searchTerm = $request->input('search');
            // Optionally, if you're searching based on a specific level or filtering by name
            $programmes = Programme::where('name', 'LIKE', "%$searchTerm%")->get();
            // Prepare data for Select2 format
            $data = $programmes->map(function ($programme) {
                return [
                    'id' => $programme->id,    // The value that will be sent with the selection
                    'text' => $programme->name // The text that will be displayed in the dropdown
                ];
            });

            // Return the formatted data as JSON for Select2
            return response()->json(['results' => $data]);
        }
    }
    public function create()
    {
        $levels = Programme::all();
        return  view('Admission.Applicants.applicants-choices.create', compact('levels'));
    }
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'choice1' => 'required|exists:programmes,id',
            'choice2' => 'required|exists:programmes,id',
            'choice3' => 'required|exists:programmes,id',
        ]);
        // Retrieve the values for index_no, academic_year_id, and intake_id
        $indexNo = "S2993_0031_2014";  // This should come from the request or be dynamic
        $academicYearId = 1; // This is an example value, you might get it from the request
        $intakeId = 1; // This is an example value, you might get it from the request

        // Check if the index_no exists in the given academic_year_id and intake_id
        $indexNoExists = DB::table('applicants_choices') // Assuming your application table is called 'applications'
            ->where('index_no', $indexNo)
            ->where('academic_year_id', $academicYearId)
            ->where('intake_id', $intakeId)
            ->exists();
        // If index_no exists, return an error response
        if ($indexNoExists) {
            return back()->withErrors(['error' => 'The index_no already exists for the given academic year and intake.']);
        }
        // Save the application choices if index_no does not exist
        $applicantChoice = new ApplicantsChoice();
        $applicantChoice->applicant_user_id = auth()->id();  // If you're saving the user_id
        $applicantChoice->index_no = $indexNo;
        $applicantChoice->campus_id = 1; // You can dynamically set this if needed
        $applicantChoice->intake_id = $intakeId;
        $applicantChoice->academic_year_id = $academicYearId;
        $applicantChoice->choice1 = $request->choice1;
        $applicantChoice->choice2 = $request->choice2;
        $applicantChoice->choice3 = $request->choice3;
        $applicantChoice->save();

        // Redirect to success page or back with a success message
        return redirect()->route('applicants-choice.index')->with('success', 'Application submitted successfully.');
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }

    //api of save data
    public function savebyApi(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'choice1' => 'required|exists:programmes,id',
            'choice2' => 'required|exists:programmes,id',
            'choice3' => 'required|exists:programmes,id',

        ]);

        // Retrieve the values from the request
        $indexNo = $request->index_no;
        $academicYearId = $request->academic_year_id;
        $intakeId = $request->intake_id;

        // Retrieve the values for index_no, academic_year_id, and intake_id
        $indexNo = "S2993_0035_2014";  // This should come from the request or be dynamic
        $academicYearId = 1; // This is an example value, you might get it from the request
        $intakeId = 1; // This is an example value, you might get it from the request

        // Check if the index_no exists in the given academic_year_id and intake_id
        $indexNoExists = DB::table('applicants_choices')
            ->where('index_no', $indexNo)
            ->where('academic_year_id', $academicYearId)
            ->where('intake_id', $intakeId)
            ->exists();

        // If index_no exists, return an error response
        if ($indexNoExists) {
            return response()->json(['error' => 'The index_no already exists for the given academic year and intake.'], 400);
        }

        // Save the application choices if index_no does not exist
        $applicantChoice = new ApplicantsChoice();
        $applicantChoice->applicant_user_id = auth()->id();  // If you're saving the user_id
        $applicantChoice->index_no = $indexNo;
        $applicantChoice->campus_id = $request->campus_id ?? 1; // Default to 1 if not provided
        $applicantChoice->intake_id = $intakeId;
        $applicantChoice->academic_year_id = $academicYearId;
        $applicantChoice->choice1 = $request->choice1;
        $applicantChoice->choice2 = $request->choice2;
        $applicantChoice->choice3 = $request->choice3;
        $applicantChoice->save();

        // Return success response
        return response()->json(['message' => 'Application submitted successfully.', 'data' => $applicantChoice], 200);
    }


    //Edit applicant Choice
    public function updateByApi(Request $request, $id)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'choice1' => 'required|exists:programmes,id',
            'choice2' => 'required|exists:programmes,id',
            'choice3' => 'required|exists:programmes,id',
        ]);
        // Retrieve the values for index_no, academic_year_id, and intake_id
        $indexNo = "S2993_0035_2014";  // This should come from the request or be dynamic
        $academicYearId = 1; // This is an example value, you might get it from the request
        $intakeId = 1; // This is an example value, you might get it from the request

        // Retrieve the applicant choice by id
        $applicantChoice = ApplicantsChoice::find($id);

        // If no record is found, return a 404 Not Found error
        if (!$applicantChoice) {
            return response()->json(['error' => 'Application choice not found.'], 404);
        }

        // Update the applicant choice with the new data
        $applicantChoice->applicant_user_id = auth()->id();  // If you're saving the user_id
        $applicantChoice->index_no = $indexNo;
        $applicantChoice->campus_id = $request->campus_id ?? 1; // Default to 1 if not provided
        $applicantChoice->intake_id = $intakeId;
        $applicantChoice->academic_year_id = $academicYearId;
        $applicantChoice->choice1 = $request->choice1;
        $applicantChoice->choice2 = $request->choice2;
        $applicantChoice->choice3 = $request->choice3;
        $applicantChoice->save();
        // Return success response
        return response()->json(['message' => 'Application choice updated successfully.', 'data' => $applicantChoice], 200);
    }
    public function showbyApi($indexNo)
    {
        // Retrieve the application choice by index_no
        $applicantChoice = ApplicantsChoice::where('index_no', $indexNo)->first();
        // If no record is found, return a 404 Not Found error
        if (!$applicantChoice) {
            return response()->json(['error' => 'Application choice not found.'], 404);
        }
        // Return the application choice data
        return response()->json(['data' => $applicantChoice], 200);
    }
}

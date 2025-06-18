<?php

namespace App\Http\Controllers\Selections;

use App\Http\Controllers\Controller;
use App\Models\ApplicationLevel;
use App\Models\Campus;
use App\Models\Programme;
use App\Models\SelectedDiplomaCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NacteProceduresController extends Controller
{
    public function index(Request $request){
        
        $campuses = Campus::get();
        return view('Selection.Nacte.submitted_applicants', compact('campuses'));
    }

    public function submit(Request $request){
        $campus_id = $request->input('campus_id', null);
        $application_level_id = $request->input('application_level_id', null);
        $programme_id = $request->input('programme_id', null);
        $nta_level = null;
        if ($application_level_id) {
            // Extract the part after 'Nta level '
            preg_match('/Nta level (\d+)/', $application_level_id, $matches);
        
            // Check if a match was found, otherwise set a default value (null or another value)
            $nta_level = isset($matches[1]) ? $matches[1] : null;
        }
        

        $seclectedApplicants = SelectedDiplomaCertificate::where('campus_id', $campus_id)
        ->where('iaa_programme_code', $programme_id)
        ->where('nta_level', $nta_level)
        ->get();

        Log::info($seclectedApplicants);
        $campuses = Campus::get();

        return view('Selection.Nacte.submit_applicants', compact('campuses', 'seclectedApplicants'));
    }

    public function fetchLevelByCampus($campus_id) {
        $campus = Campus::find($campus_id);
    
        if (!$campus) {
            return response()->json(['error' => 'Campus not found'], 404);
        }
    
        $applicationLevels = $campus->campusLevels()->select('id', 'nta_level')->get();
    
        return response()->json($applicationLevels);
    }
    

    public function fetchProgrammeByLevel($application_level_data) {
        if ($application_level_data) {
            // Split the value into ID and NTA level
            list($application_level_id, $nta_level) = explode('|', $application_level_data);
    
            // Fetch programmes based on application_level_id
            $programmes = Programme::where('application_level_id', $application_level_id)->get();
    
            return response()->json($programmes);
        }
    
        // Return an empty response if no valid data is provided
        return response()->json(['error' => 'Invalid application level data'], 400);
    }
    
}

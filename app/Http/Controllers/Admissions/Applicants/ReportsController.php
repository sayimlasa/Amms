<?php

namespace App\Http\Controllers\Admissions\Applicants;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ApplicationLevel;
use App\Models\Campus;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Intake;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportsController extends Controller
{
    public function applicationsReport(Request $request)
{
    $campuses = Campus::get();
    $faculties = Faculty::get();
    $ntalevels = ApplicationLevel::get();
    $intakes = Intake::get();

    $validatedData = $request->validate([
        'intake_id' => 'nullable|integer',
        'application_level_id' => 'nullable|integer',
        'campus_id' => 'nullable|integer',
        'faculty_id' => 'nullable|integer',
        'department_id' => 'nullable|integer',
        'programme_id' => 'nullable|integer',
        'gender' => 'nullable|string',
    ]);

    $academicYear = AcademicYear::where('active', 1)->pluck('id');

    // Fetch data grouped by programme and campus
    $applicantsData = DB::table('applicants_users')
        ->join('applicants_choices', 'applicants_users.index_no', '=', 'applicants_choices.index_no')
        ->join('applicants_infos', 'applicants_users.index_no', '=', 'applicants_infos.index_no')
        ->join('application_categories', 'applicants_infos.application_category_id', '=', 'application_categories.id')
        ->join('campuses', 'applicants_infos.campus_id', '=', 'campuses.id')
        ->join('programmes', 'applicants_choices.choice1', '=', 'programmes.id')
        ->where('applicants_choices.academic_year_id', $academicYear)
        
        // Apply filters dynamically
        ->when(!empty($validatedData['intake_id']), function ($query) use ($validatedData) {
            return $query->where('applicants_choices.intake_id', $validatedData['intake_id']);
        })
        ->when(!empty($validatedData['application_level_id']), function ($query) use ($validatedData) {
            return $query->where('application_categories.application_level_id', $validatedData['application_level_id']);
        })
        ->when(!empty($validatedData['campus_id']), function ($query) use ($validatedData) {
            return $query->where('applicants_infos.campus_id', $validatedData['campus_id']);
        })
        ->when(!empty($validatedData['faculty_id']), function ($query) use ($validatedData) {
            return $query->where('programmes.faculty_id', $validatedData['faculty_id']);
        })
        ->when(!empty($validatedData['department_id']), function ($query) use ($validatedData) {
            return $query->where('programmes.department_id', $validatedData['department_id']);
        })
        ->when(!empty($validatedData['programme_id']), function ($query) use ($validatedData) {
            return $query->where('programmes.id', $validatedData['programme_id']);
        })
        ->when(!empty($validatedData['gender']), function ($query) use ($validatedData) {
            return $query->where('applicants_infos.gender', $validatedData['gender']);
        })
        ->select(
            'programmes.short as programme',
            'campuses.name as campus',
            DB::raw('COUNT(applicants_users.index_no) as total_applicants')
        )
        ->groupBy('programmes.short', 'campuses.name')
        ->orderBy('programmes.short', 'asc')
        ->get();

    // Transform into required structure
    $programmes = [];
    $campuses = [];

    foreach ($applicantsData as $data) {
        $programmes[$data->programme][$data->campus] = $data->total_applicants;
        $campuses[$data->campus] = true;
    }

    // Add total column
    foreach ($programmes as $programme => &$values) {
        $values['Total'] = array_sum($values);
    }

    return view('Admission.Applicants.reports.applications-reports', compact('faculties', 'intakes', 'ntalevels', 'programmes', 'campuses'));
}


    public function getNtaByCampus($campus_id)
    {

        $ntalevels = ApplicationLevel::whereHas('campuses', function ($query) use ($campus_id) {
            $query->where('campus_id', $campus_id);
        })->get();

        return response()->json($ntalevels);
    }

    public function getCampusByNta($nta_level_id)
    {
        $campuses = Campus::whereHas('campusLevels', function ($query) use ($nta_level_id) {
            $query->where('application_level_id', $nta_level_id);
        })->get();

        return response()->json($campuses);
    }

    public function getDepartmentByFaculty($faculty_id)
    {
        $faculties = Department::where('faculty_id', $faculty_id)->get();

        return response()->json($faculties);
    }

    public function getProgrammeByFaculty($faculty_id){
        $programmes = Programme::where('faculty_id', $faculty_id)->get();

        return response()->json($programmes);
    }

    public function getProgrammeByDepartment($department_id){
        $programmes = Programme::where('department_id', $department_id)->get();

        return response()->json($programmes);
    }
}

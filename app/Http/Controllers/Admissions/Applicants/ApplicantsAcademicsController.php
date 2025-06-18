<?php

namespace App\Http\Controllers\Admissions\Applicants;

use App\Http\Controllers\Controller;
use App\Models\ApplicantsAcademic;
use App\Models\ApplicantsInfo;
use App\Models\Country;
use App\Models\EducationLevel;
use Illuminate\Http\Request;

class ApplicantsAcademicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applicantAcademics = ApplicantsAcademic::get();

        return view('Admission.Applicants.applicants-academics.index', compact('applicantAcademics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::get();
        $applicants = ApplicantsInfo::whereHas('academicYear', function ($query) {
            $query->where('active', 1);
        })->get();
        return view('Admission.Applicants.applicants-academics.create', compact('applicants','countries'));
    }

    public function getEducationLevels($applicationCategoryId)
    {
        // Fetch education levels related to the given application category
        $educationLevels = EducationLevel::whereHas('educationLevelCategories', function ($query) use ($applicationCategoryId) {
            $query->where('application_category_id', $applicationCategoryId);
        })->get();

        // Return education levels as a JSON response
        return response()->json($educationLevels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApplicantsAcademic  $applicantsAcademic
     * @return \Illuminate\Http\Response
     */
    public function show(ApplicantsAcademic $applicantsAcademic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApplicantsAcademic  $applicantsAcademic
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplicantsAcademic $applicantsAcademic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApplicantsAcademic  $applicantsAcademic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplicantsAcademic $applicantsAcademic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApplicantsAcademic  $applicantsAcademic
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicantsAcademic $applicantsAcademic)
    {
        //
    }
}

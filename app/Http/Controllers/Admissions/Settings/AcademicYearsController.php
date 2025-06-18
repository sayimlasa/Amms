<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Store\StoreAcademicYearRequest;
use App\Http\Requests\Settings\Update\UpdateAcademiYearRequest;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AcademicYearsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $academicyears = AcademicYear::all();
        return view('Admission.Settings.academic-years.index', compact('academicyears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admission.Settings.academic-years.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAcademicYearRequest $request)
    {

        if ($request->active == 1) {
            // Deactivate the currently active academic year
            AcademicYear::where('active', 1)->update(['active' => 0]);
        }
        AcademicYear::create($request->all());

        session()->flash('success', 'Academic Year created successfully!');

        return redirect()->route('academic-years.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicYear $academicYear)
    {
        return view('Admission.Settings.academic-years.show', compact('academicYear'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicYear $academicYear)
    {
        return view('Admission.Settings.academic-years.edit', compact('academicYear'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAcademiYearRequest $request, AcademicYear $academicYear)
{
    // If the 'active' status is being set to 1, ensure others are deactivated
    if ($request->active == 1 && $academicYear->active != 1) {
        // Deactivate the currently active academic year
        AcademicYear::where('active', 1)->update(['active' => 0]);
    }

    $academicYear->update($request->all());
    // Update the academic year
    session()->flash('success', 'Academic Year Updated successfully!');

    return redirect()->route('academic-years.index');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();
        session()->flash('success', 'Academic Year Deleted successfully!');
        return redirect()->route('academic-years.index');
    }
}

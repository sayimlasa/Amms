<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Store\StoreApplicationWindowRequest;
use App\Http\Requests\Settings\Update\UpdateApplicationWindowRequest;
use App\Models\AcademicYear;
use App\Models\ApplicationLevel;
use App\Models\ApplicationWindow;
use App\Models\Intake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApplicationWindowsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applicationWindows = ApplicationWindow::all();

        return view('Admission.Settings.application-windows.index', compact('applicationWindows'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = ApplicationLevel::all();
        $intakes = Intake::all();
        $academicYears = AcademicYear::all();
        return view('Admission.Settings.application-windows.create', compact('levels','intakes', 'academicYears'));
    }

    /**
     * Store a newly created resource in storage. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicationWindowRequest $request)
    {
        if ($request->active == 1) {
            // Deactivate the currently active academic year
            ApplicationWindow::where('active', 1)->update(['active' => 0]);
        }
        ApplicationWindow::create($request->all());

        session()->flash('success', 'category created successfully!');

        return redirect()->route('application-windows.index');
   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApplicationWindow  $applicationWindow
     * @return \Illuminate\Http\Response
     */
    public function show(ApplicationWindow $applicationWindow)
    {
        return view('Admission.Settings.application-windows.show', compact('applicationWindow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApplicationWindow  $applicationWindow
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplicationWindow $applicationWindow)
    {
        $levels = ApplicationLevel::all();
        $intakes = Intake::all();
        $academicYears = AcademicYear::all();
        return view('Admission.Settings.application-windows.edit', compact('levels','intakes', 'academicYears', 'applicationWindow'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApplicationWindow  $applicationWindow
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApplicationWindowRequest $request, ApplicationWindow $applicationWindow)
    {
        if ($request->active == 1 && $applicationWindow->active != 1) {
            ApplicationWindow::where('active', 1)->update(['active' => 0]);
        }
    
        $applicationWindow->update($request->all()); 

        session()->flash('success', 'window updated successfully!');

        return redirect()->route('application-windows.index');
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApplicationWindow  $applicationWindow
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicationWindow $applicationWindow)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Store\StoreIntakeRequest;
use App\Models\Intake;
use Illuminate\Http\Request;

class IntakesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $intakes = Intake::all();
        return view('Admission.Settings.intakes.index', compact('intakes'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admission.Settings.intakes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIntakeRequest $request)
    {
        if ($request->active == 1) {
            // Deactivate the currently active academic year
           Intake::where('active', 1)->update(['active' => 0]);
        }
       Intake::create($request->all());

        session()->flash('success', 'intake created successfully!');

        return redirect()->route('intakes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Intake  $intake
     * @return \Illuminate\Http\Response
     */
    public function show(Intake $intake)
    {
        return view('Admission.Settings.intakes.show', compact('intake'));
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Intake  $intake
     * @return \Illuminate\Http\Response
     */
    public function edit(Intake $intake)
    {
        return view('Admission.Settings.intakes.edit', compact('intake'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Intake  $intake
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Intake $intake)
    {
        if ($request->active == 1 && $intake->active != 1) {
            // Deactivate the currently active academic year
            Intake::where('active', 1)->update(['active' => 0]);
        }
    
        $intake->update($request->all());
        // Update the academic year
        session()->flash('success', 'Intake Updated successfully!');
    
        return redirect()->route('intakes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Intake  $intake
     * @return \Illuminate\Http\Response
     */
    public function destroy(Intake $intake)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Models\AttachmentType;
use Illuminate\Http\Request;

class AttachmentTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attachmentTypes = AttachmentType::all();
        return view('Admission.Settings.attachment-types.index', compact('attachmentTypes'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admission.Settings.attachment-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        AttachmentType::create($request->all());

        session()->flash('success', 'created successfully!');

        return redirect()->route('attachment-types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttachmentType  $attachmentType
     * @return \Illuminate\Http\Response
     */
    public function show(AttachmentType $attachmentType)
    {
        return view('Admission.Settings.attachment-types.show', compact('attachmentType'));
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttachmentType  $attachmentType
     * @return \Illuminate\Http\Response
     */
    public function edit(AttachmentType $attachmentType)
    {
        return view('Admission.Settings.attachment-types.edit', compact('attachmentType'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttachmentType  $attachmentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttachmentType $attachmentType)
    {
        $attachmentType->update($request->all());
        // Update the academic year
        session()->flash('success', 'Updated successfully!');
    
        return redirect()->route('attachment-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttachmentType  $attachmentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttachmentType $attachmentType)
    {
        //
    }
}

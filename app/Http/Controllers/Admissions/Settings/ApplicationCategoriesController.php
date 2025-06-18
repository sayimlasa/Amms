<?php

namespace App\Http\Controllers\Admissions\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Store\StoreApplicationCategoryRequest;
use App\Http\Requests\Settings\Update\UpdateApplicationCategoryRequest;
use App\Models\ApplicationCategory;
use App\Models\ApplicationLevel;
use App\Models\AttachmentType;
use App\Models\EducationLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApplicationCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applicationCategories = ApplicationCategory::all();

        return view('Admission.Settings.application-categories.index', compact('applicationCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = ApplicationLevel::all();
        $educationLevels = EducationLevel::all();
        $attachmentTypes = AttachmentType::all();
        return view('Admission.Settings.application-categories.create', compact('levels','educationLevels', 'attachmentTypes'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicationCategoryRequest $request)
    {
       
        $applicationCategory = ApplicationCategory::create($request->except(['education_level_id','attachment_type_id']));

        $applicationCategory->educationLevels()->attach($request->education_level_id);

        $applicationCategory->attachmentTypes()->attach($request->attachment_type_id);

        session()->flash('success', 'category created successfully!');

        return redirect()->route('application-categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApplicationCategory  $applicationCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ApplicationCategory $applicationCategory)
    {
        return view('Admission.Settings.application-categories.show', compact('applicationCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApplicationCategory  $applicationCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplicationCategory $applicationCategory)
    {
        $levels = ApplicationLevel::all();
        $educationLevels = EducationLevel::all();
        $attachmentTypes = AttachmentType::all();
        return view('Admission.Settings.application-categories.edit', compact('levels', 'applicationCategory', 'educationLevels','attachmentTypes'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApplicationCategory  $applicationCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApplicationCategoryRequest $request, ApplicationCategory $applicationCategory)
    {
        $applicationCategory->update($request->except(['education_level_id','attachment_type_id']));
        // Sync the campuses and intakes
        $applicationCategory->educationLevels()->sync($request->education_level_id);

        $applicationCategory->attachmentTypes()->sync($request->attachment_type_id);
       
        session()->flash('success', 'category updated successfully!');

        return redirect()->route('application-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApplicationCategory  $applicationCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicationCategory $applicationCategory)
    {
        //
    }
}

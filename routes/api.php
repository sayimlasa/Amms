<?php

use App\Http\Controllers\Admin\RolesController;
use Illuminate\Http\Request;
//use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\NextOfKinsController;
use App\Http\Controllers\Api\AttachmentsController;
use App\Http\Controllers\Api\ApplicantAuthController;
use App\Http\Controllers\Api\ApplicantInfoController;
use App\Http\Controllers\Api\EducationLevelsController;
use App\Http\Controllers\Api\ApplicantsAcademicsController;
use App\Http\Controllers\Api\ApplicationCategoriesController;
//use App\Http\Controllers\Api\NextOfKinsController;

Route::post('login', [AuthApiController::class, 'login'])->name('authapi');

Route::post('applicant/login', [ApplicantAuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/applicationCategory', [ApplicationCategoriesController::class, 'index']);
    Route::post('/fetch-student-data', [ApplicationCategoriesController::class, 'fetchStudentData'])->name('fetch-student-data');
    Route::get('/applicant/info', [ApplicantInfoController::class, 'applicantInfo'])->name('applicantInfo');
    Route::get('edit-data/{applicantsInfo}', [ApplicantInfoController::class, 'getEditData']);
    Route::get('relationships', [ApplicantInfoController::class, 'getRelationships']);
    Route::get('nationalities', [ApplicantInfoController::class, 'getNationalities']);
    Route::get('countries', [ApplicantInfoController::class, 'getCountries']);
    Route::get('regions/{country_id}', [ApplicantInfoController::class, 'getRegions']);
    Route::get('districts/{region_id}', [ApplicantInfoController::class, 'getDistricts']);
    Route::get('employers-by-status/{employmentStatusId}', [ApplicantInfoController::class, 'getEmployersByStatus']);
    Route::put('applicants-info/{applicantsInfo}', [ApplicantInfoController::class, 'update']);
    Route::get('nextof-kin/{applicant_user_id}', [NextOfKinsController::class, 'index']);
    Route::post('nextof-kins', [NextOfKinsController::class, 'store']);
    Route::put('nextof-kins/{nextof_kin_id}', [NextOfKinsController::class, 'update']);
    Route::get('employers-by-status/{employmentStatusId}', [ApplicantInfoController::class, 'getEmployersByStatus']);
    Route::put('applicants-info/{applicantsInfo}', [ApplicantInfoController::class, 'update']);
    Route::get('nextof-kin/{applicant_user_id}', [NextOfKinsController::class, 'index']);
    Route::post('nextof-kins', [NextOfKinsController::class, 'store']);
    Route::put('nextof-kins/{nextof_kin_id}', [NextOfKinsController::class, 'update']);
    Route::get('education-levels/{applicationCategoryId}', [EducationLevelsController::class, 'getEducationLevels']);
    Route::post('applicant-academics/{id}/{name}', [ApplicantsAcademicsController::class, 'store']);
    Route::get('applicant-academics/{applicant_user_id}', [ApplicantsAcademicsController::class, 'academicDetails']);
    Route::get('attachment-types/{applicationCategoryId}', [AttachmentsController::class, 'getAttachmentTypes']);
    Route::post('applicant-attachment', [AttachmentsController::class, 'store']);
    Route::get('get-applicant-attachment/{applicant_user_id}/{type_id}', [AttachmentsController::class, 'getAttachments']);
    Route::get('/roles', [RolesController::class, 'indexApi']); // List
    Route::post('/roles', [RolesController::class, 'storeApi']); // Create
    Route::get('/roles/{id}', [RolesController::class, 'showApi']); // Show details
    Route::put('/roles/{id}', [RolesController::class, 'updateApi']); // Edit
    Route::delete('/roles/{id}', [RolesController::class, 'destroy']); // Delete
    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::get('/roles/{role}/edit', [RolesController::class, 'edit'])->name('roles.edit');
    Route::delete('/roles/{role}', [RolesController::class, 'destroy'])->name('roles.destroy');
    Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');

});

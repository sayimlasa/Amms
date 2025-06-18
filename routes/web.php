<?php

use App\Http\Controllers\Admissions\Applicants\ApplicantAttachmentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\HomeController;
//use App\Http\Controllers\RolesController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admission\Applicants\ApplicantsChoice;
use App\Http\Controllers\Admissions\Applicants\ApplicantsChoiceController;
use App\Http\Controllers\Admissions\Applicants\PaymentsController;
use App\Http\Controllers\Admissions\Settings\ApplicationLevelsController;
use App\Http\Controllers\MainDashboradController;

//use App\Http\Controllers\HomeController;
//e App\Http\Controllers\WebController;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Route;



Route::get('/',  [HomeController::class, 'index']);

Auth::routes();

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Permissions
    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::post('roles/parse-csv-import', [RolesController::class, 'parseCsvImport'])->name('roles.parseCsvImport');
    Route::post('roles/process-csv-import', [RolesController::class, 'processCsvImport'])->name('roles.processCsvImport');
    Route::resource('roles', RolesController::class);

    // Users
    Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::post('users/parse-csv-import', [UsersController::class, 'parseCsvImport'])->name('users.parseCsvImport');
    Route::post('users/process-csv-import', [UsersController::class, 'processCsvImport'])->name('users.processCsvImport');
    Route::resource('users', UsersController::class);
    Route::get('myprofile', [UsersController::class, 'myprofile'])->name('myprofile');
});

Route::middleware(['auth'])->namespace('App\Http\Controllers\Admissions\Settings')->group(function () {
    Route::resource('academic-years', 'AcademicYearsController');
    Route::resource('countries', 'CountriesController');
    Route::resource('regions-states', 'RegionsStatesController');
    Route::resource('districts', 'DistrictsController');
    Route::get('get-regions/{country_id}', 'DistrictsController@getRegions')->name('get.regions');
    Route::resource('nationalities', 'NationalitiesController');
    Route::resource('campuses', 'CampusesController');
    Route::get('get-regions/{country_id}', 'CampusesController@getRegions')->name('get.regions');
    Route::get('get-districts/{district_id}', 'CampusesController@getDistricts')->name('get.districts');
    Route::resource('intakes', 'IntakesController');
    Route::resource('application-levels', 'ApplicationLevelsController');
    Route::resource('application-categories', 'ApplicationCategoriesController');
    Route::resource('application-windows', 'ApplicationWindowsController');
    Route::resource('programmes', 'ProgrammesController');
    Route::resource('disabilities', 'DisabilitiesController');
    Route::resource('employment-statuses', 'EmploymentStatusesController');
    Route::resource('marital-statuses', 'MaritalStatusesController');
    Route::resource('relationships', 'RelationshipsController');
    Route::resource('employers', 'EmployersController');
    Route::resource('education-levels', 'EducationLevelsController');
});

Route::middleware(['auth'])->namespace('App\Http\Controllers\Admissions\Applicants')->group(function () {
    Route::resource('applicants-users', 'ApplicantsUsersController');
    Route::resource('applicants-infos', 'ApplicantsInfosController');
    //payment
    Route::resource('application-fee','PaymentsController');
    Route::get('application-fee/check-status/{controlNumber}', [PaymentsController::class, 'checkPaymentStatus'])->name('application-fee.check-status');
    Route::get('application-fee/check-status/{controlNumber}', [PaymentsController::class, 'checkPaymentStatus'])->name('application-fee.check-status');
    Route::post('applications/check-status/{billId}', [PaymentsController::class, 'checkPaymentStatus'])->name('refresh.control');
    Route::post('creantBillID',[PaymentsController::class, 'createBillId'])->name('create.BillId');
    Route::post('createControlno',[PaymentsController::class, 'generateControlNumber'])->name('generate.controlno');
    
    //applicants choices
    Route::resource('applicants-choice','ApplicantsChoiceController');
    Route::get('/applicants-choice/get-levels', [ApplicantsChoiceController::class, 'getLevels'])->name('programme.choice');

    Route::resource('application-fee','PaymentsController');
    Route::get('get-regions/{country_id}', 'ApplicantsInfosController@getRegions')->name('get.regions');
    Route::get('get-districts/{district_id}', 'ApplicantsInfosController@getDistricts')->name('get.districts');
    Route::get('get-employers/{employmentStatusId}', 'ApplicantsInfosController@getEmployersByStatus')->name('get-employers');
    Route::resource('nextof-kins', 'NextOfKinsController');
    Route::resource('applicants-academics', 'ApplicantsAcademicsController');
    Route::resource('attachments', ApplicantAttachmentController::class);
    
});
//Dahsbord
Route::resource('main',MainDashboradController::class);
Route::get('/main-campus', [MainDashboradController::class, 'indexMain'])->name('arusha.campus');
Route::get('/dar-campus', [MainDashboradController::class, 'indexDar'])->name('dar.campus');
Route::get('/babati-campus', [MainDashboradController::class, 'indexBabati'])->name('babati.campus');
Route::get('/dodoma-campus', [MainDashboradController::class, 'indexDodoma'])->name('dodoma.campus');
Route::get('/songea-campus', [MainDashboradController::class, 'indexSongea'])->name('songea.campus');
Route::get('/polisi-campus', [MainDashboradController::class, 'indexPolisi'])->name('polisi.campus');
Route::get('/magereza-campus', [MainDashboradController::class, 'indexMagereza'])->name('magereza.campus');


 

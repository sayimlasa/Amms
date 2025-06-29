<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\BrandsController;
//use App\Http\Controllers\RolesController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Api\AcAssetsController;
use App\Http\Controllers\Api\LocationsController;
use App\Http\Controllers\Api\SupplierSController;
use App\Http\Controllers\MainDashboradController;
use App\Http\Controllers\Api\AcMovementController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admission\Applicants\ApplicantsChoice;
use App\Http\Controllers\Admissions\Applicants\PaymentsController;
use App\Http\Controllers\Admissions\Settings\ApplicationLevelsController;
use App\Http\Controllers\Admissions\Applicants\ApplicantsChoiceController;
use App\Http\Controllers\Admissions\Applicants\ApplicantAttachmentController;
use App\Http\Controllers\ReportsController;

Route::get('/home',  [HomeController::class, 'index'])->name('home');
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
//Dahsbord
Route::resource('main',MainDashboradController::class);
Route::get('/main-campus', [MainDashboradController::class, 'indexMain'])->name('arusha.campus');
Route::get('/dar-campus', [MainDashboradController::class, 'indexDar'])->name('dar.campus');
Route::get('/babati-campus', [MainDashboradController::class, 'indexBabati'])->name('babati.campus');
Route::get('/dodoma-campus', [MainDashboradController::class, 'indexDodoma'])->name('dodoma.campus');
Route::get('/songea-campus', [MainDashboradController::class, 'indexSongea'])->name('songea.campus');
Route::get('/polisi-campus', [MainDashboradController::class, 'indexPolisi'])->name('polisi.campus');
Route::get('/magereza-campus', [MainDashboradController::class, 'indexMagereza'])->name('magereza.campus');
Route::resource('locations', LocationsController::class);
Route::resource('brands', BrandsController::class);
Route::resource('suppliers', SupplierSController::class);
Route::resource('ac-assets', AcAssetsController::class);
Route::resource('ac-movements', AcMovementController::class);
Route::get('/ac-assets/{id}', [AcAssetsController::class, 'getAsset'])->name('ac-assets.get');
Route::get('/track/history', [ReportsController::class, 'index'])->name('track.history');
Route::get('/reference/{id}', [AcAssetsController::class, 'getReference'])->name('ac-assets.reference');
Route::get('/dasboard', [ReportsController::class, 'sample'])->name('sample');
Route::get('/attachments', [AcAssetsController::class, 'attachments'])->name('attachments.index');









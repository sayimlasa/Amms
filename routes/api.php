<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BrandsController;
 use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Api\AcAssetsController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\LocationsController;
use App\Http\Controllers\Api\SupplierSController;
use App\Http\Controllers\Api\ApplicantAuthController;

//use App\Http\Controllers\Api\NextOfKinsController;

Route::post('login', [AuthApiController::class, 'login'])->name('authapi');

Route::post('applicant/login', [ApplicantAuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
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
    Route::apiResource('brands', BrandsController::class);
    Route::apiResource('locations', LocationsController::class);
    Route::apiResource('suppliers', SupplierSController::class);
    //Route::apiResource('ac-assets', AcAssetsController::class);

});

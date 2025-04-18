<?php

use App\Http\Controllers\DoaFacilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/createUser', [DoaFacilController::class, 'createUser']);
Route::get('/getUsers', [DoaFacilController::class, 'getUsers']);
Route::get('/getUser/{id}', [DoaFacilController::class, 'getUserById']);
Route::get('/getUsers/{type}', [DoaFacilController::class, 'getUserByType']);
Route::get('/validateUser', [DoaFacilController::class, 'validateUser']);
Route::put('/updateUser/{id}', [DoaFacilController::class, 'updateUser']);
Route::delete('/deleteUser/{id}', [DoaFacilController::class, 'deleteUser']);

Route::get('/donations', [DoaFacilController::class, 'donations']);
Route::get('/donations/{id}', [DoaFacilController::class, 'getDonationById']);
Route::post('/createDonation', [DoaFacilController::class, 'createDonation']);
Route::put('/updateDonation/{id}', [DoaFacilController::class, 'updateDonation']);
Route::delete('/deleteDonation/{id}', [DoaFacilController::class, 'deleteDonation']);
Route::get('/donationsFiltered', [DoaFacilController::class, 'getDonationsByFilter']);

Route::get('/rescues', [DoaFacilController::class, 'getRescues']);
Route::get('/rescuesFiltered', [DoaFacilController::class, 'getRescueByFilter']);
Route::post('/createRescue', [DoaFacilController::class, 'createRescue']);
Route::put('/updateRescue/{id}', [DoaFacilController::class, 'updateRescue']);
Route::delete('/deleteRescue/{id}', [DoaFacilController::class, 'deleteRescue']);

Route::post('createCategory', [DoaFacilController::class, 'createCategory']);
Route::get('categories', [DoaFacilController::class, 'getCategories']);
Route::get('categories/{id}', [DoaFacilController::class, 'getCategoryById']);
Route::put('updateCategory/{id}', [DoaFacilController::class, 'updateCategory']);
Route::delete('deleteCategory/{id}', [DoaFacilController::class, 'deleteCategory']);

Route::post('createDonationImage', [DoaFacilController::class, 'createDonationImage']);
Route::get('donationImages', [DoaFacilController::class, 'getDonationImages']);
Route::get('donationImages/{id}', [DoaFacilController::class, 'getDonationImageById']);
Route::put('updateDonationImage/{id}', [DoaFacilController::class, 'updateDonationImage']);
Route::delete('deleteDonationImage/{id}', [DoaFacilController::class, 'deleteDonationImage']);

<?php

use App\Http\Controllers\DoaFacilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/donations', [DoaFacilController::class, 'donations']);
Route::post('/register', [DoaFacilController::class, 'register']);

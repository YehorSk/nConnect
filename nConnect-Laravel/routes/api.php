<?php

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StageController;
use \App\Http\Controllers\TimeSlotController;
use \App\Http\Controllers\GalleryController;
use \App\Http\Controllers\SponsorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('stages',StageController::class);

//Get all time slots for the stage
Route::get('/get-time-slots/{id}',[TimeSlotController::class,'index']);

Route::apiResource('slots', TimeSlotController::class);

Route::apiResource('gallery', GalleryController::class);

Route::apiResource('sponsors',SponsorController::class);

Route::apiResource('reviews',ReviewController::class);


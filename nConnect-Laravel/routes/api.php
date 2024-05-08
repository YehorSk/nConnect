<?php

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StageController;
use \App\Http\Controllers\TimeSlotController;
use \App\Http\Controllers\GalleryController;
use \App\Http\Controllers\ConferenceController;
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

//----------------------------Stages Routes---------------------------------
Route::apiResource('stages',StageController::class);
Route::get('/get-current-conference-stages',[StageController::class,'get_current_conference_stages']);
Route::get('/get-available-stages',[StageController::class,'get_available_stages']);
Route::post('/add-stages-to-conference',[StageController::class,'addStageToConference']);
Route::delete('/delete-stage-from-conference/{id}',[StageController::class,'deleteStageFromConference']);
//----------------------------End Stages Routes ----------------------------

//----------------------------Sponsors Routes---------------------------------

Route::apiResource('sponsors',SponsorController::class);
Route::get('/get-current-conference-sponsors',[SponsorController::class,'get_current_conference_sponsors']);
Route::get('/get-available-sponsors',[SponsorController::class,'get_available_sponsors']);
Route::post('/add-sponsor-to-conference',[SponsorController::class,'addSponsorsToConference']);
Route::delete('/delete-sponsor-from-conference/{id}',[SponsorController::class,'deleteSponsorFromConference']);

//----------------------------End Sponsors Routes ----------------------------


Route::apiResource('conferences',ConferenceController::class);
Route::get('/get-active-conference',[ConferenceController::class,'get_active_conference']);

//Get all time slots for the stage
Route::get('/get-time-slots/{id}',[TimeSlotController::class,'index']);

Route::apiResource('slots', TimeSlotController::class);

Route::apiResource('gallery', GalleryController::class);
Route::post('/add-gallery-to-conference',[GalleryController::class,'addGalleryToConference']);
Route::get('/get-current-conference-gallery',[GalleryController::class,'get_current_conference_gallery']);
Route::get('/get-available-gallery',[GalleryController::class,'get_available_gallery']);
Route::delete('/delete-gallery-from-conference/{id}',[GalleryController::class,'deleteGalleryFromConference']);





Route::apiResource('reviews',ReviewController::class);


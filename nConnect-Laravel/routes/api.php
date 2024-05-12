<?php

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\StageController;
use \App\Http\Controllers\TimeSlotController;
use \App\Http\Controllers\GalleryController;
use \App\Http\Controllers\ConferenceController;
use \App\Http\Controllers\SponsorController;
use \App\Http\Controllers\LectureController;
use App\Http\Controllers\OrganizerController;
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

//----------------------------Speakers Routes---------------------------------

Route::apiResource('speakers',SpeakerController::class);
Route::post('/upload-image', [SpeakerController::class, 'uploadImage']);

Route::get('/get-current-conference-speakers',[SpeakerController::class,'get_current_conference_speakers']);
Route::get('/get-available-speakers',[SpeakerController::class,'get_available_speakers']);
Route::post('/add-speakers-to-conference',[SpeakerController::class,'addSpeakersToConference']);
Route::delete('/delete-speakers-from-conference/{id}',[SpeakerController::class,'deleteSpeakerFromConference']);

//----------------------------End Sponsors Routes ----------------------------

//----------------------------Lectures Routes---------------------------------
Route::apiResource('lectures',LectureController::class);
Route::get('/get-current-conference-lectures',[LectureController::class,'get_current_conference_lectures']);
Route::post('/add-speaker-to-lecture',[LectureController::class,'addSpeakerToLecture']);
Route::post('/add-stage-to-lecture',[LectureController::class,'addStageToLecture']);

//------------------------------------------------------------------------

//----------------------------Organizers Routes---------------------------------
Route::apiResource('organizers',OrganizerController::class);
Route::put('organizers/{id}', [OrganizerController::class, 'update']);
Route::get('/get_current_conference_organizers',[OrganizerController::class,'get_current_conference_organizers']);
Route::get('/get-available-organizers',[OrganizerController::class,'get_available_organizers']);
Route::post('/add-organizers-to-conference',[OrganizerController::class,'addOrganizersToConference']);
Route::delete('/delete-organizers-from-conference/{id}',[OrganizerController::class,'deleteOrganizerFromConference']);

//------------------------------------------------------------------------

//----------------------------Conference Routes---------------------------------

Route::apiResource('conferences',ConferenceController::class);
Route::get('/get-active-conference',[ConferenceController::class,'get_active_conference']);

//-------------------------------------------------------------


//----------------------------Gallery Routes---------------------------------

Route::apiResource('gallery', GalleryController::class);

//-------------------------------------------------------------

//----------------------------Lecture Routes---------------------------------

Route::apiResource('reviews',ReviewController::class);

//------------------------------------------------------------

//Get all time slots for the stage
Route::get('/get-time-slots/{id}',[TimeSlotController::class,'index']);

Route::apiResource('slots', TimeSlotController::class);

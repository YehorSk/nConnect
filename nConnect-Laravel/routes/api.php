<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\StageController;
use \App\Http\Controllers\GalleryController;
use \App\Http\Controllers\ConferenceController;
use \App\Http\Controllers\SponsorController;
use \App\Http\Controllers\LectureController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use \App\Http\Controllers\VerificationController;

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

Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->name('password.email');

Route::get('/reset-password/{token}/{email}', [AuthController::class, 'reset_password'])->name('password.reset');

Route::post('/update-password', [AuthController::class, 'update_password']);

Route::post('/send-email',[EmailController::class, 'sendEmail']);

//Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);
Route::get('/fetchuser', [AuthController::class, 'fetchUser']);
Route::get('/users-regular', [AuthController::class, 'getRegularUsers']);
Route::get('/users-admin', [AuthController::class, 'getAdminUsers']);
Route::get('/user-lectures', [AuthController::class, 'fetchLectures']);
Route::post('/user-add-lecture', [AuthController::class, 'addLecture']);
Route::post('/user-remove-lecture', [AuthController::class, 'removeLecture']);
Route::post('/user-add-admin', [AuthController::class, 'addAdminUser']);
Route::post('/user-remove-admin', [AuthController::class, 'removeAdminUser']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

//----------------------------Stages Routes---------------------------------
Route::apiResource('stages',StageController::class);
Route::get('/get-current-conference-stages',[StageController::class,'get_current_conference_stages']);
Route::get('/get-available-stages',[StageController::class,'get_available_stages']);
Route::post('/add-stages-to-conference',[StageController::class,'addStageToConference']);
Route::delete('/delete-stage-from-conference/{id}',[StageController::class,'deleteStageFromConference']);
Route::put('/update-stage-in-conference/{id}',[StageController::class,'updateInConference']);
//----------------------------End Stages Routes ----------------------------

//----------------------------Sponsors Routes---------------------------------

Route::apiResource('sponsors',SponsorController::class);
Route::get('/get-current-conference-sponsors',[SponsorController::class,'get_current_conference_sponsors']);
Route::post('/upload-sponsor-image', [SponsorController::class, 'uploadSponsorImage']);
Route::get('/get-available-sponsors',[SponsorController::class,'get_available_sponsors']);
Route::post('/add-sponsor-to-conference',[SponsorController::class,'addSponsorsToConference']);
Route::delete('/delete-sponsor-from-conference/{id}',[SponsorController::class,'deleteSponsorFromConference']);

//----------------------------Speakers Routes---------------------------------

Route::apiResource('speakers',SpeakerController::class);
Route::post('/upload-image', [SpeakerController::class, 'uploadImage']);
Route::get('/single-speaker/{id}', [SpeakerController::class, 'show']);
Route::get('/get-current-conference-speakers',[SpeakerController::class,'get_current_conference_speakers']);
Route::get('/get-available-speakers',[SpeakerController::class,'get_available_speakers']);
Route::post('/add-speakers-to-conference',[SpeakerController::class,'addSpeakersToConference']);
Route::delete('/delete-speakers-from-conference/{id}',[SpeakerController::class,'deleteSpeakerFromConference']);

//----------------------------End Sponsors Routes ----------------------------

//----------------------------Lectures Routes---------------------------------
Route::apiResource('lectures',LectureController::class);
Route::get('/get-current-conference-lectures',[LectureController::class,'get_current_conference_lectures']);
Route::get('/get-lecture-users/{id}',[LectureController::class,'get_lecture_users']);
Route::post('/add-speaker-to-lecture',[LectureController::class,'addSpeakerToLecture']);
Route::post('/add-stage-to-lecture',[LectureController::class,'addStageToLecture']);

//------------------------------------------------------------------------

//----------------------------Organizers Routes---------------------------------
Route::apiResource('organizers',OrganizerController::class);
Route::post('/upload-organizer-image', [OrganizerController::class, 'uploadOrganizerImage']);
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
Route::post('/upload-gallery-image', [GalleryController::class, 'uploadGalleryImage']);
//-------------------------------------------------------------

//----------------------------Review Routes---------------------------------

Route::apiResource('reviews',ReviewController::class);
Route::post('/upload-review-image', [ReviewController::class,'uploadReviewImage']);
//------------------------------------------------------------

//----------------------------Pages Routes---------------------------------
Route::apiResource('pages',PageController::class);
Route::get('/get-current-page/{id}', [PageController::class, 'getCurrentPage' ]);
//---------------------------------------------------------------------------------

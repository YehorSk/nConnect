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
use App\Http\Controllers\UserController;
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

//Login/logout/forgot pwd routes
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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

//Auth routes
Route::controller(AuthController::class)->group(function (){
    Route::get('/reset-password/{token}/{email}','reset_password')->name('password.reset');
    Route::post('/update-password', 'update_password');
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

//Contact form routes
Route::post('/send-email',[EmailController::class, 'sendEmail']);

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

//User routes
Route::controller(UserController::class)->group(function (){
    Route::get('/fetchuser','fetchUser');
    Route::get('/users-regular', 'getRegularUsers');
    Route::get('/users-admin','getAdminUsers');
    Route::get('/user-lectures','fetchLectures');
    Route::post('/user-add-lecture', 'addLecture');
    Route::post('/user-remove-lecture', 'removeLecture');
    Route::post('/user-add-admin', 'addAdminUser');
    Route::post('/user-remove-admin','removeAdminUser');
});


//----------------------------Stages Routes---------------------------------

Route::controller(StageController::class)->group(function () {
    Route::apiResource('stages', StageController::class);
    Route::get('/get-current-conference-stages', 'get_current_conference_stages');
    Route::get('/get-available-stages', 'get_available_stages');
    Route::post('/add-stages-to-conference', 'addStageToConference');
    Route::delete('/delete-stage-from-conference/{id}', 'deleteStageFromConference');
    Route::put('/update-stage-in-conference/{id}', 'updateInConference');
});
//----------------------------End Stages Routes ----------------------------

//----------------------------Sponsors Routes---------------------------------

Route::controller(SponsorController::class)->group(function () {
    Route::apiResource('sponsors', SponsorController::class);
    Route::get('get-current-conference-sponsors', 'get_current_conference_sponsors');
    Route::get('get-current-conference-sponsors-all', 'get_current_conference_sponsors_all');
    Route::post('upload-sponsor-image', 'uploadSponsorImage');
    Route::get('get-available-sponsors', 'get_available_sponsors');
    Route::post('add-sponsor-to-conference', 'addSponsorsToConference');
    Route::delete('delete-sponsor-from-conference/{id}', 'deleteSponsorFromConference');
});

//----------------------------Speakers Routes---------------------------------

Route::controller(SpeakerController::class)->group(function () {
    Route::apiResource('speakers', SpeakerController::class);
    Route::post('upload-image', 'uploadImage');
    Route::get('single-speaker/{id}', 'show');
    Route::get('get-current-conference-speakers', 'get_current_conference_speakers');
    Route::get('get-current-conference-speakers-all', 'get_current_conference_speakers_all');
    Route::get('get-available-speakers', 'get_available_speakers');
    Route::post('add-speakers-to-conference', 'addSpeakersToConference');
    Route::delete('delete-speakers-from-conference/{id}', 'deleteSpeakerFromConference');
});

//----------------------------End Sponsors Routes ----------------------------

//----------------------------Lectures Routes---------------------------------

Route::controller(LectureController::class)->group(function () {
    Route::apiResource('lectures', LectureController::class);
    Route::get('get-current-conference-lectures', 'get_current_conference_lectures');
    Route::get('get-lecture-users/{id}', 'get_lecture_users');
    Route::post('add-speaker-to-lecture', 'addSpeakerToLecture');
    Route::post('add-stage-to-lecture', 'addStageToLecture');
});

//------------------------------------------------------------------------

//----------------------------Organizers Routes---------------------------------

Route::controller(OrganizerController::class)->group(function () {
    Route::apiResource('organizers', OrganizerController::class);
    Route::post('upload-organizer-image', 'uploadOrganizerImage');
    Route::get('get_current_conference_organizers', 'get_current_conference_organizers');
    Route::get('get_current_conference_organizers_all', 'get_current_conference_organizers_all');
    Route::get('get-available-organizers', 'get_available_organizers');
    Route::post('add-organizers-to-conference', 'addOrganizersToConference');
    Route::delete('delete-organizers-from-conference/{id}', 'deleteOrganizerFromConference');
});

//------------------------------------------------------------------------

//----------------------------Conference Routes---------------------------------

Route::controller(ConferenceController::class)->group(function () {
    Route::apiResource('conferences', ConferenceController::class);
    Route::get('get-active-conference', 'get_active_conference');
    Route::get('get-conference-users/{id}', 'getConferenceUsers');
    Route::post('user-add-conference', 'addUser');
    Route::post('user-remove-conference', 'removeUser');
    Route::post('user-has-conference', 'userHasCurrentConference');
});

//-------------------------------------------------------------


//----------------------------Gallery Routes---------------------------------

Route::apiResource('gallery', GalleryController::class);
Route::post('/upload-gallery-image', [GalleryController::class, 'uploadGalleryImage']);
//-------------------------------------------------------------

//----------------------------Review Routes---------------------------------

Route::apiResource('reviews',ReviewController::class);
Route::get('/display-reviews', [ReviewController::class, 'display']);
Route::post('/upload-review-image', [ReviewController::class,'uploadReviewImage']);
//------------------------------------------------------------

//----------------------------Pages Routes---------------------------------
Route::apiResource('pages',PageController::class);
Route::get('/get-current-page/{id}', [PageController::class, 'getCurrentPage' ]);
//---------------------------------------------------------------------------------

<?php

use App\Http\Controllers\Api\FrontendManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::controller(FrontendManagementController::class)->group(function () {
    // Route::get('/get/frontend/setting', 'getFrontendSetting')->name('get.frontend-setting');
    Route::get('/get/use-cases', 'getUseCases')->name('get.use-cases');
    Route::get('/get/blogs', 'getBlogs')->name('get.blogs');
    Route::get('/get/faqs', 'getFaqs')->name('get.faqs');
    Route::get('/get/cookie/page', 'getCookiePage')->name('get.cookies.page');
    Route::get('/get/privacy/page', 'getPrivacyPage')->name('get.privacy.page');
    Route::get('/get/term/page', 'getTermPage')->name('get.term.page');
    Route::get('/get/reviews', 'getCustomerReviews')->name('get.reviews');
    Route::get('/get/languages', 'getLanguages')->name('get.languages');
    Route::get('/get/voices', 'getVoices')->name('get.voices');
    Route::get('/get/seo-and-logo', 'getSeoAndLogo')->name('get.seo-and-logo');
    Route::get('/get/careers', 'getCareers')->name('get.careers');
});

Route::middleware('auth:api')->group(function () {
    Route::controller(FrontendManagementController::class)->group(function () {
        Route::get('/get/frontend/setting', 'getFrontendSetting')->name('get.frontend-setting');
    });
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthContoller;
use App\Http\Controllers\verificationController;
use App\Http\Controllers\CustomEmailVerification;
use App\Http\Controllers\forgotPasswordController;
use App\Http\Controllers\checkRouteGaurdController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|//
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register', [AuthContoller::class, 'register']);
Route::post('/login', [AuthContoller::class, 'login']);

Route::post('/verify{id}', [verificationController::class, 'verify'])->name('verification.verify');
Route::post('/resend', [verificationController::class, 'resend'])->name('verification.resend');

Route::post('/forgot', [forgotPasswordController::class, 'forgot']);
Route::post('/reset', [forgotPasswordController::class, 'reset']);


//Route::post('/adminlogin', [AuthContoller::class, 'adminlogin']); //For admin Login
Route::middleware('auth:api')->group(function() { // Working as Gaurd Group Route
    Route::post('/check', [checkRouteGaurdController::class, 'check']); 
    Route::post('/admincheck', [checkRouteGaurdController::class, 'scopecheck']); //For Scope
});

Route::post('/sendcustomverify', [CustomEmailVerification::class, 'sendemail']);
Route::get('/customemailverify/{token}', [CustomEmailVerification::class, 'verifyemail']);
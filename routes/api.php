<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\signupController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\GameInfoController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\SkinsController;




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('/login', [loginController::class, 'apiSignIn']);
Route::post('/logout', [loginController::class, 'apiLogout'])->middleware('auth:sanctum');


Route::post('/register', [SignupController::class, 'apiSignUp']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'apiForgotPassword']);

Route::post('/google-login', [GoogleAuthController::class, 'apiGoogleLogin']);

Route::post('/reset-password', [ResetPasswordController::class, 'apiResetPassword']);


Route::get('/user-profile/{userId}', [GameInfoController::class, 'getUserProfile']);


Route::get('/apiverify-email/{token}', [VerificationController::class, 'apiverify']);



Route::get('/skins-and-backgrounds', [SkinsController::class, 'getSkinsAndBackgrounds']);
Route::post('/purchase-item', [SkinsController::class, 'purchaseItem']);
Route::post('/select-item', [SkinsController::class, 'selectItem']);


Route::post('/update-profile-image', [GameInfoController::class, 'apiupdateProfileImage']);
Route::post('/reset-score-retry', [GameInfoController::class, 'resetScoreAndRetryTimes']);

Route::post('/change-password', [GameInfoController::class, 'changePassword']);
Route::post('/update-score-coins', [GameInfoController::class, 'updateScoreAndCoins']);
Route::get('/get-item-by-id', [SkinsController::class, 'getItemById']);








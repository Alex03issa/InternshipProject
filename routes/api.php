<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\signupController as SignupController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\GameInfoController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\SkinsController;




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// Public auth endpoints (rate limited per IP).
Route::middleware('throttle:10,1')->group(function () {
    Route::post('/login', [loginController::class, 'apiSignIn']);
    Route::post('/register', [SignupController::class, 'apiSignUp']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'apiForgotPassword']);
    Route::post('/google-login', [GoogleAuthController::class, 'apiGoogleLogin']);
    Route::post('/reset-password', [ResetPasswordController::class, 'apiResetPassword']);
    Route::get('/apiverify-email/{token}', [VerificationController::class, 'apiverify']);
});

// Game endpoints: the player is always the owner of the Sanctum token
// (Authorization: Bearer <token>); a user_id in the request is ignored.
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::post('/logout', [loginController::class, 'apiLogout']);

    Route::get('/user-profile', [GameInfoController::class, 'getUserProfile']);
    Route::get('/user-profile/{userId}', [GameInfoController::class, 'getUserProfile']);

    Route::get('/skins-and-backgrounds', [SkinsController::class, 'getSkinsAndBackgrounds']);
    Route::post('/purchase-item', [SkinsController::class, 'purchaseItem']);
    Route::post('/select-item', [SkinsController::class, 'selectItem']);
    Route::get('/get-item-by-id', [SkinsController::class, 'getItemById']);

    Route::post('/update-profile-image', [GameInfoController::class, 'apiupdateProfileImage']);
    Route::post('/reset-score-retry', [GameInfoController::class, 'resetScoreAndRetryTimes']);
    Route::post('/update-score-coins', [GameInfoController::class, 'updateScoreAndCoins']);

    Route::post('/change-password', [GameInfoController::class, 'changePassword'])->middleware('throttle:5,1');
});

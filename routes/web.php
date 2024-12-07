<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\signupController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\AppleAuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route to the home page without restrictions
Route::get('/', [PostController::class, 'showPage'])->defaults('categoryTitle', 'Homepage')->name('homepage');

// Route to the home page with verification
Route::get('/home', [HomeController::class, 'showHomepageWithVerification'])->middleware(['auth'])->name('home.verified');


Route::get('/privacy-policy', [PostController::class, 'showPage'])->defaults('categoryTitle', 'Privacy Policy')->name('privacy.policy');
Route::get('/terms-conditions', [PostController::class, 'showPage'])->defaults('categoryTitle', 'Terms & Conditions')->name('terms.conditions');
Route::get('/blog', [PostController::class, 'showPage'])->defaults('categoryTitle', 'Blog')->name('blog');


Route::get('/aboutus', function () {
    return redirect(route('homepage') . '#aboutus');
})->name('aboutus');

Route::get('/download', function () {
    return redirect(route('homepage') . '#download');
})->name('download');


Route::get('/signup', [signupController::class, 'showSignUp'])->name('signup');
Route::post('/signup', [signupController::class, 'signUp'])->name('signup.submit');



Route::get('/login', [loginController::class, 'showSignIn'])->name('login');
Route::post('/login', [loginController::class, 'signIn'])->name('login.submit');
Route::post('/logout', [loginController::class, 'logout'])->name('logout');




// Google login routes
Route::post('/store-timezone', [GoogleAuthController::class, 'storeTimezone'])->name('store.timezone');
Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');


// Apple login routes (if using Apple ID login)

Route::get('auth/apple/redirect', [AppleAuthController::class, 'redirectToApple'])->name('apple.redirect');
Route::get('auth/apple/callback', [AppleAuthController::class, 'handleAppleCallback'])->name('apple.callback');


Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('verify.email');


Route::get('storage/uploads/{filename}', function ($filename) {
    $path = storage_path('app/public/uploads/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    // Get the correct mime type
    $mimeType = File::mimeType($path);

    // Return file with headers
    return Response::file($path, [
        'Content-Type' => $mimeType,
        'X-Content-Type-Options' => 'nosniff'
    ]);
});


// Password Reset routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::get('/track-click/{adId}', [AdController::class, 'trackClick'])->name('trackClick');
Route::get('/ads/{adId}/client-report', [AdController::class, 'downloadClientReport'])->name('ad.downloadClientReport');
Route::get('/ads/admin-report', [AdController::class, 'downloadAdminReport'])->name('ad.downloadAdminReport');


Route::post('/user/update-last-visit', [HomeController::class, 'updateLastVisit'])->name('user.updateLastVisit');


Route::post('/track-activity', [UserActivityController::class, 'updateCurrentVisit'])->name('track.activity');



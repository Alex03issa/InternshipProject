<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\signupController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\AppleAuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\HomeController;
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
Route::get('/', [HomeController::class, 'showHomepage'])->name('homepage');

// Route to the home page with verification
Route::get('/home', [HomeController::class, 'showHomepageWithVerification'])->middleware(['auth'])->name('home.verified');

// Route to the blog page
Route::get('/blog', function () {
    return view('blog');
})->name('blog');

// Route to the terms page
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

// Route to the privacy page
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');


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


Route::middleware(['auth', 'CheckAdmin'])->group(function () {

});


// Google login routes
Route::post('/store-timezone', [GoogleAuthController::class, 'storeTimezone'])->name('store.timezone');
Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');

//password creation

Route::get('auth/password/create', [PasswordController::class, 'showCreateForm'])->name('password.create');
Route::post('auth/password/store', [PasswordController::class, 'store'])->name('password.store');

// Apple login routes (if using Apple ID login)

Route::get('auth/apple/redirect', [AppleAuthController::class, 'redirectToApple'])->name('apple.redirect');
Route::get('auth/apple/callback', [AppleAuthController::class, 'handleAppleCallback'])->name('apple.callback');

//password prompt
Route::get('/password/prompt', [PasswordController::class, 'prompt'])->name('password.prompt');
Route::post('/password/choice', [PasswordController::class, 'handleChoice'])->name('password.choice');

Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('verify.email');



Route::get('/send-test-email', function () {
    Mail::raw('This is a test email', function($message) {
        $message->to('aissait18@gmail.com')
                ->subject('Test Email');
    });

    return 'Test email sent!';
});


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



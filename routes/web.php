<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\signupController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\Auth\GoogleAuthController;

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

Route::get('/', function () {
    return view('Homepage');
})->name('homepage');


Route::get('/signup', [signupController::class, 'showSignUp'])->name('signup');
Route::post('/signup', [signupController::class, 'signUp'])->name('signup.submit');



Route::get('/login', [loginController::class, 'showSignIn'])->name('login');
Route::post('/login', [loginController::class, 'signIn'])->name('login.submit');
Route::post('/logout', [loginController::class, 'logout'])->name('logout');




Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);



Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/terms', function () {
    return view('terms');
});


<?php

use Illuminate\Support\Facades\Route;

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
// routes/web.php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\GithubController;
// routes/web.php

Route::middleware(['web'])->group(function () {
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
    Route::get('/home', function(){
        return "you are logged in";
    })->name('home')->middleware('auth');
    Route::get('auth/github', [GithubController::class, 'redirectToGithub']);
    Route::get('auth/github/callback', [GithubController::class, 'handleGithubCallback']);
});




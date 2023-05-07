<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\UserController;

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

Route::group(['middleware' => ['guest']], function() {
    /**
     * Login Routes
     */
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
    /**
     * Register Routes
     */
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

});
/**
 * Google SSO Auth Routes
 */
Route::controller(GoogleAuthController::class)->group(function(){
    Route::get('google-auth', 'redirectToGoogle')->name('auth.google');
    Route::get('google-auth/callback', 'handleGoogleCallback');
});

Route::get('/', [UserController::class, 'index'])->name('home')->middleware('auth');
Route::get('/home', [UserController::class, 'index'])->name('home')->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
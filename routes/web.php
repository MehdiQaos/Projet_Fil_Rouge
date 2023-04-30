<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\gameController;
use App\Http\Controllers\playController;
use App\Http\Controllers\UserController;
use App\Models\Game;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome')->middleware('guest');

Route::middleware('auth')->group(function() {
    Route::view('/home', 'home')->name('home'); 
    Route::view('/games', 'mygames');
    Route::view('/profile', 'users.profile');
    Route::get('/games/{game}', [gameController::class, 'view']);
    Route::get('/custom', [playController::class, 'custom']);
    Route::get('/find', [playController::class, 'find']);
});

Route::get('/guest', [playController::class, 'guest']);

// auth
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::get('/register', [UserController::class, 'create'])->middleware('guest');
Route::post('/users', [AuthController::class, 'store']);
Route::post('/users/profile', [UserController::class, 'update']);
Route::post('/users/password', [UserController::class, 'password']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::post('/users/authenticate', [AuthController::class, 'authenticate']);
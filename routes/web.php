<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('custom');
})->name('home')->middleware('auth');

Route::get('/custom', function () {
    return view('custom');
})->middleware('auth');

Route::get('/pgn', function () {
    return view('pgnview');
})->middleware('auth');

Route::get('/games', function () {
    return view('mygames');
})->middleware('auth');

Route::get('/games/{game}', function(Game $game) {
    return view('mygame', [
        'game' => $game,
    ]);
});

Route::get('/find', function(Game $game) {
    return view('find');
})->middleware('auth');

// auth
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::get('/register', [UserController::class, 'create'])->middleware('guest');
Route::post('/users', [AuthController::class, 'store']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::post('/users/authenticate', [AuthController::class, 'authenticate']);
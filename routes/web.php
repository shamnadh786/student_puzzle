<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
Route::get('/', function () {
    return view('layouts.home');
});
Route::get('/login', function () {
    return view('login.student_login');
})->name('login');

Route::any('/start-game', [GameController::class, 'index'])->name('game.start');
Route::middleware('auth:student')->group(function () {
    Route::post('/storeWord', [GameController::class, 'storeWord'])->name('game.storeWord');
    Route::get('/finish', [GameController::class, 'finishGame'])->name('game.finish');
    Route::get('/leaderboard', [GameController::class, 'leaderBoard'])->name('game.leaderBoard');
    Route::get('/signout', [GameController::class, 'signout'])->name('signout');
});

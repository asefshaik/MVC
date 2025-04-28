<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ScoreController;


Route::get('/', function () {
    return view('welcome');
});


Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/game', [GameController::class, 'index'])->name('game');
    Route::post('/save-score', [GameController::class, 'storeScore'])->name('save-score');
    Route::get('/leaderboard', [ScoreController::class, 'index'])->name('leaderboard');
    Route::get('/debug-scores', function() {
        return App\Models\GameScore::with('user')->get();
    });
    Route::get('/debug-leaderboard', function() {
        $scores = App\Models\GameScore::with('user')->get();
        return [
            'database_records' => $scores,
            'view_data' => app(App\Http\Controllers\ScoreController::class)->index(),
            'auth_user' => auth()->user()
        ];
    });
Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');

});
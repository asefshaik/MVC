<?php

namespace App\Http\Controllers;

use App\Models\GameScore;

class ScoreController extends Controller
{
    public function index()
{
    $scores = GameScore::with('user')
        ->orderBy('time')
        ->orderBy('moves')
        ->take(10)
        ->get()
        ->map(function ($score, $index) {
            return [
                'rank' => $index + 1,
                'player' => $score->user->name,
                'moves' => $score->moves,
                'time' => $score->time
            ];
        });

    logger()->info('Leaderboard Data:', $scores->toArray());
    
    return view('leaderboard', ['scores' => $scores]);
}
}
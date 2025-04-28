<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use App\Models\PlayerStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GameController extends Controller
{
    public function index()
    {
        return view('game');
    }

    public function storeScore(Request $request)
    {
        $validated = $request->validate([
            'moves' => 'required|integer|min:1',
            'time' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $moves = $validated['moves'];
        $timeTaken = $validated['time'];
        $cardCount = 16; 
        $isPerfectGame = $moves == ($cardCount / 2); 


        GameScore::updateOrCreate(
            ['user_id' => $user->id],
            [
                'moves' => $moves,
                'time' => $timeTaken
            ]
        );

        $stats = PlayerStat::firstOrCreate(['user_id' => $user->id]);

        $this->updatePlayStreak($stats);

        $stats->update([
            'games_played' => $stats->games_played + 1,
            'total_moves' => $stats->total_moves + $moves,
            'best_time' => $this->calculateBestTime($stats->best_time, $timeTaken),
            'worst_time' => $this->calculateWorstTime($stats->worst_time, $timeTaken),
            'perfect_games' => $isPerfectGame ? $stats->perfect_games + 1 : $stats->perfect_games,
            'last_played_at' => Carbon::now()
        ]);

        return response()->json([
            'success' => true,
            'stats' => [
                'games_played' => $stats->games_played,
                'perfect_games' => $stats->perfect_games,
                'best_time' => $stats->best_time,
                'current_streak' => $stats->current_streak
            ]
        ]);
    }

    protected function updatePlayStreak(PlayerStat $stats)
    {
        $lastPlayed = $stats->last_played_at ? Carbon::parse($stats->last_played_at) : null;
        $today = Carbon::today();

        if (!$lastPlayed || $lastPlayed->lt($today->subDay())) {
            
            $stats->current_streak = $lastPlayed && $lastPlayed->eq($today->subDay()) 
                ? $stats->current_streak + 1 
                : 1;
            
            $stats->longest_streak = max($stats->longest_streak, $stats->current_streak);
        }
    }

    protected function calculateBestTime($currentBest, $newTime)
    {
        return $currentBest ? min($currentBest, $newTime) : $newTime;
    }

    protected function calculateWorstTime($currentWorst, $newTime)
    {
        return $currentWorst ? max($currentWorst, $newTime) : $newTime;
    }

    public function getLeaderboard()
    {
        $scores = GameScore::with('user')
            ->orderBy('time')
            ->orderBy('moves')
            ->take(10)
            ->get()
            ->map(function ($score) {
                return [
                    'player' => $score->user->name,
                    'moves' => $score->moves,
                    'time' => $score->time
                ];
            });

        return response()->json($scores);
    }

    public function getUserStats()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $stats = Auth::user()->stats;
        
        return response()->json([
            'games_played' => $stats->games_played ?? 0,
            'perfect_games' => $stats->perfect_games ?? 0,
            'best_time' => $stats->best_time ?? null,
            'current_streak' => $stats->current_streak ?? 0,
            'avg_moves' => $stats->games_played 
                ? round($stats->total_moves / $stats->games_played) 
                : 0
        ]);
    }
}
<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerStat extends Model
{
    protected $fillable = [
        'user_id',
        'games_played',
        'total_moves',
        'best_time',
        'worst_time',
        'perfect_games',
        'current_streak',
        'longest_streak',
        'last_played_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

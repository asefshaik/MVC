<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
Schema::create('player_stats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->unique();
    $table->integer('games_played')->default(0);
    $table->integer('total_moves')->default(0);
    $table->integer('best_time')->nullable();
    $table->integer('worst_time')->nullable();
    $table->integer('perfect_games')->default(0); 
    $table->integer('current_streak')->default(0); 
    $table->integer('longest_streak')->default(0);
    $table->date('last_played_at')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_stats');
    }
};

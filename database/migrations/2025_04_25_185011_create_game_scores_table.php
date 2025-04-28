<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameScoresTable extends Migration
{
    public function up()
    {
        Schema::create('game_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->integer('moves')->default(0);
            $table->integer('time')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('game_scores');
    }
}
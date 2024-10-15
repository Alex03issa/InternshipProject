<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameInfoTable extends Migration
{
    public function up()
    {
        Schema::create('game_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('score')->default(0);
            $table->integer('retry_times')->default(0);
            $table->integer('level')->default(1);
            $table->json('unlocked_skins')->nullable(); // Store unlocked skins as JSON
            $table->json('unlocked_backgrounds')->nullable(); // Store unlocked trophies as JSON
            $table->json('unlocked_trophies')->nullable(); // Store unlocked trophies as JSON
            $table->float('speed')->default(1.0);
            $table->string('background_selected')->default('default_background.png');
            $table->string('ball_skin_selected')->default('default_ball_skin.png');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('game_info');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGameInfoTable extends Migration
{
    public function up()
    {
        Schema::table('game_info', function (Blueprint $table) {
            $table->float('average_session_duration')->default(0); // Average duration
            $table->integer('total_achievements')->default(0); // Total achievements unlocked
            $table->timestamp('last_active')->nullable(); // Last time the user played
        });
    }

    public function down()
    {
        Schema::table('game_info', function (Blueprint $table) {
            $table->dropColumn('average_session_duration');
            $table->dropColumn('total_achievements');
            $table->dropColumn('last_active');
        });
    }
}

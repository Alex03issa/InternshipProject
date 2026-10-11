<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGameInfoTable extends Migration
{
    public function up()
    {
        Schema::table('game_info', function (Blueprint $table) {
            
            // One dropColumn call, in its own blueprint: SQLite (test suite)
            // can't drop two columns separately or mix drops with adds.
            $table->dropColumn(['speed', 'level']);
        });

        Schema::table('game_info', function (Blueprint $table) {
            $table->integer('coin')->default(0);
        });
    }

    public function down()
    {
        Schema::table('game_info', function (Blueprint $table) {
            
            $table->float('speed')->default(1.0);
            $table->integer('level')->default(1);
            
            
            $table->dropColumn('coin');
        });
    }
}

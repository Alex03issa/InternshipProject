<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('game_statistics', function (Blueprint $table) {
            $table->dropColumn('total_achievements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_statistics', function (Blueprint $table) {
            $table->integer('total_achievements')->default(0); 
        });
    }
};

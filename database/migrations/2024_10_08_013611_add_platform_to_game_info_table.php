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
        Schema::table('game_info', function (Blueprint $table) {
            $table->enum('platform', ['play_store', 'app_store', 'website'])->default('website')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_info', function (Blueprint $table) {
            $table->dropColumn('platform');
        });
    }
};

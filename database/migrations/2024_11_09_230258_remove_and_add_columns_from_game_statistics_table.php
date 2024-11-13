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
            $table->dropColumn('platform');
            $table->unsignedBigInteger('total_active_guests')->default(0)->after('monthly_active_guests');
            $table->unsignedBigInteger('total_active_users')->default(0)->after('monthly_active_users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_statistics', function (Blueprint $table) {
            $table->enum('platform', ['play_store', 'app_store', 'website'])->default('website');
            $table->dropColumn('total_active_guests');
            $table->dropColumn('total_active_users');           
        });
    }
};

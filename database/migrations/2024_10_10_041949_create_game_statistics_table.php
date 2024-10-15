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
        Schema::create('game_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('platform', ['play_store', 'app_store', 'website'])->default('website');
            $table->float('average_session_duration')->default(0);
            $table->integer('total_achievements')->default(0); // Total achievements unlocked
            $table->timestamp('last_active')->nullable(); // Last time the user played
            $table->integer('total_users_registered')->default(0);
            $table->integer('daily_users_registered')->default(0);
            $table->integer('monthly_users_registered')->default(0);
            $table->integer('daily_active_users')->default(0);
            $table->integer('monthly_active_users')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_statistics');
    }
};

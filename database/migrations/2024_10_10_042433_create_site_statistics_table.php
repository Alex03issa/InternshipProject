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
        Schema::create('site_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users
            $table->integer('visits')->default(0);
            $table->timestamp('last_visit')->nullable();
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
        Schema::dropIfExists('site_statistics');
    }
};

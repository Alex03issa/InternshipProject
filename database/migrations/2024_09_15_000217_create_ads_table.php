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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['banner', 'interstitial']);
            $table->string('placement'); // homepage, game level, etc.
            $table->enum('platform', ['game', 'website']);
            $table->float('revenue')->nullable(); 
            $table->integer('clicks')->default(0); // New field to track clicks
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};

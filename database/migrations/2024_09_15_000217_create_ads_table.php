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
            $table->string('ad_name');
            $table->string('ad_image')->nullable();
            $table->enum('ad_type', ['game', 'website']);
            $table->string('ad_url')->nullable();
            $table->string('ad_owner');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
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

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
        Schema::table('posts', function (Blueprint $table) {
            // Make title, slug, and body columns nullable
            $table->string('title', 2048)->default('Untitled')->change();
            $table->string('slug', 2048)->default('untitled-slug')->change();
            $table->longText('body')->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Revert back to non-nullable
            $table->string('title', 2048)->nullable(false)->change();
            $table->string('slug', 2048)->nullable(false)->change();
            $table->longText('body')->nullable(false)->change();
        });
    }
};

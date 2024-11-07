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
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            // Add 'id' as an auto-incrementing primary key
            $table->bigIncrements('id')->first();

            // Make 'email' unique
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            // Drop the 'id' column
            $table->dropColumn('id');

            // Drop the unique constraint on 'email'
            $table->dropUnique(['email']);

 
        });
    }
};

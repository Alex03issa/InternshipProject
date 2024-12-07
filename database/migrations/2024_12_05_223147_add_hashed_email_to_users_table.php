<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop all indexes on email column if any exist
            $table->dropUnique(['email']); // Drop unique index
        });

        Schema::table('users', function (Blueprint $table) {
            // Add hashed_email column for secure queries
            $table->string('hashed_email', 255)->unique()->nullable();

            // Change email column to VARCHAR(1024)
            $table->string('email', 1024)->nullable()->change();

            // Change verification_token column to text
            $table->text('verification_token')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop hashed_email column
            $table->dropUnique(['hashed_email']);
            $table->dropColumn('hashed_email');

            // Re-add unique constraint to the email column
            $table->unique('email');

            // Revert email column to VARCHAR(255)
            $table->string('email', 255)->change();

            // Revert verification_token column to string
            $table->string('verification_token', 64)->nullable()->change();
        });
    }
};

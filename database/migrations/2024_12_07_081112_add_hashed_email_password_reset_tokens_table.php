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

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            // Add hashed_email column for secure queries
            $table->string('hashed_email', 255)->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            // Drop hashed_email column
            $table->dropUnique(['hashed_email']);
            $table->dropColumn('hashed_email');
        });
    }
};

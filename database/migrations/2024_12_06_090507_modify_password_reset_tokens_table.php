<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPasswordResetTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            // Remove the unique constraint on the email column if it exists
            $table->dropUnique(['email']);
        });
        
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            
            // Modify the email column to increase its length
            $table->string('email', 2048)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            // Restore the unique constraint on the email column
            $table->unique('email');

            // Restore the email column length to its original size
            $table->string('email', 255)->change();
        });
    }
}

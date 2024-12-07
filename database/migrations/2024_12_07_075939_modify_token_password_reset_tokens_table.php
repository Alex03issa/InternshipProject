<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            
            // Modify the token column to increase its length
            $table->string('token', 2048)->change();
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
            // Restore the token column length to its original size
            $table->string('token', 255)->change();
        });
    }
};

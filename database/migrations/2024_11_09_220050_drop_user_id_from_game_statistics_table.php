<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_statistics', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign('game_statistics_user_id_foreign');
            // Drop the column
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_statistics', function (Blueprint $table) {
            // Add the column back
            $table->unsignedBigInteger('user_id')->nullable();
            // Restore the foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
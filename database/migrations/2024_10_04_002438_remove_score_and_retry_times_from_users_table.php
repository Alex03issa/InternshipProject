<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveScoreAndRetryTimesFromUsersTable extends Migration
{
    /**
     * Run the migration to drop the columns.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['score', 'retry_times']);
        });
    }

    /**
     * Reverse the migration to add the columns back.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('score')->default(0);
            $table->integer('retry_times')->default(0);
        });
    }
}

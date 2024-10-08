<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersRegisteredColumnsToSiteStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_statistics', function (Blueprint $table) {
            $table->integer('daily_users_registered')->default(0);
            $table->integer('monthly_users_registered')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_statistics', function (Blueprint $table) {
            $table->dropColumn('daily_users_registered');
            $table->dropColumn('monthly_users_registered');
        });
    }
}

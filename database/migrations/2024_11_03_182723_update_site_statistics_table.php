<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSiteStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_statistics', function (Blueprint $table) {
            // Remove the old 'visits' column
            $table->dropColumn('visits');

            // Add new columns for tracking total, daily, and monthly visits
            $table->unsignedBigInteger('total_visits')->default(0);
            $table->unsignedBigInteger('daily_visits')->default(0);
            $table->unsignedBigInteger('monthly_visits')->default(0);
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
            // Revert the changes: add the 'visits' column and remove the new columns
            $table->unsignedBigInteger('visits')->default(0);
            $table->dropColumn('total_visits');
            $table->dropColumn('daily_visits');
            $table->dropColumn('monthly_visits');
        });
    }
}

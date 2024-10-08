<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSiteStatisticsTable extends Migration
{
    public function up()
    {
        Schema::table('sitestatistics', function (Blueprint $table) {
            $table->integer('total_users_registered')->default(0);
            $table->integer('daily_active_users')->default(0);
            $table->integer('monthly_active_users')->default(0);
        });
    }

    public function down()
    {
        Schema::table('sitestatistics', function (Blueprint $table) {
            $table->dropColumn('total_users_registered');
            $table->dropColumn('daily_active_users');
            $table->dropColumn('monthly_active_users');
        });
    }
}

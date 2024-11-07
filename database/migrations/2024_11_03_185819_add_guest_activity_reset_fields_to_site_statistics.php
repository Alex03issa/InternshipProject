<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestActivityResetFieldsToSiteStatistics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_statistics', function (Blueprint $table) {
            $table->unsignedBigInteger('daily_active_guests')->default(0)->after('daily_active_users');
            $table->unsignedBigInteger('monthly_active_guests')->default(0)->after('monthly_active_users');
            $table->timestamp('last_reset_at')->nullable()->after('monthly_active_guests');
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
            $table->dropColumn('daily_active_guests');
            $table->dropColumn('monthly_active_guests');
            $table->dropColumn('last_reset_at');
        });
    }
}

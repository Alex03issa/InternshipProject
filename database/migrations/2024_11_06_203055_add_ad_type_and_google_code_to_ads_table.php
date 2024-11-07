<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdTypeAndGoogleCodeToAdsTable extends Migration
{
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->string('ad_type')->default('custom'); 
            $table->text('google_ad_code')->nullable(); 
            $table->boolean('active');
        });
    }

    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['ad_type', 'google_ad_code', 'active']);
        });
    }
}

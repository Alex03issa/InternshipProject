<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAdTypeToAdPlatformInAdsTable extends Migration
{
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->renameColumn('ad_type', 'ad_platform');
        });
    }

    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->renameColumn('ad_platform', 'ad_type');
        });
    }
}

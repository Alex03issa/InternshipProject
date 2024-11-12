<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBackgroundSkinAndTrophyTables extends Migration
{
    public function up()
    {
        Schema::table('backgrounds', function (Blueprint $table) {
            if (!Schema::hasColumn('backgrounds', 'cost')) {
                $table->integer('cost')->default(0)->after('background_image')->comment('Cost in coins');
            }
            if (Schema::hasColumn('backgrounds', 'unlock_points')) {
                $table->dropColumn('unlock_points');
            }
        });

        Schema::table('skins', function (Blueprint $table) {
            if (!Schema::hasColumn('skins', 'cost')) {
                $table->integer('cost')->default(0)->after('skin_image')->comment('Cost in coins');
            }
            if (Schema::hasColumn('skins', 'unlock_points')) {
                $table->dropColumn('unlock_points');
            }
        });

        Schema::table('trophies', function (Blueprint $table) {
            if (Schema::hasColumn('trophies', 'unlock_criteria')) {
                $table->dropColumn('unlock_criteria');
            }
            if (!Schema::hasColumn('trophies', 'icon')) {
                $table->string('icon')->nullable()->after('trophy_description')->comment('Icon image path');
            }
            if (!Schema::hasColumn('trophies', 'unlock_points')) {
                $table->integer('unlock_points')->default(0)->comment('Unlock points');
            }
        });
    }

    public function down()
    {
        Schema::table('backgrounds', function (Blueprint $table) {
            $table->dropColumn('cost');
            $table->integer('unlock_points')->comment('Unlock points');
        });

        Schema::table('skins', function (Blueprint $table) {
            $table->dropColumn('cost');
            $table->integer('unlock_points')->comment('Unlock points');
        });

        Schema::table('trophies', function (Blueprint $table) {
            $table->string('unlock_criteria');
            $table->dropColumn('icon');
            $table->dropColumn('unlock_points');
        });
    }
}

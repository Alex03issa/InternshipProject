<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAdStatisticsTable extends Migration
{
    public function up()
    {
        Schema::table('ad_statistics', function (Blueprint $table) {
            // Remove the 'clicks' and 'views' columns
            $table->dropColumn(['clicks', 'views']);

            // Add a 'type' column to indicate if the entry is a click or view
            $table->enum('type', ['click', 'view'])->after('ad_id');
        });
    }

    public function down()
    {
        Schema::table('ad_statistics', function (Blueprint $table) {
            // Add the 'clicks' and 'views' columns back (if you need to rollback)
            $table->integer('clicks')->default(0)->after('ad_id');
            $table->integer('views')->default(0)->after('clicks');

            // Drop the 'type' column
            $table->dropColumn('type');
        });
    }
}

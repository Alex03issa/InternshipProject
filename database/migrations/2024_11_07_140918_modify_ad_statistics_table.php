<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAdStatisticsTable extends Migration
{
    public function up()
    {
        Schema::table('ad_statistics', function (Blueprint $table) {

            $table->decimal('bill', 10, 5)->default(0.00); // Store bill for each entry
            
            
        });
    }

    public function down()
    {
        Schema::table('ad_statistics', function (Blueprint $table) {
            $table->dropColumn('bill');
            
        });
    }
}

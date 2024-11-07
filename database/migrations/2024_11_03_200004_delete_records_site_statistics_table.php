<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DeleteRecordsSiteStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_statistics', function (Blueprint $table) {
            // Drop foreign key constraint before dropping columns
            $table->dropForeign(['user_id']);

            // Drop user-specific columns
            $table->dropColumn(['user_id', 'last_visit']);
        });

        // Delete all records from site_statistics table
        DB::table('site_statistics')->truncate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_statistics', function (Blueprint $table) {
            // Add the columns back in case of rollback
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('last_visit')->nullable();
        });
    }
}
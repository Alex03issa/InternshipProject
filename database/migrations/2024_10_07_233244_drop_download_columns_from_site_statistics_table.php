<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('site_statistics', function (Blueprint $table) {
           
            $table->dropColumn([
                'play_store_downloads',
                'app_store_downloads',
                'last_play_store_download',
                'last_app_store_download',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_statistics', function (Blueprint $table) {
            // Optionally, you can recreate the columns in case of rollback
            $table->integer('play_store_downloads')->default(0);
            $table->integer('app_store_downloads')->default(0);
            $table->timestamp('last_play_store_download')->nullable();
            $table->timestamp('last_app_store_download')->nullable();
        });
    }
};

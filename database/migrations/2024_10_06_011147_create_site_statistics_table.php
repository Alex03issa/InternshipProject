<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteStatisticsTable extends Migration
{
    public function up()
    {
        Schema::create('sitestatistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users
            $table->integer('visits')->default(0);
            $table->integer('play_store_downloads')->default(0);
            $table->integer('app_store_downloads')->default(0);
            $table->timestamp('last_visit')->nullable();
            $table->timestamp('last_play_store_download')->nullable();
            $table->timestamp('last_app_store_download')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sitestatistics');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('backgrounds', function (Blueprint $table) {
            $table->id();
            $table->string('background_name');
            $table->string('background_image');
            $table->integer('unlock_points');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('backgrounds');
    }

};

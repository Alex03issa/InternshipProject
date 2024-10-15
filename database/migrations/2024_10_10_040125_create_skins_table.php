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
        Schema::create('skins', function (Blueprint $table) {
            $table->id();
            $table->string('skin_name');
            $table->string('skin_image');
            $table->integer('unlock_points');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('skins');
    }
    
};

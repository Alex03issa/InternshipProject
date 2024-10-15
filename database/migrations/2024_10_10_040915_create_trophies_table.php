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
        Schema::create('trophies', function (Blueprint $table) {
            $table->id();
            $table->string('trophy_name');
            $table->text('trophy_description');
            $table->string('unlock_criteria');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trophies');
    }

};

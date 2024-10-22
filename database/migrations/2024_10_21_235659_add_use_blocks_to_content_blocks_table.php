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
        Schema::table('content_blocks', function (Blueprint $table) {
            $table->boolean('use_blocks')->default(false);  // Add the use_blocks field
        });
    }

    public function down()
    {
        Schema::table('content_blocks', function (Blueprint $table) {
            $table->dropColumn('use_blocks');  // Drop the use_blocks field
        });
    }

};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSectionToCategoryPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_post', function (Blueprint $table) {
            $table->string('section')->nullable(); // Add the section column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_post', function (Blueprint $table) {
            $table->dropColumn('section'); // Remove the section column if the migration is rolled back
        });
    }
}

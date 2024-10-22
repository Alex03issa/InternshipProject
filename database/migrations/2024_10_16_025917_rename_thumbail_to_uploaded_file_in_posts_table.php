<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameThumbailToUploadedFileInPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('thumbail', 'uploaded_file'); // Renaming the column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('uploaded_file', 'thumbail'); // Reverting the change if necessary
        });
    }
}

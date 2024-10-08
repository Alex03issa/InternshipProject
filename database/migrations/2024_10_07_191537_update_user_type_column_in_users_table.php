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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_type'); // Drop the existing user_type column
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['user', 'admin'])->default('user'); // Recreate the user_type column with enum
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_type'); // Drop the enum column on rollback
            $table->string('user_type')->default('user'); // Recreate the original string column on rollback
        });
    }
};

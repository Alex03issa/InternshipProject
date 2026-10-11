<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Users created before UserObserver existed have no game_info row, so the
     * game API answered "Game information not found" for them. Create one.
     */
    public function up(): void
    {
        $now = now();

        DB::table('users')
            ->leftJoin('game_info', 'game_info.user_id', '=', 'users.id')
            ->whereNull('game_info.id')
            ->select('users.id')
            ->orderBy('users.id')
            ->chunk(500, function ($users) use ($now) {
                DB::table('game_info')->insert($users->map(fn ($user) => [
                    'user_id' => $user->id,
                    'score' => 0,
                    'retry_times' => 0,
                    'coin' => 0,
                    'unlocked_skins' => '[]',
                    'unlocked_backgrounds' => '[]',
                    'unlocked_trophies' => '[]',
                    'created_at' => $now,
                    'updated_at' => $now,
                ])->all());
            });
    }

    public function down(): void
    {
        // Data backfill only; nothing to undo.
    }
};

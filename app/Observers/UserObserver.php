<?php

namespace App\Observers;

use App\Models\GameInfo;
use App\Models\User;

class UserObserver
{
    /**
     * Every player needs a game_info row: the game API (score, coins,
     * purchases, item selection) and the player panel widgets read from it.
     */
    public function created(User $user): void
    {
        GameInfo::firstOrCreate(
            ['user_id' => $user->id],
            [
                'score' => 0,
                'retry_times' => 0,
                'coin' => 0,
                'unlocked_skins' => [],
                'unlocked_backgrounds' => [],
                'unlocked_trophies' => [],
            ]
        );
    }
}

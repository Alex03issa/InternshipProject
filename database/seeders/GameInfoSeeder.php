<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Background;
use App\Models\GameInfo;
use App\Models\Skin;
use App\Models\Trophy;
use App\Models\User;

class GameInfoSeeder extends Seeder
{
    /**
     * Give the first 3 users some demo progress. A game_info row already
     * exists for every user (created by UserObserver), so it is updated.
     * Unlocked items are stored as id arrays, the format the API expects.
     */
    public function run()
    {
        $users = User::limit(3)->get();

        $skinIds = Skin::query()->limit(2)->pluck('id')->all();
        $backgroundIds = Background::query()->limit(1)->pluck('id')->all();
        $trophyIds = Trophy::query()->limit(1)->pluck('id')->all();

        foreach ($users as $user) {
            GameInfo::updateOrCreate(['user_id' => $user->id], [
                'score' => rand(100, 1000),
                'retry_times' => rand(1, 5),
                'coin' => rand(10, 100),
                'unlocked_skins' => $skinIds,
                'unlocked_backgrounds' => $backgroundIds,
                'unlocked_trophies' => $trophyIds,
                'background_selected' => $backgroundIds[0] ?? 'default_background.png',
                'ball_skin_selected' => $skinIds[0] ?? 'default_ball_skin.png',
            ]);
        }
    }
}

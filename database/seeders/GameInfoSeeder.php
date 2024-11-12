<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GameInfo;
use App\Models\User;

class GameInfoSeeder extends Seeder
{
    public function run()
    {
        $users = User::limit(3)->get(); // Get 3 users for seeding

        foreach ($users as $user) {
            GameInfo::create([
                'user_id' => $user->id,
                'score' => rand(100, 1000),
                'retry_times' => rand(1, 5),
                'coin' => rand(10, 100),
                'unlocked_skins' => json_encode(['skin1', 'skin2']),
                'unlocked_backgrounds' => json_encode(['background1']),
                'unlocked_trophies' => json_encode(['trophy1']),
                'background_selected' => 'images/testimonial-2.jpg',
                'ball_skin_selected' => 'images/testimonial-2.jpg',
            ]);
        }
    }
}

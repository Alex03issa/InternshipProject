<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'email' => 'user1@example.com',
                'password' => Hash::make('password123'),
                'score' => 10,
                'retry_times' => 2,
                'profile_image' => null,
                'username' => 'user1',
                'google_id' => null,
                'apple_id' => null,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user2@example.com',
                'password' => Hash::make('password123'),
                'score' => 20,
                'retry_times' => 1,
                'profile_image' => null,
                'username' => 'user2',
                'google_id' => null,
                'apple_id' => null,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more users as needed
        ]);
    }
}

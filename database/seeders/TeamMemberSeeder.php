<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TeamMember::create([
            'name' => 'Wadee Issa',
            'position' => 'Mobile Developer & Project Management',
            'quote' => 'Side to Side has been a rewarding project. The smooth gameplay and endless fun keep our users engaged.',
            'image_url' => 'images/article-details-large.jpg',
        ]);

        TeamMember::create([
            'name' => 'Alexander Issa',
            'position' => 'Mobile Developer & Web Developer',
            'quote' => 'Creating a seamless and responsive interface was key to making Side to Side a hit among players.',
            'image_url' => 'images/Alexander-issa.jpeg',
        ]);

        TeamMember::create([
            'name' => 'Nassim Cheric',
            'position' => 'Quality Assurance',
            'quote' => 'Ensuring a bug-free experience for our users has been my top priority. Side to Side delivers quality at every level.',
            'image_url' => 'images/pricing-background.jpg',
        ]);
    }
}

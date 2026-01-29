<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            
            // CATEGORY BADGES

            [
                'name' => 'Language Explorer',
                'description' => 'You are making real progress in language learning.',
                'requirement_text' => 'You completed 10 language achievements',
                'icon' => 'badge-language.png',
            ],
            [
                'name' => 'Music Enthusiast',
                'description' => 'Music is becoming part of your daily life.',
                'requirement_text' => 'You completed 10 music achievements',
                'icon' => 'badge-music.png',
            ],
            [
                'name' => 'Photography Eye',
                'description' => 'You see the world through a creative lens.',
                'requirement_text' => 'You completed 10 photography achievements',
                'icon' => 'badge-photography.png',
            ],
            [
                'name' => 'Confident Driver',
                'description' => 'You gained real driving experience.',
                'requirement_text' => 'You completed 10 driving achievements',
                'icon' => 'badge-driving.png',
            ],
            [
                'name' => 'Fitness Warrior',
                'description' => 'Your body and stamina are improving.',
                'requirement_text' => 'You completed 10 fitness achievements',
                'icon' => 'badge-fitness.png',
            ],
            [
                'name' => 'Home Chef',
                'description' => 'You are mastering the art of cooking.',
                'requirement_text' => 'You completed 10 cooking achievements',
                'icon' => 'badge-cooking.png',
            ],
            [
                'name' => 'Bookworm',
                'description' => 'Reading is now part of your routine.',
                'requirement_text' => 'You completed 10 reading achievements',
                'icon' => 'badge-reading.png',
            ],
            [
                'name' => 'Traveler Spirit',
                'description' => 'You explored new places and cultures.',
                'requirement_text' => 'You completed 10 travel achievements',
                'icon' => 'badge-travel.png',
            ],
            [
                'name' => 'Productivity Pro',
                'description' => 'You know how to focus and get things done.',
                'requirement_text' => 'You completed 10 productivity achievements',
                'icon' => 'badge-productivity.png',
            ],
            [
                'name' => 'Finance Minded',
                'description' => 'You are building healthy financial habits.',
                'requirement_text' => 'You completed 10 finance achievements',
                'icon' => 'badge-finance.png',
            ],
            [
                'name' => 'Gamer Dedication',
                'description' => 'You pushed your gaming skills forward.',
                'requirement_text' => 'You completed 10 gaming achievements',
                'icon' => 'badge-gaming.png',
            ],
            [
                'name' => 'Self Improvement Path',
                'description' => 'You are actively working on yourself.',
                'requirement_text' => 'You completed 10 self-improvement achievements',
                'icon' => 'badge-self-improvement.png',
            ],


            // GENERAL FEATURE BADGES

            [
                'name' => 'First Step',
                'description' => 'Everyone starts somewhere.',
                'requirement_text' => 'You completed your first achievement',
                'icon' => 'badge-first-achievement.png',
            ],

            [
                'name' => 'Dark Side',
                'description' => 'You discovered the dark theme.',
                'requirement_text' => 'You switched to dark theme mode',
                'icon' => 'badge-dark-theme.png',
            ],

            [
                'name' => 'Profile Checked',
                'description' => 'You took a look at your profile.',
                'requirement_text' => 'You visited your profile page',
                'icon' => 'badge-profile.png',
            ],
        
            [
                'name' => 'Social Starter',
                'description' => 'You made your first connection.',
                'requirement_text' => 'You added your first friend',
                'icon' => 'badge-friend.png',
            ],
        ];

        foreach ($badges as $bad) {
            Badge::create($bad);
        }
    }
}

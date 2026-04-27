<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            
            [
                'name' => 'Language Learning Master',
                'description' => 'You are making real progress in language learning.',
                'requirement_text' => 'You completed 10 language achievements',
                'icon' => 'https://cdn.imgchest.com/files/b8bd4f607a54.png',
            ],
            [
                'name' => 'Music Master',
                'description' => 'Music is becoming part of your daily life.',
                'requirement_text' => 'You completed 10 music achievements',
                'icon' => 'https://cdn.imgchest.com/files/795287d22f6c.png',
            ],
            [
                'name' => 'Photography Master',
                'description' => 'You see the world through a creative lens.',
                'requirement_text' => 'You completed 10 photography achievements',
                'icon' => 'https://cdn.imgchest.com/files/a9f8eec60499.png',
            ],
            [
                'name' => 'Driving Master',
                'description' => 'You gained real driving experience.',
                'requirement_text' => 'You completed 10 driving achievements',
                'icon' => 'https://cdn.imgchest.com/files/2e761018e180.png',
            ],
            [
                'name' => 'Fitness Master',
                'description' => 'Your body and stamina are improving.',
                'requirement_text' => 'You completed 10 fitness achievements',
                'icon' => 'https://cdn.imgchest.com/files/a7eb908f19da.png',
            ],
            [
                'name' => 'Cooking Master',
                'description' => 'You are mastering the art of cooking.',
                'requirement_text' => 'You completed 10 cooking achievements',
                'icon' => 'https://cdn.imgchest.com/files/88d3f43fe4ca.png',
            ],
            [
                'name' => 'Reading Master',
                'description' => 'Reading is now part of your routine.',
                'requirement_text' => 'You completed 10 reading achievements',
                'icon' => 'https://cdn.imgchest.com/files/6ed0ea70d48f.png',
            ],
            [
                'name' => 'Travel Master',
                'description' => 'You explored new places and cultures.',
                'requirement_text' => 'You completed 10 travel achievements',
                'icon' => 'https://cdn.imgchest.com/files/fb5b0f6bce24.png',
            ],
            [
                'name' => 'Productivity Master',
                'description' => 'You know how to focus and get things done.',
                'requirement_text' => 'You completed 10 productivity achievements',
                'icon' => 'https://cdn.imgchest.com/files/3e95667ca3c2.png',
            ],
            [
                'name' => 'Finance Master',
                'description' => 'You are building healthy financial habits.',
                'requirement_text' => 'You completed 10 finance achievements',
                'icon' => 'https://cdn.imgchest.com/files/6eeea4a1b6b0.png',
            ],
            [
                'name' => 'Gaming Master',
                'description' => 'You pushed your gaming skills forward.',
                'requirement_text' => 'You completed 10 gaming achievements',
                'icon' => 'https://cdn.imgchest.com/files/ca49d7705ce1.png',
            ],
            [
                'name' => 'Self-Improvement Master',
                'description' => 'You are actively working on yourself.',
                'requirement_text' => 'You completed 10 self-improvement achievements',
                'icon' => 'https://cdn.imgchest.com/files/7818cd2de6d7.png',
            ],



            [
                'name' => 'First Step',
                'description' => 'Everyone starts somewhere.',
                'requirement_text' => 'You completed your first achievement',
                'icon' => 'https://cdn.imgchest.com/files/2664bddb0e88.png',
            ],

            [
                'name' => 'Dark Side',
                'description' => 'You discovered the dark theme.',
                'requirement_text' => 'You switched to dark theme mode',
                'icon' => 'https://cdn.imgchest.com/files/303133431fa7.png',
            ],

            [
                'name' => 'Profile Checked',
                'description' => 'You took a look at your profile.',
                'requirement_text' => 'You visited your profile page',
                'icon' => 'https://cdn.imgchest.com/files/0d08d570c8a2.png',
            ],
        
            [
                'name' => 'Social Starter',
                'description' => 'You made your first connection.',
                'requirement_text' => 'You added your first friend',
                'icon' => 'https://cdn.imgchest.com/files/5a2dd215898e.png',
            ],

            [
                'name' => 'Goal Setter',
                'description' => 'You saved your first achievement as a goal.',
                'requirement_text' => 'Save your first goal',
                'icon' => 'https://cdn.imgchest.com/files/f13999078b63.png',
            ],
        ];

        foreach ($badges as $bad) {
            Badge::create($bad);
        }
    }
}

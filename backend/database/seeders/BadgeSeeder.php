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
                'icon' => 'https://cdn.imgchest.com/files/c2c13de65ddc.png',
            ],
            [
                'name' => 'Music Master',
                'description' => 'Music is becoming part of your daily life.',
                'requirement_text' => 'You completed 10 music achievements',
                'icon' => 'https://cdn.imgchest.com/files/887771ed0416.png',
            ],
            [
                'name' => 'Photography Master',
                'description' => 'You see the world through a creative lens.',
                'requirement_text' => 'You completed 10 photography achievements',
                'icon' => 'https://cdn.imgchest.com/files/e3c05510360e.png',
            ],
            [
                'name' => 'Driving Master',
                'description' => 'You gained real driving experience.',
                'requirement_text' => 'You completed 10 driving achievements',
                'icon' => 'https://cdn.imgchest.com/files/86bd8951fc07.png',
            ],
            [
                'name' => 'Fitness Master',
                'description' => 'Your body and stamina are improving.',
                'requirement_text' => 'You completed 10 fitness achievements',
                'icon' => 'https://cdn.imgchest.com/files/8f8b463f7f47.png',
            ],
            [
                'name' => 'Cooking Master',
                'description' => 'You are mastering the art of cooking.',
                'requirement_text' => 'You completed 10 cooking achievements',
                'icon' => 'https://cdn.imgchest.com/files/900a255e5427.png',
            ],
            [
                'name' => 'Reading Master',
                'description' => 'Reading is now part of your routine.',
                'requirement_text' => 'You completed 10 reading achievements',
                'icon' => 'https://cdn.imgchest.com/files/fdca1ea88ed2.png',
            ],
            [
                'name' => 'Travel Master',
                'description' => 'You explored new places and cultures.',
                'requirement_text' => 'You completed 10 travel achievements',
                'icon' => 'https://cdn.imgchest.com/files/34410e48abe3.png',
            ],
            [
                'name' => 'Productivity Master',
                'description' => 'You know how to focus and get things done.',
                'requirement_text' => 'You completed 10 productivity achievements',
                'icon' => 'https://cdn.imgchest.com/files/694baa243f39.png',
            ],
            [
                'name' => 'Finance Master',
                'description' => 'You are building healthy financial habits.',
                'requirement_text' => 'You completed 10 finance achievements',
                'icon' => 'https://cdn.imgchest.com/files/1aa502631b0a.png',
            ],
            [
                'name' => 'Gaming Master',
                'description' => 'You pushed your gaming skills forward.',
                'requirement_text' => 'You completed 10 gaming achievements',
                'icon' => 'https://cdn.imgchest.com/files/a3fc242c23a1.png',
            ],
            [
                'name' => 'Self-Improvement Master',
                'description' => 'You are actively working on yourself.',
                'requirement_text' => 'You completed 10 self-improvement achievements',
                'icon' => 'https://cdn.imgchest.com/files/6da242d36cd1.png',
            ],



            [
                'name' => 'First Step',
                'description' => 'Everyone starts somewhere.',
                'requirement_text' => 'You completed your first achievement',
                'icon' => 'https://cdn.imgchest.com/files/f6420e3d8348.png',
            ],

            [
                'name' => 'Dark Side',
                'description' => 'You discovered the dark theme.',
                'requirement_text' => 'You switched to dark theme mode',
                'icon' => 'https://cdn.imgchest.com/files/4f80d614768c.png',
            ],

            [
                'name' => 'Profile Checked',
                'description' => 'You took a look at your profile.',
                'requirement_text' => 'You visited your profile page',
                'icon' => 'https://cdn.imgchest.com/files/b50e42fe26ec.png',
            ],
        
            [
                'name' => 'Social Starter',
                'description' => 'You made your first connection.',
                'requirement_text' => 'You added your first friend',
                'icon' => 'https://cdn.imgchest.com/files/36b7072dcf23.png',
            ],

            [
                'name' => 'Goal Setter',
                'description' => 'You saved your first achievement as a goal.',
                'requirement_text' => 'Save your first goal',
                'icon' => 'https://cdn.imgchest.com/files/73cc517e883f.png',
            ],
        ];

        foreach ($badges as $bad) {
            Badge::create($bad);
        }
    }
}

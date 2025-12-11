<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Language Learning', 'description' => 'Learn new languages.'],
            ['name' => 'Music', 'description' => 'Practice and play music.'],
            ['name' => 'Photography', 'description' => 'Take and edit photos.'],
            ['name' => 'Driving', 'description' => 'Driving skill development.'],
            ['name' => 'Fitness', 'description' => 'Work out and stay healthy.'],
            ['name' => 'Cooking', 'description' => 'Cooking and food mastery.'],
            ['name' => 'Reading', 'description' => 'Books, reading, and studying.'],
            ['name' => 'Travel', 'description' => 'Travel to new places.'],
            ['name' => 'Productivity', 'description' => 'Be more productive.'],
            ['name' => 'Finance', 'description' => 'Money management.'],
            ['name' => 'Gaming', 'description' => 'Play games and improve skills.'],
            ['name' => 'Self-Improvement', 'description' => 'Mental and personal growth.'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}

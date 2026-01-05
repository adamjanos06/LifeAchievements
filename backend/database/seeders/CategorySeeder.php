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
            ['name' => 'Language Learning', 'description' => 'Learn new languages.','icon' => 'https://cdn.imgchest.com/files/3aee140fc95a.png'],
            ['name' => 'Music', 'description' => 'Practice and play music.', 'icon' => 'https://cdn.imgchest.com/files/e3f53c1d8625.png'],
            ['name' => 'Photography', 'description' => 'Take and edit photos.', 'icon' => 'https://cdn.imgchest.com/files/8a11a85bc13a.png'],
            ['name' => 'Driving', 'description' => 'Driving skill development.', 'icon' => 'https://cdn.imgchest.com/files/d0bbb2426e94.png'],
            ['name' => 'Fitness', 'description' => 'Work out and stay healthy.', 'icon' => 'https://cdn.imgchest.com/files/f98213f87f1b.png'],
            ['name' => 'Cooking', 'description' => 'Cooking and food mastery.', 'icon' => 'https://cdn.imgchest.com/files/7906da39e276.png'],
            ['name' => 'Reading', 'description' => 'Books, reading, and studying.', 'icon' => 'https://cdn.imgchest.com/files/5bcbdf7b017d.png'],
            ['name' => 'Travel', 'description' => 'Travel to new places.', 'icon' => 'https://cdn.imgchest.com/files/02e256e07b03.png'],
            ['name' => 'Productivity', 'description' => 'Be more productive.', 'icon' => 'https://cdn.imgchest.com/files/58afadce8325.png'],
            ['name' => 'Finance', 'description' => 'Money management.', 'icon' => 'https://cdn.imgchest.com/files/573659e57696.png'],
            ['name' => 'Gaming', 'description' => 'Play games and improve skills.', 'icon' => 'https://cdn.imgchest.com/files/931506479b27.png'],
            ['name' => 'Self-Improvement', 'description' => 'Mental and personal growth.', 'icon' => 'https://cdn.imgchest.com/files/340c9e0229aa.png'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}

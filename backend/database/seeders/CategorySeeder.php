<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Language Learning', 'description' => 'Learn new languages.','icon' => 'https://cdn.imgchest.com/files/3aee140fc95a.png','color'=>'A40909'],
            ['name' => 'Music', 'description' => 'Practice and play music.', 'icon' => 'https://cdn.imgchest.com/files/e3f53c1d8625.png','color'=>'09A49C'],
            ['name' => 'Photography', 'description' => 'Take and edit photos.', 'icon' => 'https://cdn.imgchest.com/files/8a11a85bc13a.png','color'=>'568135'],
            ['name' => 'Driving', 'description' => 'Driving skill development.', 'icon' => 'https://cdn.imgchest.com/files/d0bbb2426e94.png','color'=>'D49114'],
            ['name' => 'Fitness', 'description' => 'Work out and stay healthy.', 'icon' => 'https://cdn.imgchest.com/files/f98213f87f1b.png','color'=>'250522'],
            ['name' => 'Cooking', 'description' => 'Cooking and food mastery.', 'icon' => 'https://cdn.imgchest.com/files/7906da39e276.png','color'=>'DB0BC0'],
            ['name' => 'Reading', 'description' => 'Books, reading, and studying.', 'icon' => 'https://cdn.imgchest.com/files/5bcbdf7b017d.png','color'=>'2B2EB8'],
            ['name' => 'Travel', 'description' => 'Travel to new places.', 'icon' => 'https://cdn.imgchest.com/files/02e256e07b03.png','color'=>'0D0D0D'],
            ['name' => 'Productivity', 'description' => 'Be more productive.', 'icon' => 'https://cdn.imgchest.com/files/58afadce8325.png','color'=>'054205'],
            ['name' => 'Finance', 'description' => 'Money management.', 'icon' => 'https://cdn.imgchest.com/files/573659e57696.png','color'=>'56060A'],
            ['name' => 'Gaming', 'description' => 'Play games and improve skills.', 'icon' => 'https://cdn.imgchest.com/files/931506479b27.png','color'=>'797979'],
            ['name' => 'Self-Improvement', 'description' => 'Mental and personal growth.', 'icon' => 'https://cdn.imgchest.com/files/340c9e0229aa.png','color'=>'77D2D2'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}

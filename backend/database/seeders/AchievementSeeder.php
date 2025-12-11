<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [

            // Category 1 – Language
            ['category_id'=>1,'name'=>'First 10 Words','description'=>'Learn your first 10 foreign words.','xp'=>10,'difficulty'=>'easy'],
            ['category_id'=>1,'name'=>'Basic Conversation','description'=>'Hold a basic conversation.','xp'=>25,'difficulty'=>'medium'],
            ['category_id'=>1,'name'=>'Fluent Speaker','description'=>'Speak fluently for 10 minutes.','xp'=>50,'difficulty'=>'hard'],

            // Category 2 – Music
            ['category_id'=>2,'name'=>'First Song','description'=>'Play your first simple song.','xp'=>10,'difficulty'=>'easy'],
            ['category_id'=>2,'name'=>'Rhythm Master','description'=>'Play on tempo for 5 minutes.','xp'=>25,'difficulty'=>'medium'],
            ['category_id'=>2,'name'=>'Live Performer','description'=>'Perform in front of people.','xp'=>50,'difficulty'=>'hard'],

            // Category 3 – Photography
            ['category_id'=>3,'name'=>'First Photo','description'=>'Take your first intentional photo.','xp'=>10,'difficulty'=>'easy'],
            ['category_id'=>3,'name'=>'Manual Mode','description'=>'Shoot in full manual mode.','xp'=>25,'difficulty'=>'medium'],
            ['category_id'=>3,'name'=>'Photo Session','description'=>'Do a full photo session.','xp'=>50,'difficulty'=>'hard'],

            // Category 4 – Driving
            ['category_id'=>4,'name'=>'First Drive','description'=>'Drive alone for the first time.','xp'=>10,'difficulty'=>'easy'],
            ['category_id'=>4,'name'=>'Long Distance','description'=>'Drive 100+ km in one day.','xp'=>25,'difficulty'=>'medium'],
            ['category_id'=>4,'name'=>'Night Driver','description'=>'Drive alone at night.','xp'=>50,'difficulty'=>'hard'],

            // Category 5 – Fitness
            ['category_id'=>5,'name'=>'First Workout','description'=>'Complete your first workout.','xp'=>10,'difficulty'=>'easy'],
            ['category_id'=>5,'name'=>'Cardio King','description'=>'30 minutes nonstop cardio.','xp'=>25,'difficulty'=>'medium'],
            ['category_id'=>5,'name'=>'Athlete Mode','description'=>'Train 5 days in a row.','xp'=>50,'difficulty'=>'hard'],

            // Category 6 – Cooking
            ['category_id'=>6,'name'=>'Perfect Pasta','description'=>'Cook pasta perfectly.','xp'=>10,'difficulty'=>'easy'],
            ['category_id'=>6,'name'=>'Full Dinner','description'=>'Cook a full meal.','xp'=>25,'difficulty'=>'medium'],
            ['category_id'=>6,'name'=>'Chef Challenge','description'=>'Cook a 3-course meal.','xp'=>50,'difficulty'=>'hard'],

            // Category 7 – Reading
            ['category_id'=>7,'name'=>'First Book','description'=>'Finish your first book.','xp'=>10,'difficulty'=>'easy'],
            ['category_id'=>7,'name'=>'Reading Streak','description'=>'Read 7 days in a row.','xp'=>25,'difficulty'=>'medium'],
            ['category_id'=>7,'name'=>'Bookworm','description'=>'Read 10 books.','xp'=>50,'difficulty'=>'hard'],

            // Category 8 – Travel
            ['category_id'=>8,'name'=>'First Trip','description'=>'Visit a new city.','xp'=>10,'difficulty'=>'easy'],
            ['category_id'=>8,'name'=>'Weekend Abroad','description'=>'Travel abroad for a weekend.','xp'=>25,'difficulty'=>'medium'],
            ['category_id'=>8,'name'=>'World Explorer','description'=>'Visit 5 countries.','xp'=>50,'difficulty'=>'hard'],

            // Category 9 – Productivity
            ['category_id'=>9,'name'=>'Todo Master','description'=>'Finish your daily task list.','xp'=>10,'difficulty'=>'easy'],
            ['category_id'=>9,'name'=>'Deep Focus','description'=>'Work 2 hours without distraction.','xp'=>25,'difficulty'=>'medium'],
            ['category_id'=>9,'name'=>'Productivity Beast','description'=>'100% productive week.','xp'=>50,'difficulty'=>'hard'],

            // Category 10 – Finance
            ['category_id'=>10,'name'=>'No Spend Day','description'=>'Spend no money for one day.','xp'=>10,'difficulty'=>'easy'],
            ['category_id'=>10,'name'=>'Savings Goal','description'=>'Reach your first savings goal.','xp'=>25,'difficulty'=>'medium'],
            ['category_id'=>10,'name'=>'Investment Start','description'=>'Make your first investment.','xp'=>50,'difficulty'=>'hard'],

            // Category 11 – Gaming
            ['category_id'=>11,'name'=>'First Win','description'=>'Win your first match.','xp'=>10,'difficulty'=>'easy'],
            ['category_id'=>11,'name'=>'Ranked Victory','description'=>'Win a ranked game.','xp'=>25,'difficulty'=>'medium'],
            ['category_id'=>11,'name'=>'All-Nighter','description'=>'Play through the whole night.','xp'=>50,'difficulty'=>'hard'],

            // Category 12 – Self Improvement
            ['category_id'=>12,'name'=>'Positive Day','description'=>'Stay positive all day.','xp'=>10,'difficulty'=>'easy'],
            ['category_id'=>12,'name'=>'Comfort Zone Breaker','description'=>'Do something uncomfortable.','xp'=>25,'difficulty'=>'medium'],
            ['category_id'=>12,'name'=>'Mental Warrior','description'=>'Overcome a major fear.','xp'=>50,'difficulty'=>'hard'],
        ];

        foreach ($achievements as $a) {
            Achievement::create($a);
        }
    }
}

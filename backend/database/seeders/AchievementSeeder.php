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
            ['category_id'=>1,'name'=>'First 10 Words','description'=>'Learn your first 10 foreign words.','xp'=>10,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>1,'name'=>'Basic Conversation','description'=>'Hold a basic conversation.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>1,'name'=>'Fluent Speaker','description'=>'Speak 2 languages fluently.','xp'=>50,'difficulty'=>'hard','repeatable'=>false],
            ['category_id'=>1,'name'=>'Daily Practice','description'=>'Practice a foreign language for 7 consecutive days.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>1,'name'=>'Alphabet Master','description'=>'Learn a new alphabet.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>1,'name'=>'Listening Ear','description'=>'Understand a short native conversation.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>1,'name'=>'Grammar Basics','description'=>'Learn basic grammar rules.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>1,'name'=>'Sentence Builder','description'=>'Write 10 correct sentences.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>1,'name'=>'Accent Practice','description'=>'Practice pronunciation for 30 minutes.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>1,'name'=>'Language App Streak','description'=>'Maintain a 14-day app streak.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>1,'name'=>'Foreign Movie','description'=>'Watch a movie without subtitles.','xp'=>40,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>1,'name'=>'Thinking Mode','description'=>'Think for a full day in another language.','xp'=>45,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>1,'name'=>'Translator','description'=>'Translate a full page of text.','xp'=>30,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>1,'name'=>'Polyglot Path','description'=>'Start learning a third language.','xp'=>35,'difficulty'=>'hard','repeatable'=>false],


            // Category 2 – Music
            ['category_id'=>2,'name'=>'First Song','description'=>'Play your first simple song.','xp'=>10,'difficulty'=>'easy','repeatable'=>false],
            ['category_id'=>2,'name'=>'Rhythm Master','description'=>'Play on tempo for 5 minutes.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>2,'name'=>'Live Performer','description'=>'Perform in front of people.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>2,'name'=>'Chord Progression','description'=>'Learn and play 5 different chords.','xp'=>20,'difficulty'=>'medium','repeatable'=>false],
            ['category_id'=>2,'name'=>'Daily Practice','description'=>'Practice an instrument for 7 days.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>2,'name'=>'Metronome Friend','description'=>'Practice with a metronome for 20 minutes.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>2,'name'=>'Scale Runner','description'=>'Play a full scale cleanly.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>2,'name'=>'Sight Reader','description'=>'Play a piece without prior practice.','xp'=>30,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>2,'name'=>'Jam Session','description'=>'Play music with other people.','xp'=>35,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>2,'name'=>'Recording Artist','description'=>'Record your first music.','xp'=>30,'difficulty'=>'medium','repeatable'=>false],
            ['category_id'=>2,'name'=>'Improviser','description'=>'Improvise for 5 minutes.','xp'=>40,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>2,'name'=>'Music Theory','description'=>'Learn basic music theory.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>2,'name'=>'Composer','description'=>'Compose a short original piece.','xp'=>45,'difficulty'=>'hard','repeatable'=>false],
            ['category_id'=>2,'name'=>'Stage Confidence','description'=>'Perform without sheet music.','xp'=>50,'difficulty'=>'hard','repeatable'=>false],


            // Category 3 – Photography
            ['category_id'=>3,'name'=>'First Photo','description'=>'Take your first intentional photo.','xp'=>10,'difficulty'=>'easy','repeatable'=>false],
            ['category_id'=>3,'name'=>'Manual Mode','description'=>'Shoot in full manual mode.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>3,'name'=>'Photo Session','description'=>'Do a full photo session.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>3,'name'=>'Golden Hour','description'=>'Take photos during golden hour.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>3,'name'=>'Rule of Thirds','description'=>'Apply the rule of thirds.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>3,'name'=>'Low Light','description'=>'Shoot in low light conditions.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>3,'name'=>'Portrait Shot','description'=>'Take a portrait photo.','xp'=>20,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>3,'name'=>'Landscape View','description'=>'Capture a landscape photo.','xp'=>20,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>3,'name'=>'Editing Basics','description'=>'Edit a photo manually.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>3,'name'=>'Black & White','description'=>'Create a black and white photo.','xp'=>20,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>3,'name'=>'Storytelling','description'=>'Tell a story with photos.','xp'=>40,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>3,'name'=>'Client Shoot','description'=>'Shoot photos for someone else.','xp'=>45,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>3,'name'=>'Photo Series','description'=>'Create a themed photo series.','xp'=>35,'difficulty'=>'medium','repeatable'=>false],
            ['category_id'=>3,'name'=>'Exhibition Ready','description'=>'Prepare photos for exhibition.','xp'=>50,'difficulty'=>'hard','repeatable'=>false],


            // Category 4 – Driving
            ['category_id'=>4,'name'=>'First Drive','description'=>'Drive alone for the first time.','xp'=>10,'difficulty'=>'easy','repeatable'=>false],
            ['category_id'=>4,'name'=>'Long Distance','description'=>'Drive 100+ km in one day.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>4,'name'=>'Night Driver','description'=>'Drive alone at night.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>4,'name'=>'Parking Pro','description'=>'Parallel park successfully without help.','xp'=>20,'difficulty'=>'medium','repeatable'=>false],
            ['category_id'=>4,'name'=>'Rush Hour','description'=>'Drive during heavy traffic.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>4,'name'=>'Highway Entry','description'=>'Merge safely onto a highway.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>4,'name'=>'Rainy Day','description'=>'Drive safely in heavy rain.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>4,'name'=>'Fuel Saver','description'=>'Complete a trip with optimal fuel usage.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>4,'name'=>'Navigation Master','description'=>'Drive without using GPS.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>4,'name'=>'Hill Start','description'=>'Perform a hill start perfectly.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>4,'name'=>'Defensive Driver','description'=>'Avoid a dangerous situation.','xp'=>30,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>4,'name'=>'Road Trip','description'=>'Drive 500+ km over multiple days.','xp'=>45,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>4,'name'=>'Mountain Roads','description'=>'Drive safely on mountain roads.','xp'=>40,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>4,'name'=>'Driving Confidence','description'=>'Drive confidently in any situation.','xp'=>50,'difficulty'=>'hard','repeatable'=>false],


            // Category 5 – Fitness
            ['category_id'=>5,'name'=>'First Workout','description'=>'Complete your first workout.','xp'=>10,'difficulty'=>'easy','repeatable'=>false],
            ['category_id'=>5,'name'=>'Cardio King','description'=>'30 minutes nonstop cardio.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>5,'name'=>'Athlete Mode','description'=>'Train 5 days in a row.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>5,'name'=>'Consistency','description'=>'Work out 3 times in one week.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>5,'name'=>'Warm Up','description'=>'Always warm up before training.','xp'=>10,'difficulty'=>'easy','repeatable'=>false],
            ['category_id'=>5,'name'=>'Stretch It','description'=>'Stretch after a workout.','xp'=>10,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>5,'name'=>'Strength Day','description'=>'Complete a strength workout.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>5,'name'=>'Endurance','description'=>'Exercise for 45 minutes.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>5,'name'=>'Healthy Habit','description'=>'Train for 2 weeks consistently.','xp'=>30,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>5,'name'=>'Early Bird','description'=>'Work out before 8 AM.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>5,'name'=>'Personal Record','description'=>'Beat your personal best.','xp'=>35,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>5,'name'=>'Balanced Training','description'=>'Mix cardio and strength in one week.','xp'=>30,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>5,'name'=>'No Excuses','description'=>'Train despite low motivation.','xp'=>40,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>5,'name'=>'Lifestyle Change','description'=>'Maintain fitness for 3 months.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],


            // Category 6 – Cooking
            ['category_id'=>6,'name'=>'Perfect Pasta','description'=>'Cook pasta perfectly.','xp'=>10,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>6,'name'=>'Full Dinner','description'=>'Cook a full meal.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>6,'name'=>'Chef Challenge','description'=>'Cook a 3-course meal.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>6,'name'=>'New Recipe','description'=>'Cook a dish you have never made before.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>6,'name'=>'Knife Skills','description'=>'Learn basic knife techniques.','xp'=>15,'difficulty'=>'easy','repeatable'=>false],
            ['category_id'=>6,'name'=>'Healthy Meal','description'=>'Cook a healthy meal.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>6,'name'=>'Spice Master','description'=>'Use spices creatively.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>6,'name'=>'Breakfast Pro','description'=>'Prepare a proper breakfast.','xp'=>10,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>6,'name'=>'Meal Prep','description'=>'Prepare meals for 3 days.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>6,'name'=>'Dessert Time','description'=>'Bake a dessert.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>6,'name'=>'Time Management','description'=>'Cook under 30 minutes.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>6,'name'=>'Guest Dinner','description'=>'Cook for guests.','xp'=>35,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>6,'name'=>'Cultural Dish','description'=>'Cook a traditional foreign dish.','xp'=>40,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>6,'name'=>'Home Chef','description'=>'Cook daily for one week.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],


            // Category 7 – Reading
            ['category_id'=>7,'name'=>'First Book','description'=>'Finish your first book.','xp'=>10,'difficulty'=>'easy','repeatable'=>false],
            ['category_id'=>7,'name'=>'Reading Streak','description'=>'Read 7 days in a row.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>7,'name'=>'Bookworm','description'=>'Read 10 books.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>7,'name'=>'Focused Reader','description'=>'Read 30 minutes without interruption.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>7,'name'=>'Daily Pages','description'=>'Read 10 pages in a day.','xp'=>10,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>7,'name'=>'Genre Explorer','description'=>'Read a new genre.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>7,'name'=>'Morning Reader','description'=>'Read in the morning.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>7,'name'=>'Night Reader','description'=>'Read before sleep.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>7,'name'=>'Non-fiction','description'=>'Read a non-fiction book.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>7,'name'=>'Note Taker','description'=>'Take notes while reading.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>7,'name'=>'Discussion Ready','description'=>'Discuss a book with someone.','xp'=>30,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>7,'name'=>'Library Visit','description'=>'Visit a library or bookstore.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>7,'name'=>'Series Finisher','description'=>'Finish a book series.','xp'=>40,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>7,'name'=>'Reading Habit','description'=>'Read consistently for 3 months.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],


            // Category 8 – Travel
            ['category_id'=>8,'name'=>'First Trip','description'=>'Visit a new city.','xp'=>10,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>8,'name'=>'Weekend Abroad','description'=>'Travel abroad for a weekend.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>8,'name'=>'World Explorer','description'=>'Visit 5 countries.','xp'=>50,'difficulty'=>'hard','repeatable'=>false],
            ['category_id'=>8,'name'=>'Local Explorer','description'=>'Explore a new place in your own city.','xp'=>20,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>8,'name'=>'Day Trip','description'=>'Take a spontaneous day trip.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>8,'name'=>'Travel Planner','description'=>'Plan a trip itinerary.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>8,'name'=>'Public Transport','description'=>'Use public transport abroad.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>8,'name'=>'Local Food','description'=>'Try local cuisine.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>8,'name'=>'Photo Memories','description'=>'Document your trip with photos.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>8,'name'=>'Solo Traveler','description'=>'Travel alone.','xp'=>30,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>8,'name'=>'Nature Escape','description'=>'Visit a natural landmark.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>8,'name'=>'Cultural Experience','description'=>'Attend a cultural event.','xp'=>30,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>8,'name'=>'Backpacker','description'=>'Travel on a tight budget.','xp'=>40,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>8,'name'=>'Global Citizen','description'=>'Visit 10 countries total.','xp'=>50,'difficulty'=>'hard','repeatable'=>false],


            // Category 9 – Productivity
            ['category_id'=>9,'name'=>'Todo Master','description'=>'Finish your daily task list.','xp'=>10,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>9,'name'=>'Deep Focus','description'=>'Work 2 hours without distraction.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>9,'name'=>'Productivity Beast','description'=>'100% productive week.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>9,'name'=>'Morning Win','description'=>'Complete your most important task before noon.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>9,'name'=>'Clean Desk','description'=>'Organize your workspace.','xp'=>10,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>9,'name'=>'Time Blocker','description'=>'Plan your day with time blocks.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>9,'name'=>'Zero Inbox','description'=>'Clear your inbox.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>9,'name'=>'No Multitasking','description'=>'Focus on one task at a time.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>9,'name'=>'Weekly Planning','description'=>'Plan the entire week ahead.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>9,'name'=>'Break Manager','description'=>'Take proper breaks.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>9,'name'=>'Distraction Free','description'=>'Avoid social media for a workday.','xp'=>30,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>9,'name'=>'Deadline Crusher','description'=>'Finish a task before deadline.','xp'=>35,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>9,'name'=>'Flow State','description'=>'Reach deep flow for 3 hours.','xp'=>40,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>9,'name'=>'System Builder','description'=>'Build a personal productivity system.','xp'=>50,'difficulty'=>'hard','repeatable'=>false],

            
            // Category 10 – Finance
            ['category_id'=>10,'name'=>'No Spend Day','description'=>'Spend no money for one day.','xp'=>10,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>10,'name'=>'Savings Goal','description'=>'Reach your first savings goal.','xp'=>25,'difficulty'=>'medium','repeatable'=>false],
            ['category_id'=>10,'name'=>'Investment Start','description'=>'Make your first investment.','xp'=>50,'difficulty'=>'hard','repeatable'=>false],
            ['category_id'=>10,'name'=>'Expense Tracker','description'=>'Track all expenses for one full week.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>10,'name'=>'Budget Plan','description'=>'Create a monthly budget.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>10,'name'=>'Emergency Fund','description'=>'Start an emergency fund.','xp'=>25,'difficulty'=>'medium','repeatable'=>false],
            ['category_id'=>10,'name'=>'Debt Free Day','description'=>'Pay off your debts.','xp'=>30,'difficulty'=>'medium','repeatable'=>false],
            ['category_id'=>10,'name'=>'Smart Shopper','description'=>'Compare prices before buying.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>10,'name'=>'Subscription Audit','description'=>'Cancel unused subscriptions.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>10,'name'=>'Side Income','description'=>'Earn money outside your main job.','xp'=>35,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>10,'name'=>'Passive Income','description'=>'Generate passive income.','xp'=>40,'difficulty'=>'hard','repeatable'=>false],
            ['category_id'=>10,'name'=>'Financial Education','description'=>'Read a finance book.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>10,'name'=>'Net Worth Tracker','description'=>'Calculate your net worth.','xp'=>30,'difficulty'=>'medium','repeatable'=>false],
            ['category_id'=>10,'name'=>'Financial Freedom','description'=>'Achieve long-term financial stability.','xp'=>50,'difficulty'=>'hard','repeatable'=>false],

            
            // Category 11 – Gaming
            ['category_id'=>11,'name'=>'First Win','description'=>'Win your first match.','xp'=>10,'difficulty'=>'easy','repeatable'=>false],
            ['category_id'=>11,'name'=>'Ranked Victory','description'=>'Win your first ranked game.','xp'=>25,'difficulty'=>'medium','repeatable'=>false],
            ['category_id'=>11,'name'=>'All-Nighter','description'=>'Play through the whole night.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>11,'name'=>'Achievement Hunter','description'=>'Unlock 5 in-game achievements.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>11,'name'=>'Daily Quest','description'=>'Complete a daily quest.','xp'=>10,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>11,'name'=>'Team Player','description'=>'Win with a team.','xp'=>20,'difficulty'=>'medium','repeatable'=>false],
            ['category_id'=>11,'name'=>'Solo Victory','description'=>'Win a match solo.','xp'=>25,'difficulty'=>'medium','repeatable'=>false],
            ['category_id'=>11,'name'=>'Strategy Mind','description'=>'Win using strategy over skill.','xp'=>30,'difficulty'=>'medium','repeatable'=>false],
            ['category_id'=>11,'name'=>'Boss Defeated','description'=>'Defeat a major boss.','xp'=>35,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>11,'name'=>'Completionist','description'=>'Complete a game 100%.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>11,'name'=>'Speedrun','description'=>'Finish a game under time limit.','xp'=>45,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>11,'name'=>'Hard Mode','description'=>'Beat a game on hard difficulty.','xp'=>40,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>11,'name'=>'Co-op Fun','description'=>'Play co-op with friends.','xp'=>20,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>11,'name'=>'Legend Player','description'=>'Reach top rank in a game.','xp'=>50,'difficulty'=>'hard','repeatable'=>false],

            
            // Category 12 – Self Improvement
            ['category_id'=>12,'name'=>'Positive Day','description'=>'Stay positive all day.','xp'=>10,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>12,'name'=>'Comfort Zone Breaker','description'=>'Do something uncomfortable.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>12,'name'=>'Mental Warrior','description'=>'Overcome a major fear.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>12,'name'=>'Self Reflection','description'=>'Reflect on your day in writing.','xp'=>20,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>12,'name'=>'Gratitude','description'=>'Write down 3 things you are grateful for.','xp'=>10,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>12,'name'=>'Mindful Minute','description'=>'Practice mindfulness for 5 minutes.','xp'=>15,'difficulty'=>'easy','repeatable'=>true],
            ['category_id'=>12,'name'=>'Goal Setter','description'=>'Set a meaningful personal goal.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>12,'name'=>'Habit Builder','description'=>'Maintain a habit for 7 days.','xp'=>25,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>12,'name'=>'Digital Detox','description'=>'Avoid social media for one day.','xp'=>20,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>12,'name'=>'Confidence Boost','description'=>'Speak up when you normally would not.','xp'=>30,'difficulty'=>'medium','repeatable'=>true],
            ['category_id'=>12,'name'=>'Emotional Control','description'=>'Handle a stressful situation calmly.','xp'=>35,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>12,'name'=>'Self Discipline','description'=>'Do what needs to be done despite resistance.','xp'=>40,'difficulty'=>'hard','repeatable'=>true],
            ['category_id'=>12,'name'=>'Identity Shift','description'=>'Adopt a better self-image.','xp'=>45,'difficulty'=>'hard','repeatable'=>false],
            ['category_id'=>12,'name'=>'Life Upgrade','description'=>'Sustain self-improvement for 6 months.','xp'=>50,'difficulty'=>'hard','repeatable'=>true],
        ];

        foreach ($achievements as $a) {
            Achievement::create($a);
        }
    }
}

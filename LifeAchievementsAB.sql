-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Apr 28, 2026 at 11:43 AM
-- Server version: 9.3.0
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `LifeAchievements`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `xp` int NOT NULL DEFAULT '10',
  `difficulty` enum('easy','medium','hard') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'easy',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `repeatable` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `category_id`, `name`, `description`, `xp`, `difficulty`, `created_at`, `updated_at`, `repeatable`) VALUES
(1, 1, 'First 10 Words', 'Learn your first 10 foreign words.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(2, 1, 'Basic Conversation', 'Hold a basic conversation.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(3, 1, 'Fluent Speaker', 'Speak 2 languages fluently.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(4, 1, 'Daily Practice', 'Practice a foreign language for 7 consecutive days.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(5, 1, 'Alphabet Master', 'Learn a new alphabet.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(6, 1, 'Listening Ear', 'Understand a short native conversation.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(7, 1, 'Grammar Basics', 'Learn basic grammar rules.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(8, 1, 'Sentence Builder', 'Write 10 correct sentences.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(9, 1, 'Accent Practice', 'Practice pronunciation for 30 minutes.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(10, 1, 'Language App Streak', 'Maintain a 14-day app streak.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(11, 1, 'Foreign Movie', 'Watch a movie without subtitles.', 40, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(12, 1, 'Thinking Mode', 'Think for a full day in another language.', 45, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(13, 1, 'Translator', 'Translate a full page of text.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(14, 1, 'Polyglot Path', 'Start learning a third language.', 35, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(15, 2, 'First Song', 'Play your first simple song.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(16, 2, 'Rhythm Master', 'Play on tempo for 5 minutes.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(17, 2, 'Live Performer', 'Perform in front of people.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(18, 2, 'Chord Progression', 'Learn and play 5 different chords.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(19, 2, 'Daily Practice', 'Practice an instrument for 7 days.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(20, 2, 'Metronome Friend', 'Practice with a metronome for 20 minutes.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(21, 2, 'Scale Runner', 'Play a full scale cleanly.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(22, 2, 'Sight Reader', 'Play a piece without prior practice.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(23, 2, 'Jam Session', 'Play music with other people.', 35, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(24, 2, 'Recording Artist', 'Record your first music.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(25, 2, 'Improviser', 'Improvise for 5 minutes.', 40, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(26, 2, 'Music Theory', 'Learn basic music theory.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(27, 2, 'Composer', 'Compose a short original piece.', 45, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(28, 2, 'Stage Confidence', 'Perform without sheet music.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(29, 3, 'First Photo', 'Take your first intentional photo.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(30, 3, 'Manual Mode', 'Shoot in full manual mode.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(31, 3, 'Photo Session', 'Do a full photo session.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(32, 3, 'Golden Hour', 'Take photos during golden hour.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(33, 3, 'Rule of Thirds', 'Apply the rule of thirds.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(34, 3, 'Low Light', 'Shoot in low light conditions.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(35, 3, 'Portrait Shot', 'Take a portrait photo.', 20, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(36, 3, 'Landscape View', 'Capture a landscape photo.', 20, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(37, 3, 'Editing Basics', 'Edit a photo manually.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(38, 3, 'Black & White', 'Create a black and white photo.', 20, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(39, 3, 'Storytelling', 'Tell a story with photos.', 40, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(40, 3, 'Client Shoot', 'Shoot photos for someone else.', 45, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(41, 3, 'Photo Series', 'Create a themed photo series.', 35, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(42, 3, 'Exhibition Ready', 'Prepare photos for exhibition.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(43, 4, 'First Drive', 'Drive alone for the first time.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(44, 4, 'Long Distance', 'Drive 100+ km in one day.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(45, 4, 'Night Driver', 'Drive alone at night.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(46, 4, 'Parking Pro', 'Parallel park successfully without help.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(47, 4, 'Rush Hour', 'Drive during heavy traffic.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(48, 4, 'Highway Entry', 'Merge safely onto a highway.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(49, 4, 'Rainy Day', 'Drive safely in heavy rain.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(50, 4, 'Fuel Saver', 'Complete a trip with optimal fuel usage.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(51, 4, 'Navigation Master', 'Drive without using GPS.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(52, 4, 'Hill Start', 'Perform a hill start perfectly.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(53, 4, 'Defensive Driver', 'Avoid a dangerous situation.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(54, 4, 'Road Trip', 'Drive 500+ km over multiple days.', 45, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(55, 4, 'Mountain Roads', 'Drive safely on mountain roads.', 40, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(56, 4, 'Driving Confidence', 'Drive confidently in any situation.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(57, 5, 'First Workout', 'Complete your first workout.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(58, 5, 'Cardio King', '30 minutes nonstop cardio.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(59, 5, 'Athlete Mode', 'Train 5 days in a row.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(60, 5, 'Consistency', 'Work out 3 times in one week.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(61, 5, 'Warm Up', 'Always warm up before training.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(62, 5, 'Stretch It', 'Stretch after a workout.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(63, 5, 'Strength Day', 'Complete a strength workout.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(64, 5, 'Endurance', 'Exercise for 45 minutes.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(65, 5, 'Healthy Habit', 'Train for 2 weeks consistently.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(66, 5, 'Early Bird', 'Work out before 8 AM.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(67, 5, 'Personal Record', 'Beat your personal best.', 35, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(68, 5, 'Balanced Training', 'Mix cardio and strength in one week.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(69, 5, 'No Excuses', 'Train despite low motivation.', 40, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(70, 5, 'Lifestyle Change', 'Maintain fitness for 3 months.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(71, 6, 'Perfect Pasta', 'Cook pasta perfectly.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(72, 6, 'Full Dinner', 'Cook a full meal.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(73, 6, 'Chef Challenge', 'Cook a 3-course meal.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(74, 6, 'New Recipe', 'Cook a dish you have never made before.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(75, 6, 'Knife Skills', 'Learn basic knife techniques.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(76, 6, 'Healthy Meal', 'Cook a healthy meal.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(77, 6, 'Spice Master', 'Use spices creatively.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(78, 6, 'Breakfast Pro', 'Prepare a proper breakfast.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(79, 6, 'Meal Prep', 'Prepare meals for 3 days.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(80, 6, 'Dessert Time', 'Bake a dessert.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(81, 6, 'Time Management', 'Cook under 30 minutes.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(82, 6, 'Guest Dinner', 'Cook for guests.', 35, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(83, 6, 'Cultural Dish', 'Cook a traditional foreign dish.', 40, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(84, 6, 'Home Chef', 'Cook daily for one week.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(85, 7, 'First Book', 'Finish your first book.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(86, 7, 'Reading Streak', 'Read 7 days in a row.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(87, 7, 'Bookworm', 'Read 10 books.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(88, 7, 'Focused Reader', 'Read 30 minutes without interruption.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(89, 7, 'Daily Pages', 'Read 10 pages in a day.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(90, 7, 'Genre Explorer', 'Read a new genre.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(91, 7, 'Morning Reader', 'Read in the morning.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(92, 7, 'Night Reader', 'Read before sleep.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(93, 7, 'Non-fiction', 'Read a non-fiction book.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(94, 7, 'Note Taker', 'Take notes while reading.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(95, 7, 'Discussion Ready', 'Discuss a book with someone.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(96, 7, 'Library Visit', 'Visit a library or bookstore.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(97, 7, 'Series Finisher', 'Finish a book series.', 40, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(98, 7, 'Reading Habit', 'Read consistently for 3 months.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(99, 8, 'First Trip', 'Visit a new city.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(100, 8, 'Weekend Abroad', 'Travel abroad for a weekend.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(101, 8, 'World Explorer', 'Visit 5 countries.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(102, 8, 'Local Explorer', 'Explore a new place in your own city.', 20, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(103, 8, 'Day Trip', 'Take a spontaneous day trip.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(104, 8, 'Travel Planner', 'Plan a trip itinerary.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(105, 8, 'Public Transport', 'Use public transport abroad.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(106, 8, 'Local Food', 'Try local cuisine.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(107, 8, 'Photo Memories', 'Document your trip with photos.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(108, 8, 'Solo Traveler', 'Travel alone.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(109, 8, 'Nature Escape', 'Visit a natural landmark.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(110, 8, 'Cultural Experience', 'Attend a cultural event.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(111, 8, 'Backpacker', 'Travel on a tight budget.', 40, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(112, 8, 'Global Citizen', 'Visit 10 countries total.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(113, 9, 'Todo Master', 'Finish your daily task list.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(114, 9, 'Deep Focus', 'Work 2 hours without distraction.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(115, 9, 'Productivity Beast', '100% productive week.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(116, 9, 'Morning Win', 'Complete your most important task before noon.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(117, 9, 'Clean Desk', 'Organize your workspace.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(118, 9, 'Time Blocker', 'Plan your day with time blocks.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(119, 9, 'Zero Inbox', 'Clear your inbox.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(120, 9, 'No Multitasking', 'Focus on one task at a time.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(121, 9, 'Weekly Planning', 'Plan the entire week ahead.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(122, 9, 'Break Manager', 'Take proper breaks.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(123, 9, 'Distraction Free', 'Avoid social media for a workday.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(124, 9, 'Deadline Crusher', 'Finish a task before deadline.', 35, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(125, 9, 'Flow State', 'Reach deep flow for 3 hours.', 40, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(126, 9, 'System Builder', 'Build a personal productivity system.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(127, 10, 'No Spend Day', 'Spend no money for one day.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(128, 10, 'Savings Goal', 'Reach your first savings goal.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(129, 10, 'Investment Start', 'Make your first investment.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(130, 10, 'Expense Tracker', 'Track all expenses for one full week.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(131, 10, 'Budget Plan', 'Create a monthly budget.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(132, 10, 'Emergency Fund', 'Start an emergency fund.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(133, 10, 'Debt Free Day', 'Pay off your debts.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(134, 10, 'Smart Shopper', 'Compare prices before buying.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(135, 10, 'Subscription Audit', 'Cancel unused subscriptions.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(136, 10, 'Side Income', 'Earn money outside your main job.', 35, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(137, 10, 'Passive Income', 'Generate passive income.', 40, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(138, 10, 'Financial Education', 'Read a finance book.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(139, 10, 'Net Worth Tracker', 'Calculate your net worth.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(140, 10, 'Financial Freedom', 'Achieve long-term financial stability.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(141, 11, 'First Win', 'Win your first match.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(142, 11, 'Ranked Victory', 'Win your first ranked game.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(143, 11, 'All-Nighter', 'Play through the whole night.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(144, 11, 'Achievement Hunter', 'Unlock 5 in-game achievements.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(145, 11, 'Daily Quest', 'Complete a daily quest.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(146, 11, 'Team Player', 'Win with a team.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(147, 11, 'Solo Victory', 'Win a match solo.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(148, 11, 'Strategy Mind', 'Win using strategy over skill.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(149, 11, 'Boss Defeated', 'Defeat a major boss.', 35, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(150, 11, 'Completionist', 'Complete a game 100%.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(151, 11, 'Speedrun', 'Finish a game under time limit.', 45, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(152, 11, 'Hard Mode', 'Beat a game on hard difficulty.', 40, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(153, 11, 'Co-op Fun', 'Play co-op with friends.', 20, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(154, 11, 'Legend Player', 'Reach top rank in a game.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(155, 12, 'Positive Day', 'Stay positive all day.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(156, 12, 'Comfort Zone Breaker', 'Do something uncomfortable.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(157, 12, 'Mental Warrior', 'Overcome a major fear.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(158, 12, 'Self Reflection', 'Reflect on your day in writing.', 20, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(159, 12, 'Gratitude', 'Write down 3 things you are grateful for.', 10, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(160, 12, 'Mindful Minute', 'Practice mindfulness for 5 minutes.', 15, 'easy', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(161, 12, 'Goal Setter', 'Set a meaningful personal goal.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(162, 12, 'Habit Builder', 'Maintain a habit for 7 days.', 25, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(163, 12, 'Digital Detox', 'Avoid social media for one day.', 20, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(164, 12, 'Confidence Boost', 'Speak up when you normally would not.', 30, 'medium', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(165, 12, 'Emotional Control', 'Handle a stressful situation calmly.', 35, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(166, 12, 'Self Discipline', 'Do what needs to be done despite resistance.', 40, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1),
(167, 12, 'Identity Shift', 'Adopt a better self-image.', 45, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 0),
(168, 12, 'Life Upgrade', 'Sustain self-improvement for 6 months.', 50, 'hard', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `requirement_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`id`, `name`, `description`, `requirement_text`, `created_at`, `updated_at`, `icon`) VALUES
(1, 'Language Learning Master', 'You are making real progress in language learning.', 'You completed 10 language achievements', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/c2c13de65ddc.png'),
(2, 'Music Master', 'Music is becoming part of your daily life.', 'You completed 10 music achievements', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/887771ed0416.png'),
(3, 'Photography Master', 'You see the world through a creative lens.', 'You completed 10 photography achievements', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/e3c05510360e.png'),
(4, 'Driving Master', 'You gained real driving experience.', 'You completed 10 driving achievements', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/86bd8951fc07.png'),
(5, 'Fitness Master', 'Your body and stamina are improving.', 'You completed 10 fitness achievements', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/8f8b463f7f47.png'),
(6, 'Cooking Master', 'You are mastering the art of cooking.', 'You completed 10 cooking achievements', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/900a255e5427.png'),
(7, 'Reading Master', 'Reading is now part of your routine.', 'You completed 10 reading achievements', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/fdca1ea88ed2.png'),
(8, 'Travel Master', 'You explored new places and cultures.', 'You completed 10 travel achievements', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/34410e48abe3.png'),
(9, 'Productivity Master', 'You know how to focus and get things done.', 'You completed 10 productivity achievements', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/694baa243f39.png'),
(10, 'Finance Master', 'You are building healthy financial habits.', 'You completed 10 finance achievements', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/1aa502631b0a.png'),
(11, 'Gaming Master', 'You pushed your gaming skills forward.', 'You completed 10 gaming achievements', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/a3fc242c23a1.png'),
(12, 'Self-Improvement Master', 'You are actively working on yourself.', 'You completed 10 self-improvement achievements', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/6da242d36cd1.png'),
(13, 'First Step', 'Everyone starts somewhere.', 'You completed your first achievement', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/f6420e3d8348.png'),
(14, 'Dark Side', 'You discovered the dark theme.', 'You switched to dark theme mode', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/4f80d614768c.png'),
(15, 'Profile Checked', 'You took a look at your profile.', 'You visited your profile page', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/b50e42fe26ec.png'),
(16, 'Social Starter', 'You made your first connection.', 'You added your first friend', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/36b7072dcf23.png'),
(17, 'Goal Setter', 'You saved your first achievement as a goal.', 'Save your first goal', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'https://cdn.imgchest.com/files/73cc517e883f.png');

-- --------------------------------------------------------

--
-- Table structure for table `badge_user`
--

CREATE TABLE `badge_user` (
  `id` bigint UNSIGNED NOT NULL,
  `badge_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `earned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `badge_user`
--

INSERT INTO `badge_user` (`id`, `badge_id`, `user_id`, `earned_at`, `created_at`, `updated_at`) VALUES
(1, 13, 1, '2026-04-28 05:01:32', '2026-04-28 05:01:32', '2026-04-28 05:01:32'),
(2, 17, 1, '2026-04-28 05:03:28', '2026-04-28 05:03:28', '2026-04-28 05:03:28'),
(3, 15, 1, '2026-04-28 05:04:17', '2026-04-28 05:04:17', '2026-04-28 05:04:17'),
(4, 15, 3, '2026-04-28 05:05:57', '2026-04-28 05:05:57', '2026-04-28 05:05:57'),
(5, 16, 3, '2026-04-28 05:06:01', '2026-04-28 05:06:01', '2026-04-28 05:06:01'),
(6, 15, 4, '2026-04-28 05:06:17', '2026-04-28 05:06:17', '2026-04-28 05:06:17'),
(7, 14, 1, '2026-04-28 05:08:23', '2026-04-28 05:08:23', '2026-04-28 05:08:23');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `icon`, `created_at`, `updated_at`, `color`) VALUES
(1, 'Language Learning', 'Learn new languages.', 'https://cdn.imgchest.com/files/3aee140fc95a.png', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'A40909'),
(2, 'Music', 'Practice and play music.', 'https://cdn.imgchest.com/files/e3f53c1d8625.png', '2026-04-28 04:59:19', '2026-04-28 04:59:19', '09A49C'),
(3, 'Photography', 'Take and edit photos.', 'https://cdn.imgchest.com/files/8a11a85bc13a.png', '2026-04-28 04:59:19', '2026-04-28 04:59:19', '568135'),
(4, 'Driving', 'Driving skill development.', 'https://cdn.imgchest.com/files/d0bbb2426e94.png', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'D49114'),
(5, 'Fitness', 'Work out and stay healthy.', 'https://cdn.imgchest.com/files/f98213f87f1b.png', '2026-04-28 04:59:19', '2026-04-28 04:59:19', '250522'),
(6, 'Cooking', 'Cooking and food mastery.', 'https://cdn.imgchest.com/files/7906da39e276.png', '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'DB0BC0'),
(7, 'Reading', 'Books, reading, and studying.', 'https://cdn.imgchest.com/files/5bcbdf7b017d.png', '2026-04-28 04:59:19', '2026-04-28 04:59:19', '2B2EB8'),
(8, 'Travel', 'Travel to new places.', 'https://cdn.imgchest.com/files/02e256e07b03.png', '2026-04-28 04:59:19', '2026-04-28 04:59:19', '0D0D0D'),
(9, 'Productivity', 'Be more productive.', 'https://cdn.imgchest.com/files/58afadce8325.png', '2026-04-28 04:59:19', '2026-04-28 04:59:19', '054205'),
(10, 'Finance', 'Money management.', 'https://cdn.imgchest.com/files/573659e57696.png', '2026-04-28 04:59:19', '2026-04-28 04:59:19', '56060A'),
(11, 'Gaming', 'Play games and improve skills.', 'https://cdn.imgchest.com/files/931506479b27.png', '2026-04-28 04:59:19', '2026-04-28 04:59:19', '797979'),
(12, 'Self-Improvement', 'Mental and personal growth.', 'https://cdn.imgchest.com/files/340c9e0229aa.png', '2026-04-28 04:59:19', '2026-04-28 04:59:19', '77D2D2');

-- --------------------------------------------------------

--
-- Table structure for table `completed_achievements`
--

CREATE TABLE `completed_achievements` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `achievement_id` bigint UNSIGNED NOT NULL,
  `completion_date` timestamp NULL DEFAULT NULL,
  `completions` int DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `completed_achievements`
--

INSERT INTO `completed_achievements` (`id`, `user_id`, `achievement_id`, `completion_date`, `completions`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-04-28 05:01:32', 1, NULL, '2026-04-28 05:01:32', '2026-04-28 05:01:32'),
(2, 1, 2, '2026-04-28 05:01:42', 1, NULL, '2026-04-28 05:01:42', '2026-04-28 05:01:42'),
(3, 1, 4, '2026-04-28 05:01:45', 1, NULL, '2026-04-28 05:01:45', '2026-04-28 05:01:45'),
(4, 1, 5, '2026-04-28 05:01:49', 1, NULL, '2026-04-28 05:01:49', '2026-04-28 05:01:49'),
(5, 1, 15, '2026-04-28 05:01:54', 1, NULL, '2026-04-28 05:01:54', '2026-04-28 05:01:54'),
(6, 1, 16, '2026-04-28 05:01:58', 6, NULL, '2026-04-28 05:01:57', '2026-04-28 05:01:58'),
(7, 1, 61, '2026-04-28 05:02:24', 1, NULL, '2026-04-28 05:02:24', '2026-04-28 05:02:24'),
(8, 1, 104, '2026-04-28 05:02:30', 1, NULL, '2026-04-28 05:02:30', '2026-04-28 05:02:30'),
(9, 1, 85, '2026-04-28 05:02:35', 1, NULL, '2026-04-28 05:02:35', '2026-04-28 05:02:35'),
(10, 1, 72, '2026-04-28 05:02:42', 1, NULL, '2026-04-28 05:02:42', '2026-04-28 05:02:42'),
(11, 1, 29, '2026-04-28 05:02:49', 1, NULL, '2026-04-28 05:02:49', '2026-04-28 05:02:49'),
(12, 1, 3, '2026-04-28 09:40:46', 1, NULL, '2026-04-28 09:40:46', '2026-04-28 09:40:46'),
(13, 1, 6, '2026-04-28 09:40:51', 1, NULL, '2026-04-28 09:40:51', '2026-04-28 09:40:51'),
(14, 1, 8, '2026-04-28 09:41:07', 1, NULL, '2026-04-28 09:41:07', '2026-04-28 09:41:07');

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `receiver_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','accepted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `sender_id`, `receiver_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'accepted', '2026-04-28 05:06:01', '2026-04-28 05:07:24'),
(2, 1, 4, 'accepted', '2026-04-28 05:06:37', '2026-04-28 05:07:53');

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE `goals` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `achievement_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goals`
--

INSERT INTO `goals` (`id`, `user_id`, `achievement_id`, `created_at`, `updated_at`) VALUES
(1, 1, 43, '2026-04-28 05:03:28', '2026-04-28 05:03:28'),
(2, 1, 113, '2026-04-28 05:03:34', '2026-04-28 05:03:34');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2025_12_03_164756_create_personal_access_tokens_table', 1),
(4, '2025_12_03_164940_create_categories_table', 1),
(5, '2025_12_03_164950_create_achievements_table', 1),
(6, '2025_12_03_165011_create_completed_achievements_table', 1),
(7, '2025_12_03_165022_create_badges_table', 1),
(8, '2025_12_03_165032_create_badge_user_table', 1),
(9, '2026_01_29_064125_create_goals_table', 1),
(10, '2026_02_05_063824_friend_requests', 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(2, 'App\\Models\\User', 3, 'auth_token', '2a7ff8645479880dd030d8de14135797338435a412a426906e94106339ab8886', '[\"*\"]', '2026-04-28 05:06:03', NULL, '2026-04-28 05:05:41', '2026-04-28 05:06:03'),
(5, 'App\\Models\\User', 4, 'auth_token', '4a6dd597ded10101fd0ca26352549eb8fc9b8da76156e21bf61331f1b0a2da94', '[\"*\"]', '2026-04-28 05:07:59', NULL, '2026-04-28 05:07:49', '2026-04-28 05:07:59'),
(7, 'App\\Models\\User', 1, 'auth_token', 'c19383def3c973914031a4e024c1b49d22485ebcc79751ddd49b901815da37df', '[\"*\"]', '2026-04-28 09:41:59', NULL, '2026-04-28 09:40:40', '2026-04-28 09:41:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xp` int NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `xp`, `remember_token`, `created_at`, `updated_at`, `bio`, `image`, `isAdmin`) VALUES
(1, 'Test User', 'test@test.com', NULL, '$2y$12$2EdOSA0K53FbtWeJ.BChNOKChwcvESi77YqvFwCbTYbDIp2Hbvn2O', 395, NULL, '2026-04-28 04:59:19', '2026-04-28 09:41:07', 'I\'m the test user (⌐■_■)', NULL, NULL),
(2, 'Admin User', 'admin@example.com', NULL, '$2y$12$d4gN9f1K4SYg9XnGScdHAOo4lmBt0.N19bLIKNqUMwNlcvOcMeKmu', 0, NULL, '2026-04-28 04:59:19', '2026-04-28 04:59:19', 'System Administrator', NULL, 1),
(3, 'Béla', 'Bela@test.com', NULL, '$2y$12$G3NOAZGCdDRYUTa4JuTHOuSQIdvyy0sbv57Ip5UHrr21W4aheNHIu', 0, NULL, '2026-04-28 05:05:41', '2026-04-28 05:05:41', NULL, NULL, NULL),
(4, 'Sajt', 'sajt@test.com', NULL, '$2y$12$7.nbUSGOWbyDVGdNfKPyG.Md.viARZFWCpAMDfDM4zC9OinaKq6dy', 0, NULL, '2026-04-28 05:06:14', '2026-04-28 05:06:14', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `achievements_category_id_foreign` (`category_id`);

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `badge_user`
--
ALTER TABLE `badge_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `badge_user_user_id_badge_id_unique` (`user_id`,`badge_id`),
  ADD KEY `badge_user_badge_id_foreign` (`badge_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `completed_achievements`
--
ALTER TABLE `completed_achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `completed_achievements_user_id_foreign` (`user_id`),
  ADD KEY `completed_achievements_achievement_id_foreign` (`achievement_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `friend_requests_sender_id_receiver_id_unique` (`sender_id`,`receiver_id`),
  ADD KEY `friend_requests_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goals_user_id_foreign` (`user_id`),
  ADD KEY `goals_achievement_id_foreign` (`achievement_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_name_unique` (`name`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `badges`
--
ALTER TABLE `badges`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `badge_user`
--
ALTER TABLE `badge_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `completed_achievements`
--
ALTER TABLE `completed_achievements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `goals`
--
ALTER TABLE `goals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievements`
--
ALTER TABLE `achievements`
  ADD CONSTRAINT `achievements_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `badge_user`
--
ALTER TABLE `badge_user`
  ADD CONSTRAINT `badge_user_badge_id_foreign` FOREIGN KEY (`badge_id`) REFERENCES `badges` (`id`),
  ADD CONSTRAINT `badge_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `completed_achievements`
--
ALTER TABLE `completed_achievements`
  ADD CONSTRAINT `completed_achievements_achievement_id_foreign` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`),
  ADD CONSTRAINT `completed_achievements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_requests_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goals`
--
ALTER TABLE `goals`
  ADD CONSTRAINT `goals_achievement_id_foreign` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`),
  ADD CONSTRAINT `goals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

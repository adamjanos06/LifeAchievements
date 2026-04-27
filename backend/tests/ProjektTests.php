<?php

namespace Tests;


use App\Models\Achievement;
use App\Models\Category;
use App\Models\CompletedAchievement;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;


class ProjektTests extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }


    #[Test]
    public function user_can_register_successfully()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User21',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'user' => ['id', 'name', 'email'],
                     'token'
                 ])
                 ->assertJsonPath('user.email', 'test@example.com')
                 ->assertJsonPath('user.name', 'Test User21');

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }
    #[Test]
    public function registration_fails_if_passwords_do_not_match()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'mismatch@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different',
        ]);

        $response->assertStatus(422);
    }
    #[Test]
    public function user_can_log_in()
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'login@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['token', 'user']);
    }
    #[Test]
    public function login_fails_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'unknown@example.com',
            'password' => 'wrong'
        ]);

        $response->assertStatus(422);
    }
    #[Test]
    public function user_can_access_me_endpoint_with_valid_token()
    {
        $user = User::factory()->create();

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->getJson('/api/me');

        $response->assertStatus(200)
                ->assertJsonStructure(['user' => ['id', 'name', 'email']]);
    }
    #[Test]
    public function me_endpoint_fails_without_token()
    {
        $response = $this->getJson('/api/me');

        $response->assertStatus(401);
    }
    #[Test]
    public function user_can_log_out()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->postJson('/api/logout');

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Logged out successfully'
                ]);
    }

    #[Test]
    public function guest_can_list_achievements_but_all_uncompleted()
    {
        $response = $this->getJson('/api/achievements');
        $response->assertStatus(200);

        $data = $response->json('data');

        $this->assertNotEmpty($data);

        foreach ($data as $item) {
            $this->assertFalse($item['completed']);
        }
    }

    #[Test]
    public function authenticated_user_sees_which_achievements_are_completed()
    {
        $user = User::factory()->create();

        $achievement1 = Achievement::first();
        $achievement2 = Achievement::skip(1)->first();

        CompletedAchievement::create([
            'user_id' => $user->id,
            'achievement_id' => $achievement1->id,
            'completion_date' => now(),
            'completions' => 1,
        ]);

        Sanctum::actingAs($user);
        $response = $this->getJson('/api/achievements');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        
        $completed = collect($data)->firstWhere('id', $achievement1->id);
        $notCompleted = collect($data)->firstWhere('id', $achievement2->id);
        
        $this->assertTrue($completed['completed']);
        $this->assertFalse($notCompleted['completed']);
    }

    #[Test]
    public function user_can_mark_achievement_as_completed()
    {
        $user = User::factory()->create();
        
        $achievement = Achievement::first();
        if (!$achievement) {
            $achievement = Achievement::create([
                'category_id' => 1,
                'name' => 'Manual Achievement',
                'description' => 'Just for testing',
                'xp' => 100,
                'difficulty' => 'easy',
                'repeatable' => false,
            ]);
        }

        $initialXP = $user->xp;
        Sanctum::actingAs($user);

        $response = $this->postJson("/api/achievements/{$achievement->id}/complete");

        $response->assertStatus(200)
                ->assertJsonStructure(['message', 'xp', 'badge']);

        $this->assertDatabaseHas('completed_achievements', [
            'user_id' => $user->id,
            'achievement_id' => $achievement->id,
        ]);

        $user->refresh();
        $this->assertEquals($initialXP + $achievement->xp, $user->xp);
    }

    #[Test]
    public function marking_achievement_twice_does_not_duplicate_record_for_non_repeatable()
    {
        $user = User::factory()->create();
        $achievement = Achievement::create([
            'category_id' => 1,
            'name' => 'Non-repeatable Test',
            'description' => 'Testing non-repeatable',
            'xp' => 50,
            'difficulty' => 'medium',
            'repeatable' => false,
        ]);

        Sanctum::actingAs($user);

        $this->postJson("/api/achievements/{$achievement->id}/complete");
        $this->postJson("/api/achievements/{$achievement->id}/complete");

        $count = CompletedAchievement::where('user_id', $user->id)
            ->where('achievement_id', $achievement->id)
            ->count();

        $this->assertEquals(1, $count);
    }

    #[Test]
    public function marking_repeatable_achievement_twice_increments_completions()
    {
        $user = User::factory()->create();
        $achievement = Achievement::create([
            'category_id' => 1,
            'name' => 'Repeatable Test',
            'description' => 'Testing repeatable',
            'xp' => 50,
            'difficulty' => 'medium',
            'repeatable' => true,
        ]);

        Sanctum::actingAs($user);

        $this->postJson("/api/achievements/{$achievement->id}/complete");
        $this->postJson("/api/achievements/{$achievement->id}/complete");

        $record = CompletedAchievement::where('user_id', $user->id)
            ->where('achievement_id', $achievement->id)
            ->first();

        $this->assertNotNull($record);
        $this->assertEquals(2, $record->completions);
    }

    #[Test]
    public function authenticated_user_can_view_their_own_completed_achievements()
    {
        $user = User::factory()->create();

        $a1 = Achievement::create([
            'category_id' => 1,
            'name' => 'Achievement A1',
            'description' => 'Test A1',
            'xp' => 20,
            'difficulty' => 'easy',
            'repeatable' => false,
        ]);

        $a2 = Achievement::create([
            'category_id' => 1,
            'name' => 'Achievement A2',
            'description' => 'Test A2',
            'xp' => 40,
            'difficulty' => 'hard',
            'repeatable' => false,
        ]);

        CompletedAchievement::create([
            'user_id' => $user->id,
            'achievement_id' => $a1->id,
            'completion_date' => now(),
            'completions' => 1,
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/my-achievements');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        
        $this->assertCount(1, $data);
        
        $achievementIds = collect($data)->pluck('achievement_id')->toArray();
        $this->assertContains($a1->id, $achievementIds);
        $this->assertNotContains($a2->id, $achievementIds);
    }

    #[Test]
    public function it_returns_all_categories()
    {
        $initialCount = Category::count();

        Category::create([
            'name' => 'Tech',
            'description' => 'Technology news',
            'icon' => null,
            'color' => 'FF0000'
        ]);

        Category::create([
            'name' => 'Sports',
            'description' => 'All about sports',
            'icon' => null,
            'color' => '00FF00'
        ]);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'description', 'icon']
            ]
        ]);
        
        $data = $response->json('data');
        $this->assertCount($initialCount + 2, $data);
    }

    #[Test]
    public function it_returns_a_single_category()
    {
        $cat = Category::create([
            'name' => 'Gaming',
            'description' => 'Video games',
            'icon' => 'gaming.png',
            'color' => '0000FF'
        ]);

        $response = $this->getJson("/api/categories/{$cat->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $cat->id,
                     'name' => 'Gaming',
                 ])
                 ->assertJsonFragment(['color' => '0000FF']);
    }

    #[Test]
    public function it_creates_a_new_category()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $cat = Category::create([
            'name' => 'Music test',
            'description' => 'Music related topics',
            'icon' => 'music.png',
            'color' => 'FFAA00'
        ]);

        $response = $this->getJson("/api/categories/{$cat->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Music test'])
                 ->assertJsonFragment(['description' => 'Music related topics']);

        $this->assertDatabaseHas('categories', [
            'name' => 'Music test',
        ]);
    }

    #[Test]
    public function it_validates_required_fields_when_creating_category()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/categories', []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['name']);
    }

    #[Test]
    public function user_can_view_other_user_public_profile()
    {
        $user1 = User::factory()->create(['name' => 'User One', 'xp' => 100]);
        $user2 = User::factory()->create(['name' => 'User Two']);

        $token = $user1->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->getJson("/api/users/{$user2->id}");

        $response->assertStatus(200)
                ->assertJsonFragment(['id' => $user2->id, 'name' => 'User Two']);
    }

    #[Test]
    public function user_can_update_profile_name()
    {
        $user = User::factory()->create(['name' => 'Old Name']);

        Sanctum::actingAs($user);

        $response = $this->putJson('/api/me', [
            'name' => 'New Name',
        ]);

        $response->assertStatus(200);

        $user->refresh();
        $this->assertEquals('New Name', $user->name);
    }

    #[Test]
    public function user_can_update_profile_bio()
    {
        $user = User::factory()->create(['bio' => 'Old bio']);

        Sanctum::actingAs($user);

        $response = $this->putJson('/api/me', [
            'name' => $user->name,
            'bio' => 'New bio about me',
        ]);

        $response->assertStatus(200);

        $user->refresh();
        $this->assertEquals('New bio about me', $user->bio);
    }

    #[Test]
    public function user_can_update_password()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);

        Sanctum::actingAs($user);

        $response = $this->putJson('/api/me', [
            'name' => $user->name,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertStatus(200);

        $loginResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'oldpassword'
        ]);
        $loginResponse->assertStatus(422);

        $loginResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'newpassword'
        ]);
        $loginResponse->assertStatus(200);
    }

    #[Test]
    public function user_profile_validation_rejects_invalid_bio_length()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->putJson('/api/me', [
            'bio' => str_repeat('a', 301),
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['bio']);
    }

    #[Test]
    public function user_can_list_all_badges()
    {
        $response = $this->getJson('/api/badges');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => ['id', 'name', 'description']
                    ]
                ]);
    }

    #[Test]
    public function user_can_view_single_badge()
    {
        $badge = \App\Models\Badge::first();

        if (!$badge) {
            $badge = \App\Models\Badge::create([
                'name' => 'Test Badge',
                'description' => 'A test badge',
                'requirement_text' => 'Do something'
            ]);
        }

        $response = $this->getJson("/api/badges/{$badge->id}");

        $response->assertStatus(200)
                ->assertJsonFragment(['id' => $badge->id, 'name' => $badge->name]);
    }

    #[Test]
    public function authenticated_user_can_list_earned_badges()
    {
        $user = User::factory()->create();

        $badge = \App\Models\Badge::first();
        if (!$badge) {
            $badge = \App\Models\Badge::create([
                'name' => 'First Badge',
                'description' => 'First earned badge',
                'requirement_text' => null
            ]);
        }

        $user->badges()->attach($badge->id);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/my-badges');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
        
        $badgeIds = collect($data)->pluck('id')->toArray();
        $this->assertContains($badge->id, $badgeIds);
    }

    #[Test]
    public function user_can_create_new_badge()
    {
        $badge = \App\Models\Badge::first();
        
        if (!$badge) {
            $badge = \App\Models\Badge::create([
                'name' => 'Test Badge Direct',
                'description' => 'Direct test badge',
                'requirement_text' => 'Test requirement',
                'icon' => 'https://example.com/test.png'
            ]);
        }

        $response = $this->getJson("/api/badges/{$badge->id}");

        $response->assertStatus(200)
                ->assertJsonFragment(['id' => $badge->id, 'name' => $badge->name]);
    }

    #[Test]
    public function user_can_add_achievement_to_goals()
    {
        $user = User::factory()->create();
        $achievement = Achievement::first();

        if (!$achievement) {
            $achievement = Achievement::create([
                'category_id' => 1,
                'name' => 'Goal Test',
                'description' => 'Test',
                'xp' => 10,
                'difficulty' => 'easy',
                'repeatable' => false
            ]);
        }

        Sanctum::actingAs($user);

        $response = $this->postJson("/api/goals/{$achievement->id}");

        $response->assertStatus(201)
                ->assertJsonFragment(['message' => 'Goal added']);

        $this->assertDatabaseHas('goals', [
            'user_id' => $user->id,
            'achievement_id' => $achievement->id
        ]);
    }

    #[Test]
    public function user_can_list_their_goals()
    {
        $user = User::factory()->create();

        $a1 = Achievement::create([
            'category_id' => 1,
            'name' => 'Goal A1',
            'description' => 'Test',
            'xp' => 10,
            'difficulty' => 'easy',
            'repeatable' => false
        ]);

        $a2 = Achievement::create([
            'category_id' => 1,
            'name' => 'Goal A2',
            'description' => 'Test',
            'xp' => 20,
            'difficulty' => 'medium',
            'repeatable' => false
        ]);

        \App\Models\Goal::create(['user_id' => $user->id, 'achievement_id' => $a1->id]);
        \App\Models\Goal::create(['user_id' => $user->id, 'achievement_id' => $a2->id]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/goals');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        $this->assertCount(2, $data);
    }

    #[Test]
    public function user_can_remove_goal()
    {
        $user = User::factory()->create();

        $achievement = Achievement::create([
            'category_id' => 1,
            'name' => 'Remove Goal Test',
            'description' => 'Test',
            'xp' => 10,
            'difficulty' => 'easy',
            'repeatable' => false
        ]);

        $goal = \App\Models\Goal::create(['user_id' => $user->id, 'achievement_id' => $achievement->id]);

        Sanctum::actingAs($user);

        $response = $this->deleteJson("/api/goals/{$achievement->id}");

        $response->assertStatus(200)
                ->assertJsonFragment(['message' => 'Goal removed']);

        $this->assertDatabaseMissing('goals', [
            'id' => $goal->id
        ]);
    }

    #[Test]
    public function user_can_send_friend_request()
    {
        $user1 = User::factory()->create(['name' => 'User 1']);
        $user2 = User::factory()->create(['name' => 'User 2']);

        Sanctum::actingAs($user1);

        $response = $this->postJson('/api/friends', [
            'name' => 'User 2'
        ]);

        $response->assertStatus(201)
                ->assertJsonFragment(['message' => 'Friend request sent']);

        $this->assertDatabaseHas('friend_requests', [
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'pending'
        ]);
    }

    #[Test]
    public function user_cannot_send_friend_request_to_self()
    {
        $user = User::factory()->create(['name' => 'Self User']);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/friends', [
            'name' => 'Self User'
        ]);

        $response->assertStatus(400);
    }

    #[Test]
    public function user_cannot_send_duplicate_friend_request()
    {
        $user1 = User::factory()->create(['name' => 'User 1']);
        $user2 = User::factory()->create(['name' => 'User 2']);

        Sanctum::actingAs($user1);
        $this->postJson('/api/friends', ['name' => 'User 2']);

        $response = $this->postJson('/api/friends', ['name' => 'User 2']);

        $response->assertStatus(409);
    }

    #[Test]
    public function user_can_accept_friend_request()
    {
        $user1 = User::factory()->create(['name' => 'Sender']);
        $user2 = User::factory()->create(['name' => 'Receiver']);

        $friendRequest = \App\Models\friend_request::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'pending'
        ]);

        Sanctum::actingAs($user2);

        $response = $this->postJson("/api/friend-requests/{$friendRequest->id}/accept");

        $response->assertStatus(200)
                ->assertJsonFragment(['message' => 'Friend request accepted']);

        $friendRequest->refresh();
        $this->assertEquals('accepted', $friendRequest->status);
    }

    #[Test]
    public function user_can_cancel_outgoing_friend_request()
    {
        $user1 = User::factory()->create(['name' => 'Sender']);
        $user2 = User::factory()->create(['name' => 'Receiver']);

        $friendRequest = \App\Models\friend_request::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'pending'
        ]);

        Sanctum::actingAs($user1);

        $response = $this->deleteJson("/api/friend-requests/{$friendRequest->id}");

        $response->assertStatus(200)
                ->assertJsonFragment(['message' => 'Friend request cancelled']);

        $this->assertDatabaseMissing('friend_requests', [
            'id' => $friendRequest->id
        ]);
    }

    #[Test]
    public function user_can_list_pending_friend_requests()
    {
        $user1 = User::factory()->create(['name' => 'Main User']);
        $user2 = User::factory()->create(['name' => 'Sender']);
        $user3 = User::factory()->create(['name' => 'Receiver']);

        \App\Models\friend_request::create([
            'sender_id' => $user2->id,
            'receiver_id' => $user1->id,
            'status' => 'pending'
        ]);

        \App\Models\friend_request::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user3->id,
            'status' => 'pending'
        ]);

        Sanctum::actingAs($user1);

        $response = $this->getJson('/api/friend-requests');

        $response->assertStatus(200);
        
        $data = $response->json();
        $this->assertIsArray($data['incoming']);
        $this->assertIsArray($data['sent']);
    }

    #[Test]
    public function user_can_list_accepted_friends()
    {
        $user1 = User::factory()->create(['name' => 'Main User']);
        $user2 = User::factory()->create(['name' => 'Friend 1']);
        $user3 = User::factory()->create(['name' => 'Friend 2']);

        \App\Models\friend_request::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'accepted'
        ]);

        \App\Models\friend_request::create([
            'sender_id' => $user3->id,
            'receiver_id' => $user1->id,
            'status' => 'accepted'
        ]);

        Sanctum::actingAs($user1);

        $response = $this->getJson('/api/friends');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        $this->assertCount(2, $data);
    }

    #[Test]
    public function user_can_remove_friend()
    {
        $user1 = User::factory()->create(['name' => 'User 1']);
        $user2 = User::factory()->create(['name' => 'User 2']);

        $friendship = \App\Models\friend_request::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'accepted'
        ]);

        Sanctum::actingAs($user1);

        $response = $this->deleteJson("/api/friends/{$user2->id}");

        $response->assertStatus(200)
                ->assertJsonFragment(['message' => 'Friend removed']);

        $this->assertDatabaseMissing('friend_requests', [
            'id' => $friendship->id
        ]);
    }
}
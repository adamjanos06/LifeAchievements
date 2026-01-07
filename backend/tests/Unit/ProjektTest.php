<?php

namespace Tests\Unit;


use App\Models\Achievement;
use App\Models\Category;
use App\Models\CompletedAchievement;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;


class ProjektTest extends TestCase
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
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'user' => ['id', 'name', 'email'],
                     'token'
                 ]);

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
                ->assertJson([
                    'id' => $user->id,
                    'email' => $user->email,
                ]);
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

        foreach ($data as $item) {
            $this->assertFalse($item['completed']);
        }
    }

    #[Test]
    public function authenticated_user_sees_which_achievements_are_completed()
    {
        $user = User::factory()->create();


        CompletedAchievement::create([
            'user_id' => $user->id,
            'achievement_id' => 1,
            'completion_date' => now(),
        ]);

        Sanctum::actingAs($user);
        $response = $this->getJson('/api/achievements');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => 1,
            'completed' => true,
        ]);
        $response->assertJsonFragment([
            'id' => 2,
            'completed' => false,
        ]);
    }

    #[Test]
    public function user_can_mark_achievement_as_completed()
    {
        $user = User::factory()->create();
        $achievement = Achievement::create([
            'category_id' => 1,
            'name' => 'Manual Achievement',
            'description' => 'Just for testing',
            'xp' => 100,
            'difficulty' => 'easy'
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson("/api/achievements/{$achievement->id}/complete");

        $response->assertStatus(200)
                ->assertJson(['message' => 'Achievement marked as completed']);

        $this->assertDatabaseHas('completed_achievements', [
            'user_id' => $user->id,
            'achievement_id' => $achievement->id,
        ]);
    }

    #[Test]
    public function marking_achievement_twice_does_not_duplicate_record()
    {
        $user = User::factory()->create();
        $achievement = Achievement::create([
            'category_id' => 1,
            'name' => 'Duplicate Test',
            'description' => 'Testing duplicates',
            'xp' => 50,
            'difficulty' => 'medium'
        ]);

        Sanctum::actingAs($user);

        $this->postJson("/api/achievements/{$achievement->id}/complete");

        $this->postJson("/api/achievements/{$achievement->id}/complete");

        $this->assertEquals(
            1,
            CompletedAchievement::where('user_id', $user->id)
                ->where('achievement_id', $achievement->id)
                ->count()
        );
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
            'difficulty' => 'easy'
        ]);

        $a2 = Achievement::create([
            'category_id' => 1,
            'name' => 'Achievement A2',
            'description' => 'Test A2',
            'xp' => 40,
            'difficulty' => 'hard'
        ]);

        CompletedAchievement::create([
            'user_id' => $user->id,
            'achievement_id' => $a1->id,
            'completion_date' => now(),
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/my-achievements');

        $response->assertStatus(200)
                ->assertJsonCount(1, 'data')
                ->assertJsonFragment(['id' => $a1->id])
                ->assertJsonMissing(['id' => $a2->id]);
    }

    #[Test]
    public function it_returns_all_categories()
    {
        $initialCount = Category::count();

        Category::create([
            'name' => 'Tech',
            'description' => 'Technology news',
            'icon' => 'tech.png'
        ]);

        Category::create([
            'name' => 'Sports',
            'description' => 'All about sports',
            'icon' => 'sports.png'
        ]);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
                ->assertJsonCount($initialCount + 2, 'data');
    }

    #[Test]
    public function it_returns_a_single_category()
    {
        $cat = Category::create([
            'name' => 'Gaming',
            'description' => 'Video games',
            'icon' => 'gaming.png'
        ]);

        $response = $this->getJson("/api/categories/{$cat->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $cat->id,
                     'name' => 'Gaming',
                 ]);
    }

    #[Test]
    public function it_creates_a_new_category()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $payload = [
            'name' => 'Music test',
            'description' => 'Music related topics',
            'icon' => 'music.png'
        ];

        $response = $this->postJson('/api/categories', $payload);

        $response->assertStatus(201)
                ->assertJsonFragment(['name' => 'Music test']);

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
}
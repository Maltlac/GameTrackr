<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_user_and_returns_token()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'secret123',
        ]);
        $response->assertStatus(201)
            ->assertJsonStructure(['user', 'token']);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_login_returns_token()
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('secret123'),
        ]);
        $response = $this->postJson('/api/login', [
            'email' => 'login@example.com',
            'password' => 'secret123',
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure(['user', 'token']);
    }

    public function test_me_requires_authentication()
    {
        $response = $this->getJson('/api/me');
        $response->assertStatus(401);
    }

    public function test_me_returns_user_with_token()
    {
        $user = User::factory()->create();
        $token = $user->createToken('apitoken')->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/me');
        $response->assertStatus(200)
            ->assertJson(['id_user' => $user->id_user]);
    }

    public function test_logout_revokes_token()
    {
        $user = User::factory()->create();
        $token = $user->createToken('apitoken')->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/logout');
        $response->assertStatus(200)
            ->assertJson(['message' => 'Logged out']);
    }
}

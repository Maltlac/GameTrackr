<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Game;

class GameTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_game_creates_game_and_returns_201()
    {
        $data = [
            'title' => 'Cyberpunk 2077',
            'description' => 'Un jeu futuriste.',
            'cover_url' => 'https://example.com/cyberpunk.jpg',
            'release_date' => '2020-12-10',
            'percentage' => 42.50,
        ];
        $response = $this->postJson('/api/games', $data);
        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Cyberpunk 2077', 'percentage' => 42.50]);
        $this->assertDatabaseHas('games', ['title' => 'Cyberpunk 2077', 'percentage' => 42.50]);
    }

    public function test_store_game_missing_fields_returns_422()
    {
        $response = $this->postJson('/api/games', [
            // 'title' manquant
            'cover_url' => 'https://example.com/cover.jpg'
        ]);
        $response->assertStatus(422);

        $response = $this->postJson('/api/games', [
            // tout manquant
        ]);
        $response->assertStatus(422);
    }

    public function test_show_game_returns_correct_data()
    {
        $game = Game::factory()->create([
            'title' => 'The Witcher 3',
            'description' => 'Un RPG culte.',
            'cover_url' => 'https://example.com/witcher3.jpg',
            'release_date' => '2015-05-19',
            'percentage' => 99.99,
        ]);
        $response = $this->getJson('/api/games/' . $game->id_game);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'The Witcher 3', 'percentage' => 99.99]);
    }

    public function test_show_game_not_found_returns_404()
    {
        $response = $this->getJson('/api/games/999999');
        $response->assertStatus(404);
    }
}

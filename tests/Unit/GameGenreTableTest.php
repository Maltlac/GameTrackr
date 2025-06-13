<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class GameGenreTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_game_genre_table_exists_and_columns()
    {
        $this->assertTrue(Schema::hasTable('game_genre'));
        $this->assertTrue(Schema::hasColumns('game_genre', [
            'id_game', 'id_genre'
        ]));
    }

    public function test_game_genre_foreign_keys()
    {
        $gameId = DB::table('games')->insertGetId([
            'title' => 'Test',
            'cover_url' => 'https://example.com/test.jpg',
            'release_date' => '2024-01-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $genreId = DB::table('genres')->insertGetId([
            'name' => 'RPG',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('game_genre')->insert([
            'id_game' => $gameId,
            'id_genre' => $genreId,
        ]);
        $this->assertDatabaseHas('game_genre', [
            'id_game' => $gameId,
            'id_genre' => $genreId,
        ]);
    }
}

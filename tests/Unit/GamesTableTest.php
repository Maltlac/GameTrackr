<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class GamesTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_games_table_exists_and_columns()
    {
        $this->assertTrue(Schema::hasTable('games'));
        $this->assertTrue(Schema::hasColumns('games', [
            'id_game', 'title', 'cover_url', 'release_date', 'created_at', 'updated_at'
        ]));
    }

    public function test_games_table_insertion()
    {
        $id = DB::table('games')->insertGetId([
            'title' => 'Game 1',
            'cover_url' => 'https://example.com/game1.jpg',
            'release_date' => '2024-01-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->assertDatabaseHas('games', ['id_game' => $id]);
    }
}

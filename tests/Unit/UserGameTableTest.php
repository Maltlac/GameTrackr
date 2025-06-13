<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class UserGameTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_games_table_exists_and_columns()
    {
        $this->assertTrue(Schema::hasTable('user_game'));
        $this->assertTrue(Schema::hasColumns('user_game', [
            'id_user', 'id_game'
        ]));
    }

    public function test_user_games_foreign_keys()
    {
        $userId = DB::table('users')->insertGetId([
            'name' => 'user1',
            'email' => 'user1@example.com',
            'password' => bcrypt('secret'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $gameId = DB::table('games')->insertGetId([
            'title' => 'Test',
            'description' => 'Desc',
            'release_date' => '2024-01-01',
            'cover_url' => 'https://example.com/test.jpg',
            'percentage'=> 50.2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('user_game')->insert([
            'id_user' => $userId,
            'id_game' => $gameId,
        ]);
        $this->assertDatabaseHas('user_game', [
            'id_user' => $userId,
            'id_game' => $gameId,
        ]);
    }
}

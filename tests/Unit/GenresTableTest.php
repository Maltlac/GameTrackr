<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class GenresTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_genres_table_exists_and_columns()
    {
        $this->assertTrue(Schema::hasTable('genres'));
        $this->assertTrue(Schema::hasColumns('genres', [
            'id_genre', 'name', 'created_at', 'updated_at'
        ]));
    }

    public function test_genres_table_insertion()
    {
        $id = DB::table('genres')->insertGetId([
            'name' => 'Action',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->assertDatabaseHas('genres', ['id_genre' => $id]);
    }
}

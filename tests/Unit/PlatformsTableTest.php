<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
class PlatformsTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_platforms_table_exists_and_columns()
    {
        $this->assertTrue(Schema::hasTable('platforms'));
        $this->assertTrue(Schema::hasColumns('platforms', [
            'id_platform', 'name', 'created_at', 'updated_at'
        ]));
    }

    public function test_platforms_table_insertion()
    {
        $id = DB::table('platforms')->insertGetId([
            'name' => 'PC',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->assertDatabaseHas('platforms', ['id_platform' => $id]);
    }
}

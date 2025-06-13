<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_table_exists_and_columns()
    {
        $this->assertTrue(Schema::hasTable('users'));
        $this->assertTrue(Schema::hasColumns('users', [
            'id_user', 'name', 'email', 'password', 'created_at', 'updated_at'
        ]));
    }

    public function test_users_table_insertion()
    {
        $user = DB::table('users')->insertGetId([
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->assertDatabaseHas('users', ['id_user' => $user]);
    }
}

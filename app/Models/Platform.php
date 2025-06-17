<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Game;

class Platform extends Model
{
    use HasFactory;

    protected $table = 'platforms';
    protected $primaryKey = 'id_platform';
    public $timestamps = true;

    protected $fillable = ['name'];

    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_platform', 'id_platform', 'id_game')
            ->withPivot('link');
    }
}

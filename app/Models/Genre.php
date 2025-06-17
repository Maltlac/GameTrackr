<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Game;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'genres';
    protected $primaryKey = 'id_genre';
    public $timestamps = true;

    protected $fillable = ['name'];

    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_genre', 'id_genre', 'id_game');
    }
}

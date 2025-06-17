<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Genre;
use App\Models\Platform;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';
    protected $primaryKey = 'id_game';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'cover_url',
        'release_date',
        'description', // description du jeu (optionnel)
        'percentage', // progression du jeu (optionnel)
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'game_genre', 'id_game', 'id_genre');
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'game_platform', 'id_game', 'id_platform')
            ->withPivot('link');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}

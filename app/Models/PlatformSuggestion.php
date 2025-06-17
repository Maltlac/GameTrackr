<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlatformSuggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'id_game', 'platform', 'link', 'approved'
    ];
}

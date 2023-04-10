<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'white_player_id',
        'black_player_id',
        'gametype_id',
        'result',
        'pgn',
        'date',
    ];

    public function white_player()
    {
        return $this->belongsTo(User::class, 'white_player_id');
    }

    public function black_player()
    {
        return $this->belongsTo(User::class, 'black_player_id');
    }

    public function gametype()
    {
        return $this->belongsTo(Gametype::class);
    }
}

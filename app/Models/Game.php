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
        'gamerule_id',
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

    public function winner()
    {
        if ($this->result === '1-0')
            return $this->white_player();
        else if ($this->result === '0-1')
            return $this->black_player();
        else
            return null;
    }

    public function winnerColor()
    {
        if ($this->result === '1-0')
            return 'WHITE';
        else if ($this->result === '0-1')
            return 'BLACK';
        else
            return null;
    }

    public function gameRule()
    {
        return $this->belongsTo(Gamerule::class, 'gamerule_id');
    }

    public function gametype()
    {
        return $this->gameRule()->gameType();
    }
}

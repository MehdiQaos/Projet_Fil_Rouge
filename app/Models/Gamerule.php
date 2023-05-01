<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gamerule extends Model
{
    use HasFactory;

    protected $fillable = [
        'length',
        'name',
        'move_addtime_type',
        'move_addtime',
        'gametype_id',
    ];

    public function gameType()
    {
        return $this->belongsTo(Gametype::class, 'gametype_id');
    }
}

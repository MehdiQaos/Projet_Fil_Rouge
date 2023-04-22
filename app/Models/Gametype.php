<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gametype extends Model
{
    use HasFactory;

    public static $CLASSIC = 1;
    public static $RAPID = 2;
    public static $BLITZ = 3;
    public static $BULLET = 4;

    public function gameRules()
    {
        return $this->hasMany(Gamerule::class, 'gametype_id');
    }
}

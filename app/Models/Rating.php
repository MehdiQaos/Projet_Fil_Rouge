<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gametype_id',
        'rating',
    ];

    public static function makeRatings(User $user)
    {
        $gameTypesIds = Gametype::pluck('id')->toArray();

        foreach($gameTypesIds as $id) {
            Rating::create([
                'user_id' => $user->id,
                'rating' => random_int(400, 1500),
                'gametype_id' => $id,
            ]);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gameType()
    {
        return $this->belongsTo(Gametype::class, 'gametype_id');
    }
}

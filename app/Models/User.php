<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'role_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role->id === 2;
    }

    public function ratings() {
        return $this->hasMany(Rating::class);
    }

    public function rating($gameTypeId)
    {
        return $this->ratings->where('gametype_id', $gameTypeId)->first()->rating;
    }

    public function ratingObject($gameTypeId)
    {
        return $this->ratings->where('gametype_id', $gameTypeId)->first();
    }

    public function whiteGames()
    {
        return $this->hasMany(Game::class, 'white_player_id');
    }

    public function blackGames()
    {
        return $this->hasMany(Game::class, 'black_player_id');
    }

    public function games()
    {
        return $this->whiteGames->merge($this->blackGames);
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // public function latestWhiteGames()
    // {
    //     return $this->hasOne(Game::class, 'white_player_id')->latestOfMany();
    // }

    // public function latestBlackGames()
    // {
    //     return $this->hasOne(Game::class, 'black_player_id')->latestOfMany();
    // }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'white_player_id' => 1,
            'black_player_id' => 1,
            'gamerule_id' => 1,
            'result' => '1-0',
            'date' => now(),
            'pgn' => 'd4',
        ];
    }
}

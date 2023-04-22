<?php

namespace Database\Seeders;

use App\Models\Gamerule;
use App\Models\Gametype;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameruleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gamerule::create([
            'length' => 10 * 60,
            'move_addtime_type' => 'increment',
            'move_addtime' => 5,
            'gametype_id' => Gametype::$RAPID,
        ]);

        Gamerule::create([
            'length' => 3 * 60,
            'move_addtime_type' => 'increment',
            'move_addtime' => 3,
            'gametype_id' => Gametype::$BLITZ,
        ]);

        Gamerule::create([
            'length' => 60,
            'move_addtime_type' => 'delay',
            'move_addtime' => 1,
            'gametype_id' => Gametype::$BULLET,
        ]);
    }
}

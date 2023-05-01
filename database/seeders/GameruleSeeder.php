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
            'length' => 40 * 60,
            'name' => '40 Minutes + 10, increment',
            'move_addtime_type' => 'increment',
            'move_addtime' => 10,
            'gametype_id' => Gametype::$CLASSIC,
        ]);

        Gamerule::create([
            'length' => 60 * 60,
            'name' => '60 Minutes + 10, increment',
            'move_addtime_type' => 'increment',
            'move_addtime' => 10,
            'gametype_id' => Gametype::$CLASSIC,
        ]);

        Gamerule::create([
            'length' => 10 * 60,
            'name' => '10 Minutes + 5, increment',
            'move_addtime_type' => 'increment',
            'move_addtime' => 5,
            'gametype_id' => Gametype::$RAPID,
        ]);

        Gamerule::create([
            'length' => 20 * 60,
            'name' => '20 Minutes + 5, increment',
            'move_addtime_type' => 'increment',
            'move_addtime' => 5,
            'gametype_id' => Gametype::$RAPID,
        ]);

        Gamerule::create([
            'length' => 15 * 60,
            'name' => '15 Minutes + 5, delay',
            'move_addtime_type' => 'delay',
            'move_addtime' => 5,
            'gametype_id' => Gametype::$RAPID,
        ]);

        Gamerule::create([
            'length' => 3 * 60,
            'name' => '3 Minutes + 3, increment',
            'move_addtime_type' => 'increment',
            'move_addtime' => 3,
            'gametype_id' => Gametype::$BLITZ,
        ]);

        Gamerule::create([
            'length' => 3 * 60,
            'name' => '3 Minutes + 3, increment',
            'move_addtime_type' => 'increment',
            'move_addtime' => 3,
            'gametype_id' => Gametype::$BLITZ,
        ]);

        Gamerule::create([
            'length' => 60,
            'name' => '1 Minutes + 1, delay',
            'move_addtime_type' => 'delay',
            'move_addtime' => 1,
            'gametype_id' => Gametype::$BULLET,
        ]);

        Gamerule::create([
            'length' => 30,
            'name' => '30 Seconds + 1, increment',
            'move_addtime_type' => 'increment',
            'move_addtime' => 1,
            'gametype_id' => Gametype::$BULLET,
        ]);
    }
}

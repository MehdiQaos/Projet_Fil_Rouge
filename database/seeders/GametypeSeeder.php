<?php

namespace Database\Seeders;

use App\Models\Gametype;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GametypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $gameTypes = ['classic', 'rapid', 'blitz', 'bullet'];
        // foreach ($gameTypes as $gameType) {
        //     Gametype::create([
        //         'name' => $gameType
        //     ]);
        // }
        Gametype::create([
            'id' => Gametype::$CLASSIC,
            'name' => 'classic',
        ]);

        Gametype::create([
            'id' => Gametype::$RAPID,
            'name' => 'rapid',
        ]);

        Gametype::create([
            'id' => Gametype::$BLITZ,
            'name' => 'blitz',
        ]);

        Gametype::create([
            'id' => Gametype::$BULLET,
            'name' => 'bullet',
        ]);

    }
}

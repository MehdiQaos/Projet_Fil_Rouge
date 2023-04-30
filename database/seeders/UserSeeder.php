<?php

namespace Database\Seeders;

use App\Models\Gametype;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->makeAdmin()->create([
            'first_name' => 'El Mehdi',
            'last_name' => 'Qaos',
            'user_name' => 'MehdiQaos',
            'email' => 'mehdi.qaos@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->makeAdmin()->create([
            'first_name' => 'Mohammed',
            'last_name' => 'Qaos',
            'user_name' => 'MohammedQaos',
            'email' => 'mohammed.qaos@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $gameTypesIds = Gametype::pluck('id')->toArray();

        $users = User::factory()->makePleb()->count(20)->create();
        $users->each(function($user) use($gameTypesIds) {
            foreach($gameTypesIds as $id) {
                Rating::create([
                    'user_id' => $user->id,
                    'rating' => random_int(400, 1500),
                    'gametype_id' => $id,
                ]);
            }
        });
    }
}

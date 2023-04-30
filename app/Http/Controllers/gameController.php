<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class gameController extends Controller
{
    public function view(Game $game)
    {
        return view('mygame', [
            'game' => $game,
        ]);
    }
}

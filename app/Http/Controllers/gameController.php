<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;

class gameController extends Controller
{
    public function view(Game $game)
    {
        $user = auth()->user();
        $orientation = 'white';
        if ($user->id === $game->black_player_id) {
            $opponentId = $game->white_player_id;
            $orientation = 'black';
        }
        else
            $opponentId = $game->black_player_id;
        $opponentName = User::find($opponentId)->user_name;

        if ($game->winnerColor() === $orientation) {
            $userScore = '1';
            $opponentScore = '0';
        } else {
            $userScore = '0';
            $opponentScore = '1';
        }

        return view('mygame', [
            'game' => $game,
            'userName' => $user->user_name,
            'opponentName' => $opponentName,
            'orientation' => $orientation,
            'userScore' => $userScore,
            'opponentScore' => $opponentScore,
        ]);
    }
}

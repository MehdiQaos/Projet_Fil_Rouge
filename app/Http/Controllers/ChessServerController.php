<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Gamerule;
use App\Models\Gametype;
use App\Models\User;
use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class ChessServerController extends Controller implements MessageComponentInterface
{
    // protected $connections;
    private $players;
    private $games;
    private $rankedPools;
    private $gameRules;

    public function __construct()
    {
        $this->gameRules = Gamerule::all();
        $this->players = [];
        $this->games = [];
        $this->rankedPools = [];
        foreach ($this->gameRules as $gameRule) {
            $this->rankedPools[$gameRule->id] = [];
        }

        echo "listening on port 8090..\n";
        // echo "ranked pools count: " . count($this->rankedPools) . "\n";
        // echo "guests pools count: " . count($this->guestsPools) . "\n";
    }

    public function onOpen(ConnectionInterface $conn)
    {
        echo "New connection! ({$conn->resourceId})\n";
    }

    private function newGame($player1 = null, $player2 = null, $gameRuleId, $ranked)
    {
        $gameRule = Gamerule::find($gameRuleId);
        $gameId = uniqid('game_');
        $game = [
            'player1' => $player1,
            'player2' => $player2,
            'player1score' => 0,
            'player2score' => 0,
            'gameRuleId' => $gameRuleId,
            'gameRules' => [
                'length' => $gameRule->length,
                'addTimeType' => $gameRule->move_addtime_type,
                'addTime' => $gameRule->move_addtime,
            ],
            'ranked' => $ranked,
            'saved' => false,
        ];
        $this->games[$gameId] = $game;

        return $gameId;
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $msg = json_decode($msg);
        $data = $msg->data;
        switch ($msg->type) {
            case 'connect':
                $this->handleConnect($from, $data);
                break;
            case 'custom':
                $this->handleCustom($from, $data);
                break;
            case 'find':
                $this->handleFind($from, $data);
                break;
            case 'game':
                $this->handleGame($from, $data);
                break;
        }
    }

    private function handleGame($from, $data)
    {
        $type = $data->type;
        switch ($type) {
            case 'move':
                $this->handleGameMove($from, $data->data);
                break;
            case 'draw':
                $this->handleGameDraw($from, $data->data);
                break;
            case 'resign':
                $this->handleGameResign($from, $data->data);
                break;
            case 'take_back':
                $this->handleGameTakeBack($from, $data->data);
                break;
            case 'rematch':
                $this->handleGameRematch($from, $data->data);
                break;
            case 'result':
                $this->handleGameResult($from, $data->data);
                break;
        }
    }

    private function handleGameResult($from, $data)
    {
        $gameId = $data->gameId;
        $result = $data->result;
        $pgn = $data->pgn;
        $color = $data->color;
        $game = &$this->games[$gameId]; // remove &
        if ($game['saved'])
            return;
        $player1 = $this->players[$from->resourceId];
        $player2 = $game['player1']['connection']->resourceId === $player1['connection']->resourceId?
                   $game['player2']:
                   $game['player1'];
        
        if ($color === 'black') {
            $temp = &$player1;
            $player1 = &$player2;
            $player2 = &$temp;
        } 

        $gameRuleId = $game['gameRuleId'];

        if ($game['ranked']) {
            echo "saving game\n";
            Game::create([
                'white_player_id' => $player1['userId'],
                'black_player_id' => $player2['userId'],
                'gamerule_id' => $gameRuleId,
                'result' => $result,
                'pgn' => $pgn,
                'date' => now(),
            ]);
            $game['saved'] = true;

            $this->updateRatings($player1['userId'], $player2['userId'], $gameRuleId, $result);
        }
    }

    private function updateRatings($player1Id, $player2Id, $gameRuleId, $result) 
    {
        $K = 32;
        if ($result === '1-0') {
            $W1 = 1;
            $W2 = 0;
        } else if ($result === '0-1') {
            $W1 = 0;
            $W2 = 1;
        } else {
            $W1 = 0.5;
            $W2 = 0.5;
        }
        
        $gameTypeId = Gamerule::find($gameRuleId)->gametype_id;
        $p1Rating = User::find($player1Id)->ratingObject($gameTypeId);
        $p2Rating = User::find($player2Id)->ratingObject($gameTypeId);

        $p1OldRating = $p1Rating->rating;
        $p2OldRating = $p2Rating->rating;

        $Ep1 = 1 / (1 + pow(10, ($p2OldRating - $p1OldRating) / 4000));
        $Ep2 = 1 / (1 + pow(10, ($p1OldRating - $p2OldRating) / 4000));

        $p1NewRating = $p1Rating->rating + $K * ($W1 - $Ep1);
        $p2NewRating = $p2Rating->rating + $K * ($W2 - $Ep2);

        $p1Rating->rating = (int) $p1NewRating;
        $p2Rating->rating = (int) $p2NewRating;

        $p1Rating->save();
        $p2Rating->save();

        echo "new player ($player1Id) rating: {$p1Rating->rating} old: $p1OldRating\n";
        echo "new player ($player2Id) rating: {$p2Rating->rating} old: $p2OldRating\n";
    }

    private function handleGameTakeBack($from, $data)
    {
        $this->sendToOtherPlayer($from, $data->data->gameId, [
            'type' => 'game',
            'data' => [
                'type' => 'take_back',
                'data' => $data,
            ],
        ]);
    }

    private function handleGameRematch($from, $data)
    {
        if ($data->type === 'newgame') {
            $gameId = $data->gameId;
            $game = &$this->games[$gameId];
            $game['saved'] = false;
            return;
        }
        $this->sendToOtherPlayer($from, $data->data->gameId, [
            'type' => 'game',
            'data' => [
                'type' => 'rematch',
                'data' => $data,
            ],
        ]);
    }

    private function handleGameResign($from, $data)
    {
        $this->sendToOtherPlayer($from, $data->data->gameId, [
            'type' => 'game',
            'data' => [
                'type' => 'resign',
                'data' => [],
            ],
        ]);
    }

    private function handleGameDraw($from, $data)
    {
        $this->sendToOtherPlayer($from, $data->data->gameId, [
            'type' => 'game',
            'data' => [
                'type' => 'draw',
                'data' => $data,
            ],
        ]);
    }

    private function sendToOtherPlayer($from, $gameId, $data)
    {
        $game = $this->games[$gameId];
        $otherPlayerConn = $from->resourceId === $game['player1']['connection']->resourceId ?
                           $game['player2']['connection'] :
                           $game['player1']['connection'];
        $otherPlayerConn->send(json_encode($data));
    }

    private function handleGameMove($from, $data)
    {
        $this->sendToOtherPlayer($from, $data->gameId, [
            'type' => 'game',
            'data' => [
                'type' => 'move',
                'data' => $data,
            ],
        ]);
    }

    private function handleConnect($from, $data)
    {
        $player = [
            'connection' => $from,
            'registred' => $data->registred,
            'userName' => $data->userName,
            'searching' => false,
            'allowedEloDiff' => 50,
            'game' => null,
        ];
        if ($data->registred) {
            $player['userId'] = $data->userId;
        }
        $id = $from->resourceId;
        if (array_key_exists($id, $this->players))
            return;
        $this->players[$from->resourceId] = $player;
        $from->send(json_encode([
            'type' => 'connect',
            'data' => [
                'status' => 'success',
                'playerId' => $id,
            ],
        ]));
    }

    private function handleCustom($from, $data)
    {
        $type = $data->type;
        $data = $data->data;

        switch ($type) {
            case 'create':
                $this->handleCustomCreate($from, $data);
                break;
            case 'join':
                $this->handleCustomJoin($from, $data);
                break;
        }
    }

    private function handleCustomJoin($from, $data)
    {
        $gameId = $data->gameId;
        $id = $from->resourceId;
        $game = &$this->games[$gameId]; //arrays in php are passed to functions by lazy copy, copy-on-write
        $player = &$this->players[$id];
        $player['game'] = $gameId;
        $game['player2'] = $this->players[$id];

        $players = [$game['player1'], $game['player2']];
        shuffle($players);
        $this->sendPlayerReadyGameInfos($players[0], $players[1], 'white', 'custom', $game['gameRules'], $gameId);
        $this->sendPlayerReadyGameInfos($players[1], $players[0], 'black', 'custom', $game['gameRules'], $gameId);
    }

    private function sendPlayerReadyGameInfos($player, $opponent, $color, $type, $gameRules, $gameId)
    {
        $player['connection']->send(json_encode([
            'type' => $type, //custom, find
            'data' => [
                'type' => 'ready',
                'data' => [
                    'color' => $color,
                    'gameRules' => $gameRules,
                    'gameId' => $gameId,
                    'opponent' => [
                        'userName' => $opponent['userName'],
                    ],
                ],
            ],
        ]));
    }

    private function handleCustomCreate($from, $data)
    {
        $id = $from->resourceId;
        $player1 = &$this->players[$id];
        $gameRuleId = $data->gameRuleId;
        $newGameId = $this->newGame($player1, null, $gameRuleId, true);
        $player1['game'] = $newGameId;
        $payLoad = [
            'type' => 'custom',
            'data' => [
                'type' => 'created',
                'data' => [
                    'gameId' => $newGameId,
                ],
            ],
        ];
        $from->send(json_encode($payLoad));
    }

    private function handleFind($from, $data) 
    {
        $type = $data->type;
        switch ($type) {
            case 'new':
                $this->handleFindNew($from, $data->data);
                break;
            case 'waiting':
                $this->handleFindWaiting($from, $data->data);
                break;
            case 'cancel':
                $this->handleFindCancel($from, $data->data);
                break;
        }
    }

    public function handleFindWaiting($from, $data)
    {
        $resourceId = $from->resourceId;
        $player = &$this->players[$resourceId];
        $allowedEloDiff = $player['allowedEloDiff'];
        $userId = $player['userId'];
        $gameRuleId = $data->gameRuleId;
        $gametypeId = Gamerule::find($gameRuleId)->gameType->id;
        $rating = User::find($userId)->rating($gametypeId);
        $pool = &$this->rankedPools[$gameRuleId];

        echo "reminder received from {$from->resourceId}\n"; 
        $foundRating = $this->searchPool($pool, $player, $rating);
        if (!is_null($foundRating)) {
            $player2 = $pool[$foundRating];
            $this->makeGame($player, $player2, $gameRuleId);
            unset($pool[$foundRating]);
            unset($pool[$rating]);
        } else {
            $player['allowedEloDiff'] += 30;
            echo "{$this->players[$from->resourceId]['userName']}\n";
            echo "elo diff: {$this->players[$from->resourceId]['allowedEloDiff']}\n";
            echo "{$this->rankedPools[$gameRuleId][$rating]['userName']}\n";
            echo "elo diff: {$this->rankedPools[$gameRuleId][$rating]['allowedEloDiff']}\n";

            $from->send(json_encode([
                'type' => 'find', //custom, find
                'data' => [
                    'type' => 'wait',
                    'data' => [
                    ],
                ],
            ]));
        }
    }

    public function searchPool(&$pool, $player, $rating)
    {
        $ratings = array_keys($pool);
        $foundRating = null;
        $allowedEloDiff = $player['allowedEloDiff'];
        sort($ratings);
        foreach($ratings as $rat) {
            $player2 = &$pool[$rat];
            $allowedElodiff2 = $player['allowedEloDiff'];
            $diff = abs($rat - $rating);
            if ($rat > $rating && $diff > $allowedEloDiff) {
                break;
            } else if ($diff <= $allowedEloDiff && $diff <= $allowedElodiff2 && $diff !== 0) {
                $foundRating = $rat;
                break;
            }
        }

        return $foundRating;
    }

    public function makeGame(&$player1, &$player2, $gameRuleId)
    {
        $gameId = $this->newGame($player1, $player2, $gameRuleId, true);
        $player1['game'] = $gameId;
        $player2['game'] = $gameId;
        $game = $this->games[$gameId];

        $players = [$player1, $player2];
        shuffle($players);
        $this->sendPlayerReadyGameInfos($players[0], $players[1], 'white', 'find', $game['gameRules'], $gameId);
        $this->sendPlayerReadyGameInfos($players[1], $players[0], 'black', 'find', $game['gameRules'], $gameId);

        $player1['game'] = $gameId;
        $player2['game'] = $gameId;
        $player1['searching'] = false;
        $player2['searching'] = false;
    }

    public function handleFindNew($from, $data)
    {
        $resourceId = $from->resourceId;
        $player = &$this->players[$resourceId];
        $allowedEloDiff = $player['allowedEloDiff'];
        $userId = $player['userId'];
        $gameRuleId = $data->gameRuleId;
        $gametypeId = Gamerule::find($gameRuleId)->gameType->id;
        $rating = User::find($userId)->rating($gametypeId);
        $pool = &$this->rankedPools[$gameRuleId];

        if (array_key_exists($rating, $pool)) {

            $player2 = &$pool[$rating];
            $this->makeGame($player, $player2, $gameRuleId);

            unset($pool[$rating]);

        } else if (!$player['searching']) {
            $pool[$rating] = &$player;
            $player['searching'] = true;
            echo "player {$player['userId']} added to pool\n";
            echo "pool count " . count($this->rankedPools[$gameRuleId]) . "\n";

            $foundRating = $this->searchPool($pool, $player, $rating);
            if (!is_null($foundRating)) {
                $player2 = &$pool[$foundRating];
                $this->makeGame($player, $player2, $gameRuleId);
                unset($pool[$foundRating]);
                unset($pool[$rating]);
            }
            $player['connection']->send(json_encode([
                'type' => 'find', //custom, find
                'data' => [
                    'type' => 'wait',
                    'data' => [
                    ],
                ],
            ]));
        }
    }

    public function handleFindCancel($from, $data)
    {
        $resourceId = $from->resourceId;
        $player = &$this->players[$resourceId];
        $userId = $player['userId'];
        $gameRuleId = $data->gameRuleId;
        $gametypeId = Gamerule::find($gameRuleId)->gameType->id;
        $rating = User::find($userId)->rating($gametypeId);
        $pool = &$this->rankedPools[$gameRuleId];

        if ($player['searching']) {
            $player['searching'] = false;
            unset($pool[$rating]);
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        unset($this->players[$conn->resourceId]);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

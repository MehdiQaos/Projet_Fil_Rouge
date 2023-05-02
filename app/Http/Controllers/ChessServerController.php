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
    private $guestsPools;
    private $gameRules;

    public function __construct()
    {
        $this->gameRules = Gamerule::all();
        // $this->connections = new \SplObjectStorage;
        $this->players = [];
        $this->games = [];
        $this->rankedPools = [];
        foreach ($this->gameRules as $gameRule) {
            $this->rankedPools[$gameRule->id] = [];
        }
        $this->guestsPools = [];
        foreach ($this->gameRules as $gameRule) {
            $this->guestsPools[$gameRule->id] = [];
        }

        // for ($i = 0; $i < count($this->gameRules); $i++) {
        //     $this->pools[]
        // }
        // $this->pools = [];

        echo "listening on port 8090..\n";
        echo "ranked pools count: " . count($this->rankedPools) . "\n";
        echo "guests pools count: " . count($this->guestsPools) . "\n";
    }

    public function onOpen(ConnectionInterface $conn)
    {
        echo "New connection! ({$conn->resourceId})\n";
        // $this->connections->attach($conn);
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
        ];
        $this->games[$gameId] = $game;

        // if (!is_null($player1))
        //     $player1['gameId'] = $gameId;
        // if (!is_null($player2))
        //     $player2['gameId'] = $gameId;

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
        $game = &$this->games[$gameId]; // remove &
        $player1 = $this->players[$from->resourceId];
        $player2 = $game['player1']['connection']->resourceId === $player1['connection']->resourceId?
                   $game['player2']:
                   $game['player1'];

        Game::create([
            'white_player_id' => $player1['userId'],
            'black_player_id' => $player2['userId'],
            'gamerule_id' => $game['gameRuleId'],
            'result' => $result,
            'pgn' => $pgn,
            'date' => now(),
        ]);
        // echo $data->result . "\n" . $data->gameId . "\n";
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

        // $game['player1']['connection']->send(json_encode([
        //     'type' => 'custom',
        //     'data' => [
        //         'type' => 'ready',
        //         'data' => [
        //             'color' => 'white',
        //             'gameRules' => $game['gameRules'],
        //             'opponent' => [
        //                 'userName' => $game['player2']['userName'],
        //             ],
        //         ],
        //     ],
        // ]));

        // $game['player2']['connection']->send(json_encode([
        //     'type' => 'custom',
        //     'data' => [
        //         'type' => 'ready',
        //         'data' => [
        //             'color' => 'black',
        //             'gameRules' => $game['gameRules'],
        //             'opponent' => [
        //                 'userName' => $game['player1']['userName'],
        //             ],
        //         ],
        //     ],
        // ]));
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
        $newGameId = $this->newGame($player1, null, $gameRuleId, false);
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

        // this just old shit not working

        // $playerId = $data->playerId;
        // if (count($this->pool) === 0) {
        //     $this->pool[] = $playerId;
        // } else {
        //     $player1 = $this->players[$playerId];
        //     $player2Id = array_pop($this->pool);
        //     $player2 = $this->players[$player2Id];
        //     $newGameId = $this->newGame($player1, $player2);
        //     $payLoad = [
        //         'type' => 'find',
        //         'data' => [
        //             'gameId' => $newGameId,
        //             'color' => 'white',
        //             'opponent' => $player2Id,
        //         ],
        //     ];
        // }
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

    public function handleClose($conn)
    {

    }

    public function onClose(ConnectionInterface $conn)
    {
        // $this->connections->detach($conn);
        unset($this->players[$conn->resourceId]);
        $this->handleClose($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

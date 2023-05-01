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
            case 'challenge':
                $this->handleChallenge($from, $data);
                break;
            case 'chat':
                $this->handleChat($from, $data);
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
        $game['player2'] = $this->players[$id];

        $game['player1']['connection']->send(json_encode([
            'type' => 'custom',
            'data' => [
                'type' => 'ready',
                'data' => [
                    'color' => 'white',
                    'gameRules' => $game['gameRules'],
                    'opponent' => [
                        'userName' => $game['player2']['userName'],
                    ],
                ],
            ],
        ]));

        $game['player2']['connection']->send(json_encode([
            'type' => 'custom',
            'data' => [
                'type' => 'ready',
                'data' => [
                    'color' => 'black',
                    'gameRules' => $game['gameRules'],
                    'opponent' => [
                        'userName' => $game['player1']['userName'],
                    ],
                ],
            ],
        ]));
    }

    private function handleCustomCreate($from, $data)
    {
        $id = $from->resourceId;
        $player1 = $this->players[$id];
        $gameRuleId = $data->gameRuleId;
        $newGameId = $this->newGame($player1, null, $gameRuleId, false);
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

    private function handleFind($from, $data) // this just old shit not working
    {
        $type = $data->type;
        switch ($type) {
            case 'new':
                $this->handleFindNew($from, $data->data);
                break;
            case 'cancel':
                $this->handleFindCancel($from, $data->data);
                break;
        }
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

    public function handleFindNew($from, $data)
    {
        $diff = 50;
        $userId = $data->userId;
        $gameRuleId = $data->gameRuleId;
        $pool = &$this->rankedPools[$gameRuleId];
        $gametypeId = Gamerule::find($gameRuleId)->gameType->id;
        $rating = User::find($userId)->rating($gametypeId);
        $pool[$userId] = $rating;
        foreach ($pool as $id => $r) {
            if (abs($rating - $r) <= $diff) {

            }
        }
        // if (!array_key_exists($userId, $pool)) {
        //     echo "nope\n";
        //     return;
        // }
        echo "pool count: " . count($pool) . "\n";
        // echo $gametype . "\n";
        // $user = User::find($userId);
        // echo $userId . "\n";
        // echo $user->fullName() . "\n";
        // var_dump($user->with('ratings'));
    }

    public function handleFindCancel($from, $data)
    {
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

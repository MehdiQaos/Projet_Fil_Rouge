<?php

namespace App\Http\Controllers;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class ChessServerController extends Controller implements MessageComponentInterface
{
    protected $connections;
    private $players;
    private $games;
    private $pool;

    public function __construct()
    {
        $this->connections = new \SplObjectStorage;
        $this->players = [];
        $this->games = [];
        $this->pool = [];

        echo "listening on port 8090..\n";
    }

    public function onOpen(ConnectionInterface $conn)
    {
        echo "New connection! ({$conn->resourceId})\n";
        $this->connections->attach($conn);
    }

    private function newGame($player1 = null, $player2 = null, $private = false)
    {
        $gameId = uniqid('game_');
        $game = [
            'player1' => $player1,
            'player2' => $player2,
            'private' => $private,
            'status' => 'waiting',
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
        }
    }

    private function handleGameRematch($from, $data)
    {
        $this->sendToOtherPlayer($from, $data->data->gameId, [
            'type' => 'game',
            'data' => [
                'type' => 'rematch',
                'data' => $data
            ]
        ]);
    }

    private function handleGameResign($from, $data)
    {
        $this->sendToOtherPlayer($from, $data->data->gameId, [
            'type' => 'game',
            'data' => [
                'type' => 'resign',
                'data' => []
            ]
        ]);
    }

    private function handleGameDraw($from, $data)
    {
        $this->sendToOtherPlayer($from, $data->data->gameId, [
            'type' => 'game',
            'data' => [
                'type' => 'draw',
                'data' => $data,
            ]
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
            ]
        ]);
    }

    private function handleConnect($from, $data)
    {
        $id = $from->resourceId;
        $player = [
            'connection' => $from,
            'info' => $data,
        ];
        $this->players[$id] = $player;
        $from->send(json_encode([
            'type' => 'connect',
            'data' => [
                'status' => 'success',
                'id' => $id,
            ]
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
        $game = &$this->games[$gameId]; //arrays in php are passed to functions by lazy copy, copy-on-write
        $game['player2'] = $this->players[$from->resourceId];

        $game['player1']['connection']->send(json_encode([
            'type' => 'custom',
            'data' => [
                'type' => 'ready',
                'data' => [
                    'color' => 'white',
                    'opponent' => $game['player2']['info'],
                ],
            ]
        ]));

        $game['player2']['connection']->send(json_encode([
            'type' => 'custom',
            'data' => [
                'type' => 'ready',
                'data' => [
                    'color' => 'black',
                    'opponent' => $game['player1']['info'],
                ],
            ]
        ]));
    }

    private function handleCustomCreate($from, $data)
    {
        $player1 = $this->players[$from->resourceId];
        $newGameId = $this->newGame($player1, null, true);
        $payLoad = [
            'type' => 'custom',
            'data' => [
                'type' => 'created',
                'data' => [
                    'gameId' => $newGameId,
                ],
            ]
        ];
        $from->send(json_encode($payLoad));
    }

    private function handleFind($from, $data) // this just old shit not working
    {
        $playerId = $data->playerId;
        if (count($this->pool) === 0)
            $this->pool[] = $playerId;
        else {
            $player1 = $this->players[$playerId];
            $player2Id = array_pop($this->pool);
            $player2 = $this->players[$player2Id];
            $newGameId = $this->newGame($player1, $player2);
            $payLoad = [
                'type' => 'find',
                'data' => [
                    'gameId' => $newGameId,
                    'color' => 'white',
                    'opponent' => $player2Id,
                ],
            ];
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->connections->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

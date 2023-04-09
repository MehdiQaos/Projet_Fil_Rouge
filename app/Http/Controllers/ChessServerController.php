<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request; //TODO: remove this
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
        echo "new message\n";
        $msg = json_decode($msg);
        $data = $msg->data;
        switch ($msg->type) {
            case 'playerInfo':
                $player = [
                    'connection' => $from,
                    'info' => $data,
                ];
                $this->players[$from->resourceId] = $player; //send player id to client?
                break;
            case 'create':
                $player1 = $this->players[$from->resourceId];
                $newGameId = $this->newGame($player1, null, true);
                $payLoad = [
                    'type' => 'gameCreated',
                    'data' => [
                        'gameId' => $newGameId,
                    ],
                ];
                $from->send(json_encode($payLoad));
                break;
            case 'join':
                $this->handleJoin($from, $data);
                // $gameId = $data->gameId;
                // $game = &$this->games[$gameId]; //arrays in php lazy copy, copy-on-write
                // $game['player2'] = $this->players[$from->resourceId];

                // $game['player1']['connection']->send(json_encode([
                //     'type' => 'gameStarted',
                //     'data' => [
                //         'color' => 'white',
                //         'opponent' => $game['player2']['info'],
                //     ],
                // ]));

                // $game['player2']['connection']->send(json_encode([
                //     'type' => 'gameStarted',
                //     'data' => [
                //         'color' => 'black',
                //         'opponent' => $game['player1']['info'],
                //     ],
                // ]));
                break;
            case 'find':
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
                break;
            case 'move':
                $gameId = $data->gameId;
                $game = $this->games[$gameId];
                $otherPlayerConn = $game['player1']['connection']->resourceId === $from->resourceId ?
                    $game['player2']['connection'] :
                    $game['player1']['connection'];
                $otherPlayerConn->send(json_encode([
                    'type' => 'move',
                    'data' => $data,
                ]));
                break;
        }
    }

    private function handleJoin($from, $data)
    {
        $gameId = $data->gameId;
        $game = &$this->games[$gameId]; //arrays in php lazy copy, copy-on-write
        $game['player2'] = $this->players[$from->resourceId];

        $game['player1']['connection']->send(json_encode([
            'type' => 'gameStarted',
            'data' => [
                'color' => 'white',
                'opponent' => $game['player2']['info'],
            ],
        ]));

        $game['player2']['connection']->send(json_encode([
            'type' => 'gameStarted',
            'data' => [
                'color' => 'black',
                'opponent' => $game['player1']['info'],
            ],
        ]));
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

<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class ChessServerController extends Controller implements MessageComponentInterface
{
    protected $clients;
    public $piqs;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->piqs = [];

        echo "listening on port 8090..\n";
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        // $file = fopen("./ratchetchessserver.txt", "w");
        // fwrite($file, serialize($conn));
        // fclose($file);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg);
        var_dump($data);
        switch ($data->type) {
            case 'game':
                if (count($this->piqs) < 2)
                    $this->piqs[] = $from;
                if (count($this->piqs) == 2) {
                    $this->makeGame();
                }
                break;
            case 'move':
                $payLoad = [
                    'type' => 'move',
                    'data' => $data->data,
                ];
                foreach ($this->piqs as $piq) {
                    if ($piq !== $from) {
                        $piq->send(json_encode($payLoad));
                    }
                }
                break;
        }
        // echo "$from->resourceId: $msg";
        // foreach ($this->clients as $client) {
        //     if ($from !== $client) {
        //         $client->send($msg);
        //     }
        // }
    }

    private function makeGame()
    {
        $payLoad = [
            'type' => 'game',
            'data' => [
                'name' => 'player1',
                'color' => 'white',
                'isTurn' => true,
            ]
        ];
        $this->piqs[0]->send(json_encode($payLoad));
        $payLoad = [
            'type' => 'game',
            'data' => [
                'name' => 'player2',
                'color' => 'black',
                'isTurn' => false,
            ]
        ];
        $this->piqs[1]->send(json_encode($payLoad));
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

<?php

namespace App\Traits;

use App\Models\Branch;
use App\Models\BranchToConfigNumbering;
use App\Models\ConfigNumbering;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;
use ElephantIO\Engine\SocketIO\Version2X;


trait Artillery
{
    public function Broadcast($data)
    {
        $client = new Client(new Version2X('//172.104.175.180:3000', [
            'headers' => [
                'X-My-Header: websocket rocks',
                'Authorization: Bearer 12b3c4d5e6f7g8h9i'
            ]
        ]));

        $client->initialize();
        $client->emit('broadcast', $data);
        $client->close();
    }
}

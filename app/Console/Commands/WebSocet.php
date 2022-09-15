<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Helpers\WebSocetRun;

class WebSocet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocet:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Комманда для создания вебокета';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new  WebSocetRun()
                )
            ),
            8080
        );

        $server->run();
    }
}

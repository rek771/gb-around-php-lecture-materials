<?php
require_once __DIR__ . '/vendor/autoload.php';

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;

$client = new Client([
    'host' => 'localhost',
    'port' => 5672,
    'user' => 'guest',
    'pass' => 'guest',
    'vhost' => '/',
]);

$client->connect();

$channel = $client->channel();

$channel->queueDeclare('hello', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$channel->consume(
    function (Message $message, Channel $channel, Client $client) {
        echo "[x] Received ", $message->content, "\n";
        $channel->ack($message);
    },
    'hello'
);

while ($channel->callbacks) {
    $channel->wait();
}

$channel->close();
$client->disconnect();

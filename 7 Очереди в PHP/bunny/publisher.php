<?php
require_once __DIR__ . '/vendor/autoload.php';

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

$msg = new Message('Hello World!');
$channel->publish($msg, '', 'hello');

echo "[x] Sent 'Hello World!'\n";

$channel->close();

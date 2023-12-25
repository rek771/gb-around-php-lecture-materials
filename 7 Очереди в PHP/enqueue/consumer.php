<?php
require_once __DIR__ . '/vendor/autoload.php';

use Enqueue\AmqpBunny\AmqpConnectionFactory;
use Enqueue\AmqpBunny\AmqpContext;
use Enqueue\AmqpBunny\AmqpConsumer;

$factory = new AmqpConnectionFactory([
    'host' => 'localhost',
    'port' => 5672,
    'user' => 'guest',
    'pass' => 'guest',
    'vhost' => '/',
]);

$context = $factory->createContext();
$queue = $context->createQueue('hello');
$context->declareQueue($queue);

$consumer = $context->createConsumer($queue);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

while (true) {
    $message = $consumer->receive();

    if ($message) {
        echo "[x] Received ", $message->getBody(), "\n";
        $consumer->acknowledge($message);
    }
}

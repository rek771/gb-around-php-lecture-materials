<?php
require_once __DIR__ . '/vendor/autoload.php';

use Enqueue\AmqpBunny\AmqpConnectionFactory;
use Enqueue\AmqpBunny\AmqpContext;
use Enqueue\AmqpBunny\AmqpProducer;

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

$producer = new AmqpProducer($context);
$producer->send($queue, $context->createMessage('Hello World!'));

echo "[x] Sent 'Hello World!'\n";

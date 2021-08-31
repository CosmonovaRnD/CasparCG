# CasparCG PHP Library
Is an implementation of CasparCG 2.0 AMCP Protocol and OSC Protocol

Requirements
-----
 - CasparCG v2.0.7|v2.3.0
 - PHP 7.0
 
Installation
---

Install using Composer

> php composer.phar require cosmonova-rnd/caspar-cg

Usage
---

#### AMCP

The easiest way to use AMCP protocol is to send handwritten command through Caspar CG connection

```php
$client = new \CosmonovaRnD\CasparCG\Client();

$response = $client->send('play 1-1 test');

if($response->success()) {
    echo 'OK';
} else {
    echo 'Failed';
}
```

But you can use one of existing command builders.

For example, we want to send play content 'test' on channel 1 and layer 10 in loop

```php
$client = new \CosmonovaRnD\CasparCG\Client();

$playCmdBuilder = new \CosmonovaRnD\CasparCG\Command\Basic\Builder\PlayBuilder();
$playCmdBuilder->channel(1);
$playCmdBuilder->layer(10);
$playCmdBuilder->clip('test');
$playCmdBuilder->loop();

$response = $client->send($playCmdBuilder->build());

if($response->success()) {
    echo 'OK';
} else {
    echo 'Failed';
}
```

#### OSC

OSC works over the UDP protocol.

I'll try to show how to catch messages in small simple example

```php

$server = new \CosmonovaRnD\CasparCG\Server('127.0.0.1', 6250);
$server->start();

$parser     = new \CosmonovaRnD\CasparCG\OSC\Parser();

// You can use simple built-in event manager to handle messages
$eventManager = new \CosmonovaRnD\CasparCG\EventManager();

$listener = new MyTestFrameMsgListener(); // Must implement \CosmonovaRnD\CasparCG\ListenerInterface

// Listen all \CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg\Frame messages
$eventManager->listen(\CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg\Frame::class, $listener);

while (false !== $msg = $server->read()) {
    $rawMsg = $parser->parse($msg);

    if ($rawMsg instanceof Bundle) {
        foreach ($rawMsg->getMessages() as $bundleMsg) {
            \CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg\Frame::create($bundleMsg, $eventManager);
        }
    } else {
        \CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg\Frame::create($rawMsg, $eventManager);
    }
}

$server->stop();

```
 

 



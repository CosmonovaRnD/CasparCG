<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG;

use CosmonovaRnD\CasparCG\OSC\Message\MessageInterface;

/**
 * Class EventManager
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG
 * Cosmonova | Research & Development
 */
class EventManager
{
    /** @var array */
    private $listeners = [];

    /**
     * @param string            $event    event name (Message class name)
     * @param ListenerInterface $listener Listener object
     */
    public function listen(string $event, ListenerInterface $listener)
    {
        $this->listeners[$event][] = $listener;
    }

    /**
     * Dispatch event
     *
     * @param string           $event   Event name (Message class name)
     * @param MessageInterface $message Message object
     */
    public function dispatch(string $event, MessageInterface $message)
    {
        /** @var ListenerInterface[] $listeners */
        $listeners = $this->listeners[$event] ?? [];

        foreach ($listeners as $listener) {
            $listener->handleMessage($message);
        }
    }
}

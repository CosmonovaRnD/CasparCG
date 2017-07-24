<?php

namespace CosmonovaRnD\CasparCG\OSC\Message\Channel;

use CosmonovaRnD\CasparCG\EventManager;
use CosmonovaRnD\CasparCG\OSC\Message\Channel;
use CosmonovaRnD\CasparCG\OSC\RawMessage;

/**
 * Class OutputPort
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Channel
 * Cosmonova | Research & Development
 */
abstract class OutputPort extends Channel
{
    /** @var int */
    protected $port;

    /**
     * @inheritDoc
     */
    public function __construct(int $channel, int $port)
    {
        $this->port = $port;

        parent::__construct($channel);
    }

    /**
     * @inheritdoc
     */
    public static function create(RawMessage $message, EventManager $eventManager = null)
    {
        preg_match(static::$pattern, $message->getAddress(), $matches);

        if (isset($matches[0], $matches[1], $matches[2])) {
            $newMessage = new static((int)$matches[1], (int)$matches[2], $message->getArguments());

            if ($eventManager) {
                $newMessage->setEventManager($eventManager);
                $newMessage->dispatch();
            }

            return $newMessage;
        }

        return null;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }
}

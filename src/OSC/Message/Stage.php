<?php

namespace CosmonovaRnD\CasparCG\OSC\Message;

use CosmonovaRnD\CasparCG\EventManager;
use CosmonovaRnD\CasparCG\OSC\RawMessage;

/**
 * Class Stage
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message
 * Cosmonova | Research & Development
 */
abstract class Stage extends Channel
{
    /** @var int */
    protected $layer;

    /**
     * @inheritDoc
     */
    public function __construct(int $channel, int $layer)
    {
        $this->layer = $layer;

        parent::__construct($channel);
    }

    /**
     * @inheritdoc
     */
    public static function create(RawMessage $message, EventManager $eventManager = null)
    {
        preg_match(static::$pattern, $message->getAddress(), $matches);

        if (isset($matches[0], $matches[1], $matches[2])) {
            $newMessage = new static((int)$matches[1][0], (int)$matches[2][0], $message->getArguments());
            $newMessage->setEventManager($eventManager);
            $newMessage->dispatch();
        }

        return null;
    }

    /**
     * Layer
     *
     * @return int
     */
    public function getLayer(): int
    {
        return $this->layer;
    }
}

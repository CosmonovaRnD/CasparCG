<?php

namespace CosmonovaRnD\CasparCG\OSC\Message;

use CosmonovaRnD\CasparCG\EventManager;
use CosmonovaRnD\CasparCG\OSC\RawMessage;

/**
 * Class Channel
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message
 * Cosmonova | Research & Development
 */
abstract class Channel extends AbstractMessage
{
    /** @var int */
    protected $channel;

    /**
     * @inheritDoc
     */
    public function __construct(int $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @inheritDoc
     */
    public static function create(RawMessage $message, EventManager $eventManager = null)
    {
        preg_match(static::$pattern, $message->getAddress(), $matches);

        if (isset($matches[0], $matches[1])) {
            $newMsg = new static((int)$matches[1], $message->getArguments());

            if ($eventManager) {
                $newMsg->setEventManager($eventManager);
                $newMsg->dispatch();
            }

            return $newMsg;
        }

        return null;
    }

    /**
     * @return int
     */
    public function getChannel(): int
    {
        return $this->channel;
    }
}

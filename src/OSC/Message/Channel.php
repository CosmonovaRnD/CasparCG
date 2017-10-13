<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message;

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
    public static function create(RawMessage $message)
    {
        preg_match(static::$pattern, $message->getAddress(), $matches);

        if (isset($matches[0], $matches[1])) {
            $newMsg = new static();
            $newMsg->setChannel($matches[1]);
            $newMsg->parseArguments($message);

            return $newMsg;
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getChannel(): ?int
    {
        return $this->channel;
    }

    /**
     * @param int $channel
     */
    public function setChannel(int $channel)
    {
        $this->channel = $channel;
    }
}

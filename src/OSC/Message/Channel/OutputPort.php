<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Channel;

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
     * @inheritdoc
     */
    public static function create(RawMessage $message)
    {
        preg_match(static::$pattern, $message->getAddress(), $matches);

        if (isset($matches[0], $matches[1], $matches[2])) {
            $newMessage = new static();
            $newMessage->setChannel((int)$matches[1]);
            $newMessage->setPort((int)$matches[2]);
            $newMessage->parseArguments($message);

            return $newMessage;
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getPort(): ?int
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port)
    {
        $this->port = $port;
    }
}

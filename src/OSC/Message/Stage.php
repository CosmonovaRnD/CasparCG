<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message;

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
     * @inheritdoc
     */
    public static function create(RawMessage $message)
    {
        preg_match(static::$pattern, $message->getAddress(), $matches);

        if (isset($matches[0], $matches[1], $matches[2])) {
            $newMessage = new static();
            $newMessage->setChannel((int)$matches[1]);
            $newMessage->setLayer((int)$matches[2]);
            $newMessage->parseArguments($message);

            return $newMessage;
        }

        return null;
    }

    /**
     * Layer
     *
     * @return int|null
     */
    public function getLayer()
    {
        return $this->layer;
    }

    /**
     * @param int $layer
     */
    public function setLayer(int $layer)
    {
        $this->layer = $layer;
    }
}

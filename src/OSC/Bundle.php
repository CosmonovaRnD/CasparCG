<?php

namespace CosmonovaRnD\CasparCG\OSC;

/**
 * Class Bundle
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC
 * Cosmonova | Research & Development
 */
class Bundle
{
    /** @var int */
    private $time;

    /** @var RawMessage[] */
    private $messages = [];

    /**
     * @inheritDoc
     */
    public function __construct(int $time)
    {
        $this->time = $time;
    }

    /**
     * Add new message
     *
     * @param RawMessage $message
     */
    public function addMessage(RawMessage $message)
    {
        $this->messages[] = $message;
    }

    /**
     * Remove message from bundle
     *
     * @param RawMessage $message
     */
    public function removeMessage(RawMessage $message)
    {
        $key = array_search($message, $this->messages);

        if (false !== $key) {
            unset($this->messages[$key]);
        }
    }

    /**
     * Get time with fraction part in 64bit representation,
     * where first 32bit is seconds sinse 01.01.1970 00:00:00
     * and next 32bit is fraction parts of second
     *
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * Return bundle messages
     *
     * @return RawMessage[]
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Return object as array
     *
     * @return array
     */
    public function toArray()
    {
        $messages = [];

        foreach ($this->messages as $message) {
            $messages[] = $message->toArray();
        }

        return [
            'time'     => $this->time,
            'messages' => $messages
        ];
    }
}

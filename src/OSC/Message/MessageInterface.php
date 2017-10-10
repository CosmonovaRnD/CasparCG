<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message;

use CosmonovaRnD\CasparCG\EventManager;
use CosmonovaRnD\CasparCG\OSC\RawMessage;

/**
 * Interface MessageInterface
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message
 * Cosmonova | Research & Development
 */
interface MessageInterface
{
    /**
     * Create Message model from raw object data
     *
     * @param RawMessage   $message
     * @param EventManager $eventManager
     *
     * @return $this
     */
    public static function create(RawMessage $message, EventManager $eventManager = null);

    /**
     * Set event manager
     *
     * @param EventManager $eventManager
     */
    public function setEventManager(EventManager $eventManager);

    /**
     * Get event manager
     *
     * @return EventManager
     */
    public function getEventManager(): EventManager;

    /**
     * Dispatch event
     *
     * @return mixed
     */
    public function dispatch();
}

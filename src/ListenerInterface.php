<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG;

use CosmonovaRnD\CasparCG\OSC\Message\MessageInterface;

/**
 * Interface ListenerInterface
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG
 * Cosmonova | Research & Development
 */
interface ListenerInterface
{
    /**
     * @param MessageInterface $message
     */
    public function handleMessage(MessageInterface $message);
}

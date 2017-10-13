<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Channel;

use CosmonovaRnD\CasparCG\OSC\RawMessage;

/**
 * Class OutputFrameType
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Channel
 * Cosmonova | Research & Development
 */
class OutputFrameType extends OutputPort
{
    /** @var string */
    protected $value;

    public static $pattern = '#^/channel/(\d+)/output/port/(\d+)/type\x00*$#';

    /**
     * @inheritDoc
     */
    public function parseArguments(RawMessage $message)
    {
        $data        = $message->getArguments();
        $this->value = isset($data[0]) ? rtrim($data[0], "\0") : '';
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
}

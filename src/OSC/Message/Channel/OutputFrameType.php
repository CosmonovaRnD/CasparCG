<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Channel;

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
    public function __construct(int $channel, int $port, array $data)
    {
        $this->value = (string)rtrim($data[0], "\0") ?? '';

        parent::__construct($channel, $port);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}

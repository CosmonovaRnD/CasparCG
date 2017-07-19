<?php

namespace CosmonovaRnD\CasparCG\OSC\Message\Stage;

use CosmonovaRnD\CasparCG\OSC\Message\Stage;

/**
 * Class Time
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Stage
 * Cosmonova | Research & Development
 */
class Time extends Stage
{
    /** @var  float */
    protected $value;

    public static $pattern = '#^/channel/(\d+)/stage/layer/(\d+)/time\x00*$#';

    /**
     * @inheritDoc
     */
    public function __construct(int $channel, int $layer, array $data)
    {
        $this->value = (float)$data[0] ?? (float)0;

        parent::__construct($channel, $layer);
    }

    /**
     * Seconds the layer has been active
     *
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }
}

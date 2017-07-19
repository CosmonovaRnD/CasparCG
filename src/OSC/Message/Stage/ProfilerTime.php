<?php

namespace CosmonovaRnD\CasparCG\OSC\Message\Stage;

use CosmonovaRnD\CasparCG\OSC\Message\Stage;

/**
 * Class ProfilerTime
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Stage
 * Cosmonova | Research & Development
 */
class ProfilerTime extends Stage
{
    /** @var float */
    protected $actual;
    /** @var float */
    protected $expected;

    public static $pattern = '#^/channel/(\d+)/stage/layer/(\d+)/profiler/time\x00*$#';

    /**
     * @inheritDoc
     */
    public function __construct(int $channel, int $layer, array $data)
    {
        $this->actual   = (float)$data[0] ?? (float)0;
        $this->expected = (float)$data[1] ?? (float)0;

        parent::__construct($channel, $layer);
    }

    /**
     * Actual time on frame
     *
     * @return float
     */
    public function getActual(): float
    {
        return $this->actual;
    }

    /**
     * Expected time on frame
     *
     * @return float
     */
    public function getExpected(): float
    {
        return $this->expected;
    }
}

<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Channel;

use CosmonovaRnD\CasparCG\OSC\Message\Channel;

/**
 * Class ProfilerTime
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Channel
 * Cosmonova | Research & Development
 */
class ProfilerTime extends Channel
{
    /** @var float */
    protected $actual;
    /** @var float */
    protected $expected;

    public static $pattern = '#^/channel/(\d+)/profiler/time\x00*$#';

    /**
     * @inheritDoc
     */
    public function __construct($channel, array $data)
    {
        $this->actual   = (float)$data[0] ?? (float)0;
        $this->expected = (float)$data[1] ?? (float)0;

        parent::__construct($channel);
    }

    /**
     * @return float
     */
    public function getActual(): float
    {
        return $this->actual;
    }

    /**
     * @return float
     */
    public function getExpected(): float
    {
        return $this->expected;
    }

}

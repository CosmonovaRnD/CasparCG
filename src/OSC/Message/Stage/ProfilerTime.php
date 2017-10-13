<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Stage;

use CosmonovaRnD\CasparCG\OSC\Message\Stage;
use CosmonovaRnD\CasparCG\OSC\RawMessage;

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
    public function parseArguments(RawMessage $message)
    {
        $data           = $message->getArguments();
        $this->actual   = (float)($data[0] ?? 0);
        $this->expected = (float)($data[1] ?? 0);
    }

    /**
     * Actual time on frame
     *
     * @return float|null
     */
    public function getActual(): ?float
    {
        return $this->actual;
    }

    /**
     * Expected time on frame
     *
     * @return float|null
     */
    public function getExpected(): ?float
    {
        return $this->expected;
    }
}

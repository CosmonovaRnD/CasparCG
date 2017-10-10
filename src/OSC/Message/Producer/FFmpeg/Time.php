<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg;

use CosmonovaRnD\CasparCG\OSC\Message\Stage;

/**
 * Class ProfilerTime
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg
 * Cosmonova | Research & Development
 */
class Time extends Stage
{
    /** @var  float */
    protected $elapsed;
    /** @var  float */
    protected $total;

    public static $pattern = '#^/channel/(\d+)/stage/layer/(\d+)/file/time\x00*$#';

    /**
     * @inheritDoc
     */
    public function __construct(int $channel, int $layer, array $data)
    {
        $this->elapsed = (float)$data[0] ?? (float)0;
        $this->total   = (float)$data[1] ?? (float)0;

        parent::__construct($channel, $layer);
    }

    /**
     * Seconds elapsed on file playback
     *
     * @return float
     */
    public function getElapsed(): float
    {
        return $this->elapsed;
    }

    /**
     * Total Seconds
     *
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

}

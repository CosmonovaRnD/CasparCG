<?php

namespace CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg;

use CosmonovaRnD\CasparCG\OSC\Message\Stage;

/**
 * Class Frame
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg
 * Cosmonova | Research & Development
 */
class Frame extends Stage
{
    /** @var  int */
    protected $elapsed;
    /** @var  int */
    protected $total;

    public static $pattern = '#^/channel/(\d+)/stage/layer/(\d+)/file/frame\x00*$#';

    /**
     * @inheritDoc
     */
    public function __construct(int $channel, int $layer, array $data)
    {
        $this->elapsed = (int)$data[0] ?? 0;
        $this->total   = (int)$data[1] ?? 0;

        parent::__construct($channel, $layer);
    }

    /**
     * Frames elapsed on file playback
     *
     * @return int
     */
    public function getElapsed(): int
    {
        return $this->elapsed;
    }

    /**
     * Total frames
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }
}

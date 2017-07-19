<?php

namespace CosmonovaRnD\CasparCG\OSC\Message\Mixer;

use CosmonovaRnD\CasparCG\OSC\Message\Channel;

/**
 * Class AudioDbFS
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Mixer
 * Cosmonova | Research & Development
 */
class AudioDbFS extends Channel
{
    /** @var  int */
    protected $nbChannel;
    /** @var  float */
    protected $level;

    public static $pattern = '#^/channel/(\d+)/mixer/audio/(\d+)/dBFS\x00*$#';

    /**
     * @inheritDoc
     */
    public function __construct(int $channel, int $nbChannel, array $data)
    {
        $this->nbChannel = $nbChannel;
        $this->level     = (float)$data[0] ?? (float)0;

        parent::__construct($channel);
    }

    /**
     * Audio channel number
     *
     * @return int
     */
    public function getNbChannel(): int
    {
        return $this->nbChannel;
    }

    /**
     * Audio level in dBFS
     *
     * @return float
     */
    public function getLevel(): float
    {
        return $this->level;
    }
}

<?php

namespace CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg;

use CosmonovaRnD\CasparCG\OSC\Message\Stage;

/**
 * Class Loop
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg
 * Cosmonova | Research & Development
 */
class Loop extends Stage
{
    /** @var  bool */
    protected $value;

    public static $pattern = '#^/channel/(\d+)/stage/layer/(\d+)/loop\x00*$#';

    /**
     * @inheritDoc
     */
    public function __construct(int $channel, int $layer, array $data)
    {
        $this->value = (bool)$data[0] ?? false;

        parent::__construct($channel, $layer);
    }

    /**
     * Whether the file is set to loop playback or not, only applies to ffmpeg inputs of type file not stream or device.
     *
     * @return bool
     */
    public function getValue(): bool
    {
        return $this->value;
    }
}

<?php

namespace CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg;

use CosmonovaRnD\CasparCG\OSC\Message\Stage;

/**
 * Class VideoCodec
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg
 * Cosmonova | Research & Development
 */
class VideoCodec extends Stage
{
    /** @var  string */
    protected $value;

    public static $pattern = '#^/channel/(\d+)/stage/layer/(\d+)/file/video/codec\x00*$#';

    /**
     * @inheritDoc
     */
    public function __construct(int $channel, int $layer, array $data)
    {
        $this->value = (string)$data[0] ?? (string)'undefined codec';

        parent::__construct($channel, $layer);
    }

    /**
     * Codec of the video file
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}

<?php

namespace CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg;

use CosmonovaRnD\CasparCG\OSC\Message\Stage;

/**
 * Class VideoField
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg
 * Cosmonova | Research & Development
 */
class VideoField extends Stage
{
    /** @var  string */
    protected $value;

    public static $pattern = '#^/channel/(\d+)/stage/layer/(\d+)/file/video/field\x00*$#';

    /**
     * @inheritDoc
     */
    public function __construct(int $channel, int $layer, array $data)
    {
        $this->value = (string)$data[0] ?? (string)'undefined type';

        parent::__construct($channel, $layer);
    }

    /**
     * Scan type of the video file, progressive or interlaced
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}

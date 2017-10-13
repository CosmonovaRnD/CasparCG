<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg;

use CosmonovaRnD\CasparCG\OSC\Message\Stage;
use CosmonovaRnD\CasparCG\OSC\RawMessage;

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
    public function parseArguments(RawMessage $message)
    {
        $data        = $message->getArguments();
        $this->value = (bool)($data[0] ?? false);
    }

    /**
     * Whether the file is set to loop playback or not, only applies to ffmpeg inputs of type file not stream or device.
     *
     * @return bool|null
     */
    public function getValue(): ?bool
    {
        return $this->value;
    }
}

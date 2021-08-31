<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg;

use CosmonovaRnD\CasparCG\OSC\Message\Stage;
use CosmonovaRnD\CasparCG\OSC\RawMessage;

/**
 * Class AudioSampleRate
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg
 * Cosmonova | Research & Development
 */
class AudioSampleRate extends Stage
{
    /** @var  int */
    protected $value;

    public static $pattern = '#^/channel/(\d+)/stage/layer/(\d+)/file/audio/sample-rate\x00*$#';

    /**
     * @inheritDoc
     */
    public function parseArguments(RawMessage $message)
    {
        $data        = $message->getArguments();
        $this->value = (int)($data[0] ?? 0);
    }

    /**
     * Audio sample rate of this files audio track
     *
     * @return int|null
     */
    public function getValue()
    {
        return $this->value;
    }
}

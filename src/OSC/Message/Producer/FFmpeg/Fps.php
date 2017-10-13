<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg;

use CosmonovaRnD\CasparCG\OSC\Message\Stage;
use CosmonovaRnD\CasparCG\OSC\RawMessage;

/**
 * Class Fps
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg
 * Cosmonova | Research & Development
 */
class Fps extends Stage
{
    /** @var  float */
    protected $value;

    public static $pattern = '#^/channel/(\d+)/stage/layer/(\d+)/file/fps\x00*$#';

    /**
     * @inheritDoc
     */
    public function parseArguments(RawMessage $message)
    {
        $data        = $message->getArguments();
        $this->value = (float)($data[0] ?? 0);
    }

    /**
     * FPS of the file being played
     *
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }
}

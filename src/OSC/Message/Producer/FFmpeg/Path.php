<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg;

use CosmonovaRnD\CasparCG\OSC\Message\Stage;
use CosmonovaRnD\CasparCG\OSC\RawMessage;

/**
 * Class Path
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Producer\FFmpeg
 * Cosmonova | Research & Development
 */
class Path extends Stage
{
    /** @var  string */
    protected $value;

    public static $pattern = '#^/channel/(\d+)/stage/layer/(\d+)/file/path\x00*$#';

    /**
     * @inheritDoc
     */
    public function parseArguments(RawMessage $message)
    {
        $data        = $message->getArguments();
        $this->value = isset($data[0]) ? rtrim($data[0], "\0") : 'undefined path';
    }

    /**
     * Filename and path (if file is in a sub-folder) of the media file, paths relative to the media folder
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }
}

<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Mixer;

use CosmonovaRnD\CasparCG\OSC\Message\Channel;
use CosmonovaRnD\CasparCG\OSC\RawMessage;

/**
 * Class AudioNbChannels
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Mixer
 * Cosmonova | Research & Development
 */
class AudioNbChannels extends Channel
{
    /** @var int */
    protected $value;

    public static $pattern = '#^/channel/(\d+)/mixer/audio/nb_channels\x00*$#';

    /**
     * @inheritDoc
     */
    public function parseArguments(RawMessage $message)
    {
        $data        = $message->getArguments();
        $this->value = (int)($data[0] ?? 0);
    }

    /**
     * Number of audio channels in use on this CasparCG channel
     *
     * @return int|null
     */
    public function getValue()
    {
        return $this->value;
    }
}

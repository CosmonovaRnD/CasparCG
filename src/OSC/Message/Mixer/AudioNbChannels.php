<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Mixer;

use CosmonovaRnD\CasparCG\OSC\Message\Channel;

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
    public function __construct(int $channel, array $data)
    {
        $this->value = (int)$data[0] ?? 0;

        parent::__construct($channel);
    }

    /**
     * Number of audio channels in use on this CasparCG channel
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}

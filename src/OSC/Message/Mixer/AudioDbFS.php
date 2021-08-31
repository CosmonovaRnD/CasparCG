<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Mixer;

use CosmonovaRnD\CasparCG\OSC\Message\Channel;
use CosmonovaRnD\CasparCG\OSC\RawMessage;

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
    public static function create(RawMessage $message)
    {
        preg_match(static::$pattern, $message->getAddress(), $matches);

        if (isset($matches[0], $matches[1])) {
            $newMsg = new static();
            $newMsg->setChannel($matches[1]);
            $newMsg->setNbChannel($matches[2]);
            $newMsg->parseArguments($message);

            return $newMsg;
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function parseArguments(RawMessage $message)
    {
        $data        = $message->getArguments();
        $this->level = (float)($data[0] ?? 0);
    }

    /**
     * @param int $nbChannel
     */
    public function setNbChannel(int $nbChannel)
    {
        $this->nbChannel = $nbChannel;
    }

    /**
     * Audio channel number
     *
     * @return int|null
     */
    public function getNbChannel()
    {
        return $this->nbChannel;
    }

    /**
     * Audio level in dBFS
     *
     * @return float|null
     */
    public function getLevel()
    {
        return $this->level;
    }
}

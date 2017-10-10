<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;

use CosmonovaRnD\CasparCG\Command\BaseBuilderInterface;
use CosmonovaRnD\CasparCG\Command\CommandBuilderInterface;
use CosmonovaRnD\CasparCG\Exception\ParamException;
use CosmonovaRnD\CasparCG\Exception\ParseException;

/**
 * Class MasterVolumeBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_MASTERVOLUME
 */
class MasterVolumeBuilder implements BaseBuilderInterface, CommandBuilderInterface
{
    /** @var  int */
    protected $channel;
    /** @var  float */
    protected $volume;

    /**
     * @param int $channel
     *
     * @return BaseBuilderInterface
     * @throws ParamException
     */
    public function channel(int $channel): BaseBuilderInterface
    {
        if ($channel < 0) {
            throw new ParamException('Channel must be unsigned integer value');
        }

        $this->channel = $channel;

        return $this;
    }

    /**
     * Set volume level
     *
     * @param float $level Volume level (from 0 to 1)
     *
     * @return MasterVolumeBuilder
     * @throws ParamException
     */
    public function volume(float $level): MasterVolumeBuilder
    {
        if ($level < 0 || $level > 1) {
            throw new ParamException('Volume level must be in rage from 0 to 1');
        }

        $this->volume = $level;

        return $this;
    }

    /**
     * @return string
     * @throws ParseException
     */
    protected function buildChannel(): string
    {
        if (null === $this->channel) {
            throw new ParseException('Channel param is required. Use channel() method for this');
        }

        return (string)$this->channel;
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $channel = $this->buildChannel();

        return "MIXER $channel MASTERVOLUME {$this->volume}";
    }
}

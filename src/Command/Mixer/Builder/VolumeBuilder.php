<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;

use CosmonovaRnD\CasparCG\Command\Basic\Builder\BaseBuilder;
use CosmonovaRnD\CasparCG\Command\Tween;
use CosmonovaRnD\CasparCG\Exception\ParamException;

/**
 * Class VolumeBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_VOLUME
 */
class VolumeBuilder extends BaseBuilder
{
    /** @var float */
    protected $volume;
    /** @var int */
    protected $duration = 0;
    /** @var string */
    protected $animation = 'linear';

    /**
     * Set contrast value
     *
     * @param float $level Volume level value (from 0 to 1)
     *
     * @return VolumeBuilder
     * @throws ParamException
     */
    public function volume(float $level): VolumeBuilder
    {
        if ($level < 0 || $level > 1) {
            throw new ParamException('Level value must be in range from 0 to 1');
        }

        $this->volume = $level;

        return $this;
    }

    /**
     * Set animation duration
     *
     * @param int $value
     *
     * @return VolumeBuilder
     * @throws ParamException
     */
    public function duration(int $value): VolumeBuilder
    {
        if ($value < 0) {
            throw new ParamException('Value must be unsigned integer');
        }

        $this->duration = $value;

        return $this;
    }

    /**
     * Set animation type
     *
     * @param string $type
     *
     * @return VolumeBuilder
     * @throws ParamException
     */
    public function animation(string $type): VolumeBuilder
    {
        if (!in_array($type, Tween::animationTypes())) {
            throw new ParamException("Unsupported animation type `$type`");
        }

        $this->animation = $type;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $channelAndLayer = $this->buildChannel();

        $tail = '';

        if (null !== $this->volume) {
            $tail = "{$this->volume} {$this->duration} {$this->animation}";
        }

        return "MIXER $channelAndLayer VOLUME $tail";
    }
}

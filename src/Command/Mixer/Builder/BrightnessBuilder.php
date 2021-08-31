<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;

use CosmonovaRnD\CasparCG\Command\Basic\Builder\BaseBuilder;
use CosmonovaRnD\CasparCG\Command\Tween;
use CosmonovaRnD\CasparCG\Exception\ParamException;

/**
 * Class BrightnessBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_BRIGHTNESS
 */
class BrightnessBuilder extends BaseBuilder
{
    /** @var float */
    protected $brightness;
    /** @var int */
    protected $duration = 0;
    /** @var string */
    protected $animation = 'linear';

    /**
     * Set brightness value
     *
     * @param float $value Brightness value (from 0 to 1)
     *
     * @return BrightnessBuilder
     * @throws ParamException
     */
    public function brightness(float $value): BrightnessBuilder
    {
        if ($value < 0 || $value > 1) {
            throw new ParamException('Brightness value must be in range from 0 to 1');
        }

        $this->brightness = $value;

        return $this;
    }

    /**
     * Set animation duration
     *
     * @param int $value
     *
     * @return BrightnessBuilder
     * @throws ParamException
     */
    public function duration(int $value): BrightnessBuilder
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
     * @return BrightnessBuilder
     * @throws ParamException
     */
    public function animation(string $type): BrightnessBuilder
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
    public function build(bool $legacy = false): string
    {
        $channelAndLayer = $this->buildChannel();

        if (null === $this->brightness) {
            throw new ParamException('Brightness is required');
        }

        return "MIXER $channelAndLayer BRIGHTNESS {$this->brightness} {$this->duration} {$this->animation}";
    }
}

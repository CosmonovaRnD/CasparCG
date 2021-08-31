<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;

use CosmonovaRnD\CasparCG\Command\Basic\Builder\BaseBuilder;
use CosmonovaRnD\CasparCG\Command\Tween;
use CosmonovaRnD\CasparCG\Exception\ParamException;

/**
 * Class SaturationBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_SATURATION
 */
class SaturationBuilder extends BaseBuilder
{
    /** @var float */
    protected $saturation;
    /** @var int */
    protected $duration = 0;
    /** @var string */
    protected $animation = 'linear';

    /**
     * Set saturation value
     *
     * @param float $value Brightness value (from 0 to 1)
     *
     * @return SaturationBuilder
     * @throws ParamException
     */
    public function saturation(float $value): SaturationBuilder
    {
        if ($value < 0 || $value > 1) {
            throw new ParamException('Saturation value must be in range from 0 to 1');
        }

        $this->saturation = $value;

        return $this;
    }

    /**
     * Set animation duration
     *
     * @param int $value
     *
     * @return SaturationBuilder
     * @throws ParamException
     */
    public function duration(int $value): SaturationBuilder
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
     * @return SaturationBuilder
     * @throws ParamException
     */
    public function animation(string $type): SaturationBuilder
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

        if (null === $this->saturation) {
            throw new ParamException('Saturation is required');
        }

        return "MIXER $channelAndLayer SATURATION {$this->saturation} {$this->duration} {$this->animation}";
    }
}

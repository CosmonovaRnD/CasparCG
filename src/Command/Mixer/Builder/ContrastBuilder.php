<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;

use CosmonovaRnD\CasparCG\Command\Basic\Builder\BaseBuilder;
use CosmonovaRnD\CasparCG\Command\Tween;
use CosmonovaRnD\CasparCG\Exception\ParamException;

/**
 * Class ContrastBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_CONTRAST
 */
class ContrastBuilder extends BaseBuilder
{
    /** @var float */
    protected $contrast;
    /** @var int */
    protected $duration = 0;
    /** @var string */
    protected $animation = 'linear';

    /**
     * Set contrast value
     *
     * @param float $value Brightness value (from 0 to 1)
     *
     * @return ContrastBuilder
     * @throws ParamException
     */
    public function contrast(float $value): ContrastBuilder
    {
        if ($value < 0 || $value > 1) {
            throw new ParamException('Contrast value must be in range from 0 to 1');
        }

        $this->contrast = $value;

        return $this;
    }

    /**
     * Set animation duration
     *
     * @param int $value
     *
     * @return ContrastBuilder
     * @throws ParamException
     */
    public function duration(int $value): ContrastBuilder
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
     * @return ContrastBuilder
     * @throws ParamException
     */
    public function animation(string $type): ContrastBuilder
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

        if (null === $this->contrast) {
            throw new ParamException('Contrast is required');
        }

        return "MIXER $channelAndLayer CONTRAST {$this->contrast} {$this->duration} {$this->animation}";
    }
}

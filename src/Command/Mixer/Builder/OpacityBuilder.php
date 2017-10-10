<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;


use CosmonovaRnD\CasparCG\Command\Basic\Builder\BaseBuilder;
use CosmonovaRnD\CasparCG\Command\Tween;
use CosmonovaRnD\CasparCG\Exception\ParamException;

/**
 * Class OpacityBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_OPACITY
 */
class OpacityBuilder extends BaseBuilder
{
    protected $opacity;
    protected $duration  = 0;
    protected $animation = 'linear';

    /**
     * Set opacity
     *
     * @param float $value Opacity value between 0 and 1
     *
     * @return OpacityBuilder
     * @throws ParamException
     */
    public function opacity(float $value): OpacityBuilder
    {
        if ($value < 0 || $value > 1) {
            throw new ParamException("Value must be between 0 and 1, $value given");
        }

        $this->opacity = $value;

        return $this;
    }

    /**
     * Set duration in frames
     *
     * @param int $frames Duration in frames
     *
     * @return OpacityBuilder
     * @throws ParamException
     */
    public function duration(int $frames): OpacityBuilder
    {
        if ($frames < 0) {
            throw new ParamException('Frames param must be unsigned integer');
        }

        $this->duration = $frames;

        return $this;
    }

    public function animation(string $type): OpacityBuilder
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

        if (null === $this->opacity) {
            throw new ParamException('Opacity is required');
        }

        return "MIXER $channelAndLayer OPACITY {$this->opacity} {$this->duration} {$this->animation}";
    }
}

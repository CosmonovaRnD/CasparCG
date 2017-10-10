<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;

use CosmonovaRnD\CasparCG\Command\Basic\Builder\BaseBuilder;

/**
 * Class RotationBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_ROTATION
 */
class RotationBuilder extends BaseBuilder
{
    /** @var int */
    protected $angle;

    /**
     * Set angle value
     *
     * @param int $value
     *
     * @return RotationBuilder
     */
    public function angle(int $value): RotationBuilder
    {
        $this->angle = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $channelAndLayer = $this->buildChannel();

        return "MIXER $channelAndLayer CROP {$this->angle}";
    }
}

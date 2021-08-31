<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;

use CosmonovaRnD\CasparCG\Command\Basic\Builder\BaseBuilder;
use CosmonovaRnD\CasparCG\Exception\ParamException;

/**
 * Class AnchorBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_ANCHOR
 */
class AnchorBuilder extends BaseBuilder
{
    /** @var float */
    protected $x;
    /** @var float */
    protected $y;

    /**
     * Range 0 to 1 validator
     *
     * @param float[] $values
     *
     * @throws ParamException
     *
     */
    protected function validateValueRange(float ...$values)
    {
        foreach ($values as $value) {
            if ($value < 0 || $value > 1) {
                throw new ParamException('Value must be in range from 0 to 1');
            }
        }
    }

    /**
     * Set coordinates of left top edge
     *
     * @param float $x
     * @param float $y
     *
     * @return AnchorBuilder
     */
    public function coordinates(float $x, float $y): AnchorBuilder
    {
        $this->validateValueRange($x, $y);

        $this->x = $x;
        $this->y = $y;

        return $this;
    }

    /**
     * @return string
     */
    protected function buildCoordinates(): string
    {
        $parts = [$this->x, $this->y];
        array_filter($parts);

        return implode(' ', $parts);
    }

    /**
     * @inheritDoc
     */
    public function build(bool $legacy = false): string
    {
        $channelAndLayer = $this->buildChannel();
        $coordinates     = $this->buildCoordinates();

        return "MIXER $channelAndLayer ANCHOR $coordinates";
    }
}

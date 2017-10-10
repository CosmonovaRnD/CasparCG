<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;

use CosmonovaRnD\CasparCG\Command\Basic\Builder\BaseBuilder;
use CosmonovaRnD\CasparCG\Command\Tween;
use CosmonovaRnD\CasparCG\Exception\ParamException;

/**
 * Class CropBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_CROP
 */
class CropBuilder extends BaseBuilder
{
    /** @var float */
    protected $xLeft;
    /** @var float */
    protected $yTop;
    /** @var float */
    protected $xRight;
    /** @var float */
    protected $yBottom;
    /** @var int */
    protected $duration = 0;
    /** @var  string */
    protected $animation = 'linear';

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
     * @return CropBuilder
     */
    public function leftTop(float $x, float $y): CropBuilder
    {
        $this->validateValueRange($x, $y);

        $this->xLeft = $x;
        $this->yTop  = $y;

        return $this;
    }

    /**
     * Set coordinates of right bottom edge
     *
     * @param float $x
     * @param float $y
     *
     * @return CropBuilder
     */
    public function rightBottom(float $x, float $y): CropBuilder
    {
        $this->validateValueRange($x, $y);

        $this->xRight  = $x;
        $this->yBottom = $y;

        return $this;
    }

    /**
     * Set animation duration
     *
     * @param int $value
     *
     * @return CropBuilder
     * @throws ParamException
     */
    public function duration(int $value): CropBuilder
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
     * @return CropBuilder
     * @throws ParamException
     */
    public function animation(string $type): CropBuilder
    {
        if (!in_array($type, Tween::animationTypes())) {
            throw new ParamException("Unsupported animation type `$type`");
        }

        $this->animation = $type;

        return $this;
    }

    /**
     * @return string
     */
    protected function buildLeftTop(): string
    {
        $parts = [$this->xLeft, $this->yTop];
        array_filter($parts);

        return join(' ', $parts);
    }

    /**
     * @return string
     */
    protected function buildRightBottom(): string
    {
        $parts = [$this->xRight, $this->yBottom];
        array_filter($parts);

        return join(' ', $parts);
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $channelAndLayer = $this->buildChannel();
        $leftTop         = $this->buildLeftTop();
        $rightBottom     = $this->buildRightBottom();

        $tail = '';

        if (strlen($leftTop) && strlen($rightBottom)) {
            $tail = "$leftTop $rightBottom {$this->duration} {$this->animation}";
        }

        return "MIXER $channelAndLayer CROP $tail";
    }
}

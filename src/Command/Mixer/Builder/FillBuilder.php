<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;

use CosmonovaRnD\CasparCG\Command\Basic\Builder\BaseBuilder;
use CosmonovaRnD\CasparCG\Command\Tween;
use CosmonovaRnD\CasparCG\Exception\ParamException;

/**
 * Class FillBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_FILL
 */
class FillBuilder extends BaseBuilder
{
    /** @var float */
    protected $x;
    /** @var float */
    protected $y;
    /** @var float */
    protected $width;
    /** @var float */
    protected $height;
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
     * @return FillBuilder
     */
    public function coordinates(float $x, float $y): FillBuilder
    {
        $this->validateValueRange($x, $y);

        $this->x = $x;
        $this->y = $y;

        return $this;
    }

    /**
     * Set fill size
     *
     * @param float $width
     * @param float $height
     *
     * @return FillBuilder
     *
     */
    public function size(float $width, float $height): FillBuilder
    {
        $this->validateValueRange($width, $height);

        $this->width  = $width;
        $this->height = $height;

        return $this;
    }

    /**
     * Set animation duration
     *
     * @param int $value
     *
     * @return FillBuilder
     * @throws ParamException
     */
    public function duration(int $value): FillBuilder
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
     * @return FillBuilder
     * @throws ParamException
     */
    public function animation(string $type): FillBuilder
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
    protected function buildCoordinates(): string
    {
        $parts = [$this->x, $this->y];
        array_filter($parts);

        return implode(' ', $parts);
    }

    /**
     * @return string
     */
    protected function buildSize(): string
    {
        $parts = [$this->width, $this->height];
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
        $size            = $this->buildSize();

        $tail = '';

        if ('' !== $coordinates && '' !== $size) {
            $tail = "$coordinates $size {$this->duration} {$this->animation}";
        }

        return "MIXER $channelAndLayer FILL $tail";
    }
}

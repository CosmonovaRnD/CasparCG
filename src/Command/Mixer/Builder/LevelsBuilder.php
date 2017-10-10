<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;

use CosmonovaRnD\CasparCG\Command\Basic\Builder\BaseBuilder;
use CosmonovaRnD\CasparCG\Command\Tween;
use CosmonovaRnD\CasparCG\Exception\ParamException;

/**
 * Class LevelsBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_LEVELS
 */
class LevelsBuilder extends BaseBuilder
{
    /** @var float */
    protected $minInput;
    /** @var float */
    protected $maxInput;
    /** @var float */
    protected $gamma;
    /** @var float */
    protected $minOutput;
    /** @var float */
    protected $maxOutput;
    /** @var int */
    protected $duration = 0;
    /** @var  string */
    protected $animation = 'linear';

    /**
     * Range 0 to 1 validator
     *
     * @param float $value
     *
     * @throws ParamException
     */
    protected function validateValueRange(float $value)
    {
        if ($value < 0 || $value > 1) {
            throw new ParamException('Value must be in range from 0 to 1');
        }
    }

    /**
     * Set input level
     *
     * @param float $min
     * @param float $max
     *
     * @return LevelsBuilder
     *
     */
    public function input(float $min, float $max): LevelsBuilder
    {
        $this->validateValueRange($min);
        $this->validateValueRange($max);

        $this->minInput = $min;
        $this->minInput = $max;

        return $this;
    }

    /**
     * Set gamma
     *
     * @param float $value
     *
     * @return LevelsBuilder
     */
    public function gamma(float $value): LevelsBuilder
    {
        $this->validateValueRange($value);

        $this->gamma = $value;

        return $this;
    }

    /**
     * Set min output level
     *
     * @param float $min
     * @param float $max
     *
     * @return LevelsBuilder
     *
     */
    public function output(float $min, float $max): LevelsBuilder
    {
        $this->validateValueRange($min);
        $this->validateValueRange($max);

        $this->minOutput = $min;
        $this->maxOutput = $max;

        return $this;
    }

    /**
     * Set animation duration
     *
     * @param int $value
     *
     * @return LevelsBuilder
     * @throws ParamException
     */
    public function duration(int $value): LevelsBuilder
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
     * @return LevelsBuilder
     * @throws ParamException
     */
    public function animation(string $type): LevelsBuilder
    {
        if (!in_array($type, Tween::animationTypes())) {
            throw new ParamException("Unsupported animation type `$type`");
        }

        $this->animation = $type;

        return $this;
    }

    /**
     * @return string
     * @throws ParamException
     */
    protected function buildLevelParams(): string
    {
        if (null === $this->minInput && null === $this->maxInput) {
            return '';
        }

        if (null === $this->gamma) {
            throw new ParamException('Gamma is required');
        }

        if (null === $this->minOutput && null === $this->maxOutput) {
            throw new ParamException('Output range is required');
        }

        return "{$this->minInput} {$this->maxInput} {$this->gamma} {$this->minOutput} {$this->maxOutput} {$this->duration} {$this->animation}";
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $channelAndLayer = $this->buildChannel();
        $levelParamStr   = $this->buildLevelParams();

        return "MIXER $channelAndLayer LEVELS $levelParamStr";
    }
}

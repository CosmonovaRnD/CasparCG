<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;

use CosmonovaRnD\CasparCG\Command\BaseBuilderInterface;
use CosmonovaRnD\CasparCG\Command\CommandBuilderInterface;
use CosmonovaRnD\CasparCG\Command\Tween;
use CosmonovaRnD\CasparCG\Exception\ParamException;
use CosmonovaRnD\CasparCG\Exception\ParseException;

/**
 * Class GridBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_GRID
 */
class GridBuilder implements BaseBuilderInterface, CommandBuilderInterface
{
    /** @var int */
    protected $channel;
    /** @var int */
    protected $resolution;
    /** @var int */
    protected $duration = 0;
    /** @var string */
    protected $animation = 'linear';

    /**
     * @param int $channel
     *
     * @return BaseBuilderInterface
     * @throws ParamException
     */
    public function channel(int $channel): BaseBuilderInterface
    {
        if ($channel < 0) {
            throw new ParamException('Channel must be unsigned integer value');
        }

        $this->channel = $channel;

        return $this;
    }

    public function resolution(int $value): GridBuilder
    {
        if ($value < 0) {
            throw new ParamException('Resolution must be unsigned integer value');
        }

        $this->resolution = $value;

        return $this;
    }

    /**
     * Set animation duration
     *
     * @param int $value
     *
     * @return GridBuilder
     * @throws ParamException
     */
    public function duration(int $value): GridBuilder
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
     * @return GridBuilder
     * @throws ParamException
     */
    public function animation(string $type): GridBuilder
    {
        if (!in_array($type, Tween::animationTypes())) {
            throw new ParamException("Unsupported animation type `$type`");
        }

        $this->animation = $type;

        return $this;
    }

    /**
     * @return string
     * @throws ParseException
     */
    protected function buildChannel(): string
    {
        if (null === $this->channel) {
            throw new ParseException('Channel param is required. Use channel() method for this');
        }

        return (string)$this->channel;
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $channel = $this->buildChannel();

        if (null === $this->resolution) {
            throw new ParseException('Resolution value mus be set. Use resolution() method for this');
        }

        return "MIXER $channel GRID {$this->resolution} {$this->duration} {$this->animation}";
    }
}

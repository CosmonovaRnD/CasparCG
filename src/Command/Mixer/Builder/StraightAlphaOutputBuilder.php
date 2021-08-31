<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;

use CosmonovaRnD\CasparCG\Command\BaseBuilderInterface;
use CosmonovaRnD\CasparCG\Command\CommandBuilderInterface;
use CosmonovaRnD\CasparCG\Exception\ParamException;
use CosmonovaRnD\CasparCG\Exception\ParseException;

/**
 * Class StraightAlphaOutputBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_STRAIGHT_ALPHA_OUTPUT
 */
class StraightAlphaOutputBuilder implements BaseBuilderInterface, CommandBuilderInterface
{
    /** @var  int */
    protected $channel;
    /** @var  bool */
    protected $active;

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

    /**
     * Set active status to true
     *
     * @return StraightAlphaOutputBuilder
     */
    public function activate(): StraightAlphaOutputBuilder
    {
        $this->active = true;

        return $this;
    }

    /**
     * Set active status to false
     *
     * @return StraightAlphaOutputBuilder
     */
    public function deactivate(): StraightAlphaOutputBuilder
    {
        $this->active = false;

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
     * @return string
     */
    protected function buildActiveState(): string
    {
        if (null === $this->active) {
            return '';
        }

        return $this->active ? '1' : '0';
    }

    /**
     * @inheritDoc
     */
    public function build(bool $legacy = false): string
    {
        $channel     = $this->buildChannel();
        $activeState = $this->buildActiveState();

        return "MIXER $channel STRAIGHT_ALPHA_OUTPUT $activeState";
    }
}

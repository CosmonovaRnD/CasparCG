<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

use CosmonovaRnD\CasparCG\Exception\ParamException;
use CosmonovaRnD\CasparCG\Exception\ParseException;

/**
 * Class SwapBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 */
class SwapBuilder extends BaseBuilder
{
    #region properties

    /** @var  int */
    protected $swapChannel;
    /** @var  int */
    protected $swapLayer;

    #endregion

    #region setters

    /**
     * @param int $swapChannel
     *
     * @return SwapBuilder
     * @throws ParamException
     */
    public function swapChannel(int $swapChannel): SwapBuilder
    {
        if ($swapChannel < 0) {
            throw new ParamException('Swap channel value must be unsigned integer');
        }

        $this->swapChannel = $swapChannel;

        return $this;
    }

    /**
     * @param int $swapLayer
     *
     * @return SwapBuilder
     * @throws ParamException
     */
    public function swapLayer(int $swapLayer): SwapBuilder
    {
        if ($swapLayer < 0) {
            throw new ParamException('Swap layer value must be unsigned integer');
        }

        $this->swapLayer = $swapLayer;

        return $this;
    }

    #endregion

    #region builders

    /**
     * @return string
     * @throws ParseException
     */
    protected function buildSwapChannel(): string
    {
        if (null === $this->swapChannel) {
            throw new ParseException('Swap channel is required');
        }

        $swapChannel = [$this->swapChannel, $this->swapLayer];
        $swapChannel = array_filter($swapChannel);

        return join('-', $swapChannel);
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $commandParts[] = 'SWAP';
        $commandParts[] = $this->buildChannel();
        $commandParts[] = $this->buildSwapChannel();

        $commandParts = array_filter($commandParts);
        $command      = join(' ', $commandParts);

        return $command;
    }

    #endregion
}

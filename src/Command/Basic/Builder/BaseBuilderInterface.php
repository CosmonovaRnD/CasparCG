<?php

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

/**
 * Interface BaseBuilderInterface
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 */
interface BaseBuilderInterface
{
    /**
     * Set swapChannel number
     *
     * @param int $channel
     *
     * @return BaseBuilderInterface
     */
    public function channel(int $channel): BaseBuilderInterface;
}

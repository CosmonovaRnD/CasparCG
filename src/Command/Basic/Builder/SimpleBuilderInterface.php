<?php

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

/**
 * Interface SimpleBuilderInterface
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 */
interface SimpleBuilderInterface extends BaseBuilderInterface
{
    /**
     * Set layer number
     *
     * @param int $layer
     *
     * @return SimpleBuilderInterface
     */
    public function layer(int $layer): SimpleBuilderInterface;
}

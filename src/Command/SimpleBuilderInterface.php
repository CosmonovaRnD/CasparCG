<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command;

/**
 * Interface SimpleBuilderInterface
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command
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

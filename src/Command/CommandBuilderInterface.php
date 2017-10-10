<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command;

/**
 * Interface CommandBuilderInterface
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command
 * Cosmonova | Research & Development
 */
interface CommandBuilderInterface
{
    /**
     * Build and return command
     * @return string
     */
    public function build(): string;
}

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
     * @param bool $legacy set 'true' to use v2.0.7 CasparCG version
     * @return string
     */
    public function build(bool $legacy = false): string;
}

<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

/**
 * Class ClearBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 *
 * @http    ://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#CLEAR
 */
class ClearBuilder extends BaseBuilder
{
    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $commandParts[] = 'CLEAR';
        $commandParts[] = $this->buildChannel();

        $commandParts = array_filter($commandParts);
        $command      = join(' ', $commandParts);

        return $command;
    }
}

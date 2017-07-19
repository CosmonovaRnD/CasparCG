<?php

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

/**
 * Class StopBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#STOP
 */
class StopBuilder extends BaseBuilder
{
    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $commandParts[] = 'STOP';
        $commandParts[] = $this->buildChannel();

        $commandParts = array_filter($commandParts);
        $command      = join(' ', $commandParts);

        return $command;
    }
}

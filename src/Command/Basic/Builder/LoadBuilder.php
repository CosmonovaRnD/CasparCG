<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

/**
 * Class LoadBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#LOAD
 */
class LoadBuilder extends LoadBgBuilder
{
    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $commandParts[] = 'LOAD';
        $commandParts[] = $this->buildChannel();
        $commandParts[] = $this->buildClip();
        $commandParts[] = $this->buildLoop();
        $commandParts[] = $this->buildTransitionGroup();
        $commandParts[] = $this->buildSeek();
        $commandParts[] = $this->buildLength();
        $commandParts[] = $this->buildFilter();
        $commandParts[] = $this->buildAuto();


        $commandParts = array_filter($commandParts);
        $command      = join(' ', $commandParts);

        return $command;
    }
}

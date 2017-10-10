<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

/**
 * Class PlayBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#PLAY
 */
class PlayBuilder extends LoadBgBuilder
{
    /**
     * @inheritDoc
     */
    protected function buildClip(): string
    {
        return sprintf('"%s"', addslashes($this->clip));
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $commandParts[] = 'PLAY';
        $commandParts[] = $this->buildChannel();
        $commandParts[] = $this->buildUseHtmlProducer();
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

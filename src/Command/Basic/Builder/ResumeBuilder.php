<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

/**
 * Class ResumeBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#RESUME
 */
class ResumeBuilder extends BaseBuilder
{
    /**
     * @inheritDoc
     */
    public function build(bool $legacy = false): string
    {
        $commandParts[] = 'RESUME';
        $commandParts[] = $this->buildChannel();

        $commandParts = array_filter($commandParts);

        return implode(' ', $commandParts);
    }
}

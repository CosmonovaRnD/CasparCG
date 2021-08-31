<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

use function array_filter;
use function implode;

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
    public function build(bool $legacy = false): string
    {
        $commandParts[] = 'CLEAR';
        $commandParts[] = $this->buildChannel();

        $commandParts = array_filter($commandParts);

        return implode(' ', $commandParts);
    }
}

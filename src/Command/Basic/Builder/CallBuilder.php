<?php

declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

use function array_filter;
use function implode;

/**
 * Class CallBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#CALL
 */
class CallBuilder extends LoadBgBuilder
{
    #region properties

    protected $invoke;

    #endregion

    #region setters

    public function invoke(string $command): CallBuilder
    {
        $this->invoke = $command;

        return $this;
    }

    #endregion

    #region builders

    protected function buildInvoke(bool $legacy): string
    {
        $invoke = $legacy ? 'INVOKE' : '';

        return null !== $this->invoke ? sprintf('%s "%s"', $invoke, addslashes($this->invoke)) : '';
    }

    /**
     * @inheritDoc
     */
    public function build(bool $legacy = false): string
    {
        $commandParts[] = 'CALL';
        $commandParts[] = $this->buildChannel();
        $commandParts[] = $this->buildInvoke($legacy);
        $commandParts[] = $this->buildLoop();
        $commandParts[] = $this->buildTransitionGroup();
        $commandParts[] = $this->buildSeek();
        $commandParts[] = $this->buildLength();
        $commandParts[] = $this->buildFilter();
        $commandParts[] = $this->buildAuto();

        $commandParts = array_filter($commandParts);

        return implode(' ', $commandParts);
    }

    #endregion
}

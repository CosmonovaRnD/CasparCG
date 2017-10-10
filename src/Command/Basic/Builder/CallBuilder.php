<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

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

    /**
     * Set INVOKE
     *
     * @param string $command
     *
     * @return \CosmonovaRnD\CasparCG\Command\Basic\Builder\CallBuilder
     */
    public function invoke(string $command): CallBuilder
    {
        $this->invoke = $command;

        return $this;
    }

    #endregion

    #region builders

    protected function buildInvoke(): string
    {
        return null !== $this->invoke ? sprintf('INVOKE "%s"', addslashes($this->invoke)) : '';
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $commandParts[] = 'CALL';
        $commandParts[] = $this->buildChannel();
        $commandParts[] = $this->buildInvoke();
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

    #endregion
}

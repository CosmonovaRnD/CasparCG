<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;


use CosmonovaRnD\CasparCG\Command\Basic\Builder\BaseBuilder;

/**
 * Class KeyerBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_KEYER
 */
class KeyerBuilder extends BaseBuilder
{
    protected $keyer = false;

    /**
     * @return KeyerBuilder
     */
    public function keyerEnabled(): KeyerBuilder
    {
        $this->keyer = true;

        return $this;
    }

    /**
     * @return KeyerBuilder
     */
    public function keyerDisabled(): KeyerBuilder
    {
        $this->keyer = false;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function build(bool $legacy = false): string
    {
        $chanelAndLayer = $this->buildChannel();
        $keyer          = $this->keyer ? 1 : 0;

        return "MIXER $chanelAndLayer KEYER $keyer";
    }
}

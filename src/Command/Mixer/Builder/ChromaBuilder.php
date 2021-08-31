<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;

use CosmonovaRnD\CasparCG\Command\Basic\Builder\BaseBuilder;
use CosmonovaRnD\CasparCG\Exception\ParamException;
use CosmonovaRnD\CasparCG\Exception\ParseException;

/**
 * Class ChromaBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_CHROMA
 */
class ChromaBuilder extends BaseBuilder
{
    const COLOR_NONE     = 'none';
    const COLOR_RED      = 'red';
    const COLOR_GREEN    = 'green';
    const COLOR_BLUE     = 'blue';
    const COLOR_YELLOW   = 'yellow';
    const COLOR_TORQUISE = 'torquise';
    const COLOR_MAGENTA  = 'magenta';

    protected $color;
    protected $tresholdLower;
    protected $tresholdUpper;

    public static $colors = [
        self::COLOR_NONE,
        self::COLOR_GREEN,
        self::COLOR_BLUE,
        self::COLOR_YELLOW,
        self::COLOR_TORQUISE,
        self::COLOR_MAGENTA
    ];

    public function color(string $value): ChromaBuilder
    {
        if (!in_array($value, static::$colors)) {
            throw new ParamException("Unsupported value `$value`.");
        }

        $this->color = $value;

        return $this;
    }

    public function tresholdLower(float $value): ChromaBuilder
    {
        $this->tresholdLower = $value;

        return $this;
    }

    public function tresholdUpper(float $value): ChromaBuilder
    {
        $this->tresholdUpper = $value;

        return $this;
    }

    #region builders

    protected function buildTresholds(): string
    {
        if (null === $this->tresholdLower || null === $this->tresholdUpper) {
            throw new ParseException('Treshold params are required');
        }

        return "{$this->tresholdLower} {$this->tresholdUpper}";
    }

    #endregion

    public function build(bool $legacy = false): string
    {
        $channelAndLayer = $this->buildChannel();

        if (self::COLOR_NONE === $this->color) {
            return "MIXER $channelAndLayer CHROMA {$this->color}";
        }

        $tresholds = $this->buildTresholds();

        return "MIXER $channelAndLayer CHROMA {$this->color} $tresholds";
    }
}

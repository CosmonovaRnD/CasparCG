<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Mixer\Builder;


use CosmonovaRnD\CasparCG\Command\Basic\Builder\BaseBuilder;
use CosmonovaRnD\CasparCG\Exception\ParamException;

/**
 * Class BlendBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Mixer\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#MIXER_BLEND
 */
class BlendBuilder extends BaseBuilder
{
    protected $blendMode;

    public static $blendModes = [
        'normal',
        'lighten',
        'darken',
        'multiply',
        'average',
        'add',
        'subtract',
        'difference',
        'negation',
        'exclusion',
        'screen',
        'overlay',
        'soft_light',
        'hard_light',
        'color_dodge',
        'color_burn',
        'linear_dodge',
        'linear_burn',
        'linear_light',
        'vivid_light',
        'pin_light',
        'hard_mix',
        'reflect',
        'glow',
        'phoenix',
        'contrast',
        'saturation',
        'color',
        'luminosity',
        'mix',
        'blend_mode_count'
    ];

    /**
     * @param string $mode
     *
     * @return BlendBuilder
     * @throws ParamException
     */
    public function blendMode(string $mode): BlendBuilder
    {
        if (!in_array($mode, self::$blendModes)) {
            throw new ParamException("Unsupported blend mode `$mode`");
        }

        $this->blendMode = $mode;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(bool $legacy = false): string
    {
        $channelAndLayer = $this->buildChannel();

        return "MIXER $channelAndLayer BLEND {$this->blendMode}";
    }
}

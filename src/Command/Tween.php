<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command;

/**
 * Class Tween
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command
 * Cosmonova | Research & Development
 */
class Tween
{
    /**
     * Tween animation types
     *
     * @return array
     */
    public static function animationTypes(): array
    {
        return [
            'linear',
            'easenone',
            'easeinquad',
            'easeoutquad',
            'easeinoutquad',
            'easeoutinquad',
            'easeincubic',
            'easeoutcubic',
            'easeinoutcubic',
            'easeoutincubic',
            'easeinquart',
            'easeoutquart',
            'easeinoutquart',
            'easeoutinquart',
            'easeinquint',
            'easeoutquint',
            'easeinoutquint',
            'easeoutinquint',
            'easeinsine',
            'easeoutsine',
            'easeinoutsine',
            'easeoutinsine',
            'easeinexpo',
            'easeoutexpo',
            'easeinoutexpo',
            'easeoutinexpo',
            'easeincirc',
            'easeoutcirc',
            'easeinoutcirc',
            'easeoutincirc',
            'easeinelastic',
            'easeoutelastic',
            'easeinoutelastic',
            'easeoutinelastic',
            'easeinback',
            'easeoutback',
            'easeinoutback',
            'easeoutintback',
            'easeoutbounce',
            'easeinbounce',
            'easeinoutbounce',
            'easeoutinbounce',
        ];
    }
}

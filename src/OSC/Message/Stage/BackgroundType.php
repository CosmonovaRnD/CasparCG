<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Stage;

/**
 * Class BackgroundType
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Stage
 * Cosmonova | Research & Development
 */
class BackgroundType extends Type
{
    public static $pattern = '#^/channel/(\d+)/stage/layer/(\d+)/background/type\x00*$#';
}

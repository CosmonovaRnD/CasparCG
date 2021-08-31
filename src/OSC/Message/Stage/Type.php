<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Stage;

use CosmonovaRnD\CasparCG\OSC\Message\Stage;
use CosmonovaRnD\CasparCG\OSC\RawMessage;

/**
 * Class Type
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Stage
 * Cosmonova | Research & Development
 */
class Type extends Stage
{
    /** @var  string */
    protected $value;

    public static $pattern = '#^/channel/(\d+)/stage/layer/(\d+)/type\x00*$#';

    /**
     * @inheritDoc
     */
    public function parseArguments(RawMessage $message)
    {
        $data        = $message->getArguments();
        $this->value = isset($data[0]) ? rtrim($data[0], "\0") : 'type is undefined';
    }

    /**
     * Get layer type
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }
}

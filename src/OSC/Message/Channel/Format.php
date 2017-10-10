<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC\Message\Channel;

use CosmonovaRnD\CasparCG\OSC\Message\Channel;

/**
 * Class Format
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC\Message\Channel
 * Cosmonova | Research & Development
 */
class Format extends Channel
{
    /** @var string */
    protected $value;

    public static $pattern = '#^/channel/(\d+)/format\x00*$#';

    /**
     * @inheritDoc
     */
    public function __construct(int $channel, array $data)
    {
        $this->value = (string)rtrim($data[0], "\0") ?? 'Unknown format';

        parent::__construct($channel);
    }

    /**
     * @return mixed
     */
    public function getValue(): string
    {
        return $this->value;
    }
}

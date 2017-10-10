<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC;

/**
 * Class RawMessage
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC
 * Cosmonova | Research & Development
 */
class RawMessage
{
    /** @var string */
    private $address;
    /** @var array */
    private $arguments;

    /**
     * @inheritDoc
     */
    public function __construct(string $address, array $arguments)
    {
        $this->address   = $address;
        $this->arguments = $arguments;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Add argument to collection
     *
     * @param mixed $argument
     */
    public function addArgument($argument)
    {
        $this->arguments[] = $argument;
    }

    /**
     * Return object as array
     *
     * @return array
     */
    function toArray(): array
    {
        return [
            'address'   => $this->address,
            'arguments' => $this->arguments
        ];
    }
}

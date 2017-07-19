<?php

namespace CosmonovaRnD\CasparCG;

/**
 * Class Response
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG
 * Cosmonova | Research & Development
 */
class Response
{
    private $code;
    private $status;
    private $body;

    public function __construct(int $code, string $status, string $body = '')
    {
        $this->code   = $code;
        $this->status = $status;
        $this->body   = $body;
    }

    /**
     * Return success status
     *
     * @return bool
     */
    public function success(): bool
    {
        return $this->code < 400;
    }

    /**
     * Return failed status
     *
     * @return bool
     */
    public function failed(): bool
    {
        return $this->code >= 400;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

}

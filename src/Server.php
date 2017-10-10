<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG;

/**
 * Class Server
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG
 * Cosmonova | Research & Development
 */
class Server
{
    private $address;
    private $port;
    private $socket;

    public function __construct(string $address = '127.0.0.1', int $port = 6250)
    {
        $this->address = $address;
        $this->port    = $port;
    }

    function __destruct()
    {
        $this->stop();
    }

    public function start(): self
    {
        if (!$this->isStarted()) {

            try {
                $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
                socket_bind($this->socket, $this->address, $this->port);
                socket_set_block($this->socket);

            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }

        return $this;
    }

    public function stop()
    {
        if ($this->isStarted()) {
            socket_close($this->socket);
        }
    }

    public function isStarted()
    {
        return is_resource($this->socket);
    }

    public function read()
    {
        $buffer = '';

        if ($this->isStarted()) {
            socket_recv($this->socket, $buffer, 2048, MSG_DONTWAIT);

            return $buffer;
        }

        return false;
    }
}

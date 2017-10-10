<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG;

use CosmonovaRnD\CasparCG\Exception\BaseException;

/**
 * Class Client
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG
 * Cosmonova | Research & Development
 */
class Client
{
    /** @var string */
    private $address;
    /** @var int */
    private $port;
    /** @var resource */
    private $connection;
    /** @var int|null */
    private $errorCode = 0;
    /** @var  string|null */
    private $errorMessage = '';
    /** @var int */
    private $timeout;

    /**
     * Client constructor.
     *
     * @param string $address
     * @param int    $port
     * @param int    $timeout
     *
     * @throws BaseException
     */
    public function __construct(string $address = '127.0.0.1', int $port = 5250, int $timeout = 10)
    {
        $this->address = $address;
        $this->port    = $port;
        $this->timeout = $timeout;
    }

    /**
     * Connect to host
     *
     * @return bool
     */
    public function connect(): bool
    {
        if ($this->isConnected()) {
            return true;
        }

        $connectStr = 'tcp://' . $this->address . ':' . $this->port;
        // Connecting to host
        $this->connection = stream_socket_client($connectStr, $this->errorCode, $this->errorMessage, $this->timeout);

        return $this->isConnected();
    }

    /**
     * Check if client connected
     *
     * @return bool
     */
    public function isConnected()
    {
        return is_resource($this->connection);
    }

    /**
     * Check if connection is alive
     *
     * @return bool
     */
    public function isAlive(): bool
    {
        return !feof($this->connection);
    }

    /**
     * Get connection last error code
     *
     * @return int
     *
     * @see http://php.net/manual/ru/function.socket-last-error.php
     */
    public function getConnectionErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Get connection last error message
     *
     * @return string
     *
     * @see http://php.net/manual/ru/function.socket-strerror.php
     */
    public function getConnectionErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param $command
     *
     * @return Response
     * @throws BaseException
     */
    public function send($command): Response
    {
        if (!$this->connect()) {
            throw new BaseException('Connect to host failed', 500);
        }

        fwrite($this->connection, $command . "\r\n");

        // initial params
        $terminateStr  = "\r\n";
        $multiLineBody = false;
        $hasResponse   = false;

        $line = stream_get_line($this->connection, 0, $terminateStr);

        $line = explode(" ", $line);
        $code = (int)$line[0];

        switch ($code) {
            case 100:
            case 101:
                $status = $line[1];
                break;
            case 200:
                $status        = 'Success';
                $multiLineBody = true;
                $hasResponse   = true;
                break;
            case 201:
                $status      = 'Success';
                $hasResponse = true;
                break;
            case 202:
                $status = 'Success';
                break;
            case 400:
                $status = 'Error: Command not understood';
                break;
            case 401:
                $status = 'Error: Illegal video swapChannel';
                break;
            case 402:
                $status = 'Error: Parameter missing';
                break;
            case 403:
                $status = 'Error: Illegal parameter';
                break;
            case 404:
                $status = 'Error: Media file not found';
                break;
            case 500:
            case 501:
                $status = 'Failed: Internal server error';
                break;
            case 502:
                $status = 'Failed: Internal server error';
                break;
            default:
                $status = 'Unknown internal error';
        }

        $body = '';

        if ($hasResponse) {
            $body = $this->getBody($multiLineBody);
        }

        return new Response($code, $status, $body);
    }

    private function getBody(bool $multiLine): string
    {
        if ($multiLine) {
            $body = stream_get_line($this->connection, 0, "\r\n\r\n");
        } else {
            $body = stream_get_line($this->connection, 0, "\r\n");
        }

        return $body;
    }

    /**
     * Close socket connection
     *
     * @return bool
     */
    public function closeSocket(): bool
    {
        @fclose($this->connection);
        $this->connection = null;

        return true;
    }

    public function __destruct()
    {
        $this->closeSocket();
    }
}

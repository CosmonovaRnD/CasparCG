<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Exception;

/**
 * Class BaseException
 *
 * @author Aleksandr Besedin <bs@cosmonova.net>
 * Cosmonova | Research & Development
 */
class BaseException extends \Exception
{
    public function __construct($message = 'Internal server error', $code = 500, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string
    {
        return json_encode(['code' => $this->code, 'message' => $this->message]);
    }
}

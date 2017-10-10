<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Exception;

/**
 * Class ParamException
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Exception
 * Cosmonova | Research & Development
 */
class ParamException extends BaseException
{
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message, 400, $previous);
    }

}

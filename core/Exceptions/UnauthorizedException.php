<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 24.11.2017
 * Time: 18:36
 */

namespace core\Exceptions;

use Throwable;

class UnauthorizedException extends BaseException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->dest .= '/unauthorized';
        parent::__construct($message, $code, $previous);
    }
}
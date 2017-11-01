<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 31.10.2017
 * Time: 18:42
 */

namespace core\Exceptions;


use Throwable;

class ValidateException extends BaseException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->dest .= '/validate';
        parent::__construct($message, $code, $previous);
    }
}
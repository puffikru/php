<?php

namespace core\Exceptions;


use Throwable;

class Error404 extends BaseException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->dest .= '/err404';
        parent::__construct($message, $code, $previous);
    }
}
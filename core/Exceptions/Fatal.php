<?php

namespace core\Exceptions;


use Throwable;

class Fatal extends BaseException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->dest .= '/fatal';
        parent::__construct($message, $code, $previous);
        // mail
    }
}
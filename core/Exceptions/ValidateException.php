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
    private $errors;

    public function __construct(array $errors, $message = "validation exception", $code = 403, Throwable $previous = null)
    {
        $this->dest .= '/validate';
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
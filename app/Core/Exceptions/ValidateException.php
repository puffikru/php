<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 31.10.2017
 * Time: 18:42
 */

namespace NTSchool\Phpblog\Core\Exceptions;


use Throwable;

class ValidateException extends BaseException
{
    /**
     * @var array
     */
    private $errors;

    /**
     * ValidateException constructor.
     *
     * @param array $errors
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(array $errors, $message = "validation exception", $code = 403, Throwable $previous = null)
    {
        $this->dest .= '/validate';
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
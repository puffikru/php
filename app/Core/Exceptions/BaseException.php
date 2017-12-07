<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 14.10.17
 * Time: 4:36
 */

namespace NTSchool\Phpblog\Core\Exceptions;


use Throwable;

class BaseException extends \Exception
{
    /**
     * @var string
     */
    public $dest = LOG_DIR;

    /**
     * BaseException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $msg = "\n" . date('H:i:m') . "\n" . $_SERVER['REMOTE_ADDR'] . "\n\n" . $this .
            "\n-------------------------------------------------------------------------------------\n";
        file_put_contents($this->dest . '/' . date('Y-m-d'), $msg, FILE_APPEND);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 24.11.2017
 * Time: 21:06
 */

namespace core;


class Logger
{
    private $dest = LOG_DIR;
    public $filename;


    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function write($msg)
    {
        file_put_contents($this->dest . '/' . date('Y-m-d'), $msg, FILE_APPEND);
    }
}
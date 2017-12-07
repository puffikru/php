<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 06.12.2017
 * Time: 11:56
 */

namespace NTSchool\Phpblog\Core;


class Logger
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $dir = LOG_DIR;

    /**
     * @var string
     */
    private $path;

    /**
     * Logger constructor.
     *
     * @param $filename
     * @param $dir
     */
    public function __construct($filename, $dir)
    {
        $this->file = $filename . '.log';
        $this->dir .= '/' . $dir;
        $this->path = $this->dir;
        $this->prepareDir();
    }

    /**
     * @param $log
     * @param string $level
     */
    public function write($log, $level = '')
    {
        $msg = "\n" . date('H:i:m') . "\n" . $_SERVER['REMOTE_ADDR'] . "\n\n" . $log . "\n" . $level .
            "\n-------------------------------------------------------------------------------------\n";
        file_put_contents($this->path . '/' . date('Y-m-d'), $msg, FILE_APPEND);
    }

    /**
     *
     */
    protected function prepareDir()
    {
        if(!file_exists($this->dir)){
            if(!mkdir($this->dir, 0777, true)){
                throw new \RuntimeException("Log dir can't be created by path $this->dir");
            }
        }
    }
}
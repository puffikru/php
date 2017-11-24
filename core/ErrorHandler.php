<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 24.11.2017
 * Time: 21:05
 */

namespace core;

class ErrorHandler implements ErrorHandlerInterface
{
    protected static $logger;
    protected static $dev;

    public function __construct(Logger $logger, $dev = true)
    {
        $this->logger = $logger;
        $this->dev = $dev;
    }

    public static function handle(\Exception $e)
    {
        $msg = "\n" . date('H:i:m') . "\n" . $_SERVER['REMOTE_ADDR'] . "\n\n" . $e .
            "\n-------------------------------------------------------------------------------------\n";
        if(isset(self::$logger)){
            self::$logger->write($msg);
        }

        if(self::$dev){
            $msg = $e;
        }

        $msg = "<h1>" . $e->getMessage() . "</h1>";

        return $msg;
    }
}
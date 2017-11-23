<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 23.11.2017
 * Time: 11:46
 */

namespace core;


class Core
{
    protected static $instance;

    public static function start()
    {
        if(static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct(){}

    public function run()
    {

    }
}
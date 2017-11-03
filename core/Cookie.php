<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 28.10.2017
 * Time: 20:59
 */

namespace core;


class Cookie
{
    public function get($name){
        return $_COOKIE[$name] ?? false;
    }

    public static function set($name, $value, $time){
        setcookie($name, $value, time() + $time, '/');
    }

    public static function del($name){
        setcookie($name, '', 1, '/');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 28.10.2017
 * Time: 20:59
 */

namespace core;


class Session
{
    public function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function set($key, $value){
        $_SESSION[$key] = $value;
    }

    public function del($key){
        unset($_SESSION[$key]);
    }
}
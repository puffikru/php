<?php

namespace model;

use core\Settings;

class Auth
{
    // Хэширование
    public static function myHash($str)
    {
        return hash('sha256', $str . Settings::SALT);
    }

    // Авторизация
    public static function isAuth()
    {
        $isAuth = false;

        if(isset($_SESSION['is_auth']) && $_SESSION['is_auth']) {

            $isAuth = true;

        }elseif(isset($_COOKIE['login']) && isset($_COOKIE['password'])) {

            if($_COOKIE['login'] == self::myHash($_SESSION['login']) && $_COOKIE['password'] == self::myHash($_SESSION['password'])) {

                $_SESSION['is_auth'] = true;
                $isAuth = true;
            }
        }
        return $isAuth;
    }

    // Деавторизация
    public static function logOff()
    {
        $_SESSION['is_auth'] = false;
        setcookie('admin', '', 1, '/');
        setcookie('password', '', 1, '/');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 28.10.2017
 * Time: 20:59
 */

namespace NTSchool\Phpblog\Core;


class Cookie
{
    public $name;
    public $value;
    public $expire;
    public $path;
    public $domain;

    public function __construct(string $name, string $value = null, $expire = 0, string $path = '/', string $domain = null)
    {
        $this->name = $name;
        $this->value = $value;

        if(!is_numeric($expire)) {
            $expire = strtotime($expire);

            if(false === $expire) {
                throw new \InvalidArgumentException('The cookie expiration time is not valid.');
            }
        }

        $this->expire = $expire;
        $this->path = $path;
        $this->domain = $domain;
    }

    public static function set($name, $value, $time){
        setcookie($name, $value, time() + $time, '/');
    }

    public static function del($name){
        setcookie($name, '', 1, '/');
    }
}
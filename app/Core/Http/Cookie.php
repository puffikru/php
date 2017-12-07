<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 28.10.2017
 * Time: 20:59
 */

namespace NTSchool\Phpblog\Core\Http;


class Cookie
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $value;

    /**
     * @var false|int|string
     */
    public $expire;

    /**
     * @var string
     */
    public $path;

    /**
     * @var string
     */
    public $domain;

    /**
     * Cookie constructor.
     *
     * @param string $name
     * @param string|null $value
     * @param int $expire
     * @param string $path
     * @param string|null $domain
     */
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

    /**
     * @param $name
     * @param $value
     * @param $time
     */
    public static function set($name, $value, $time){
        setcookie($name, $value, time() + $time, '/');
    }

    /**
     * @param $name
     */
    public static function del($name){
        setcookie($name, '', 1, '/');
    }
}
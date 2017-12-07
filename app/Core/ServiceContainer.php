<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 22.11.2017
 * Time: 23:21
 */

namespace NTSchool\Phpblog\Core;


class ServiceContainer
{
    /**
     * @var array
     */
    private $container = [];

    /**
     * @param string $name
     * @param \Closure $closure
     *
     * @return bool
     */
    public function register(string $name, \Closure $closure)
    {
        if(isset($this->container[$name])){
            // throw new Exception
            return false;
        }
        $this->container[$name] = $closure;
    }

    /**
     * @param string $name
     * @param array ...$params
     *
     * @return bool|mixed
     */
    public function get(string $name, ...$params)
    {
        if(!isset($this->container[$name])){
            // throw new Exception
            return false;
        }
        return call_user_func_array($this->container[$name], $params);
    }
}
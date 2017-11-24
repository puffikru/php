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
    private $container = [];

    public function register(string $name, \Closure $closure)
    {
        if(isset($this->container[$name])){
            // throw new Exception
            return false;
        }
        $this->container[$name] = $closure;
    }

    public function get(string $name, ...$params)
    {
        if(!isset($this->container[$name])){
            // throw new Exception
            return false;
        }
        return call_user_func_array($this->container[$name], $params);
    }
}
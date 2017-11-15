<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 12.11.2017
 * Time: 8:42
 */

namespace core;

class Router
{
    private $routes = [];

    public function get($uri, \Closure $closure)
    {
        $uri = $this->getUri($uri);
        if(isset($this->routes['GET'][$uri])){
            return false;
        }
        $this->routes['GET'][$uri] = $closure;
    }

    public function post($uri, \Closure $closure)
    {
        $uri = $this->getUri($uri);
        if(isset($this->routes['POST'][$uri])){
            return false;
        }
        $this->routes['POST'][$uri] = $closure;
    }

    public function init($uri, $params = [])
    {
        $method = $this->getMethod();
        if(!isset($this->routes[$method][$uri])){
            return false;
        }
        call_user_func_array($this->routes[$method][$uri], [$params]);
    }

    private function getMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }

    public function showRouts()
    {
        debug($this->routes);
    }

    private function getUri($uri)
    {
        $uripart = explode(':', $uri);
        return trim($uripart[0], '/');
    }

    public function getParams($uri){
        $uripart = explode(':', $uri);
        return trim($uripart[1], '/');
    }
}


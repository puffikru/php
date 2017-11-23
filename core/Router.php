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
    public $uri;
    public $params;

    public function parseUri(string $uri)
    {
        if(empty($uri)){
            return false;
        }

        $uri = explode('/', $uri);
        if($uri[0] == ''){
            unset($uri[0]);
        }
        $end = count($uri);
        if($uri[$end] == ''){
            unset($uri[$end]);
        }

        $uri = array_values($uri);

        return $uri;
    }
}


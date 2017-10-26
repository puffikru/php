<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 27.09.17
 * Time: 0:54
 */

namespace core;


class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    private $get;
    private $post;
    private $server;
    private $cookie;
    private $session;
    private $files;

    public function __construct($get, $post, $server, $cookie, $session, $files)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
        $this->cookie = $cookie;
        $this->session = $session;
        $this->files = $files;
    }

    public function get($key = null)
    {
        $get = null;
        if(!$key) {
            $get = $this->get;
        }
        if(isset($this->get[$key])) {
            $get = $this->get[$key];
        }
        return $get ?? $_GET;
    }

    public function post($key = null)
    {
        $post = null;
        if(!$key) {
            $post = $this->post;
        }
        if(isset($this->post[$key])) {
            $post = $this->post[$key];
        }
        return $post ?? $_POST;
    }

    public function server($key = null)
    {
        $server = null;
        if(!$key){
            $server = $this->server;
        }
        if(isset($this->server[$key])){
            $server = $this->server[$key];
        }
        return $server;
    }

    public function cookie($key = null)
    {
        $cookie = null;
        if(!$key){
            $cookie = $this->cookie;
        }
        if(isset($this->cookie[$key])){
            $cookie = $this->cookie[$key];
        }
        return $cookie;
    }

    public function session($key = null)
    {
        $session = null;
        if(!$key){
            $session = $this->session;
        }
        if(isset($this->session[$key])){
            $session = $this->session[$key];
        }
        return $session;
    }

    public function isPost()
    {
        return $this->server['REQUEST_METHOD'] === self::METHOD_POST;
    }

    public function isGet()
    {
        return $this->server['REQUEST_METHOD'] === self::METHOD_GET;
    }
}
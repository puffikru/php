<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 27.09.17
 * Time: 0:54
 */

namespace NTSchool\Phpblog\Core;


class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    private $get;
    private $post;
    private $server;
    private $cookie;
    private $files;

    public function __construct($get, $post, $server, $cookie, $files)
    {
        $this->get = new Bag($get);
        $this->post = new Bag($post);
        $this->server = new Bag($server);
        $this->cookie = new Bag($cookie);
        $this->files = new Bag($files);
    }

    public function get()
    {
        return $this->get;
    }

    public function post()
    {
        return $this->post;
    }

    public function server()
    {
        return $this->server;
    }

    public function cookie()
    {
        return $this->cookie;
    }

    public function isPost()
    {
        return $this->server->get('REQUEST_METHOD') === self::METHOD_POST;
    }

    public function isGet()
    {
        return $this->server->get('REQUEST_METHOD') === self::METHOD_GET;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 27.09.17
 * Time: 0:54
 */

namespace NTSchool\Phpblog\Core\Http;


use NTSchool\Phpblog\Core\Bag;

class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    /**
     * @var \NTSchool\Phpblog\Core\Bag
     */
    private $get;

    /**
     * @var \NTSchool\Phpblog\Core\Bag
     */
    private $post;

    /**
     * @var \NTSchool\Phpblog\Core\Bag
     */
    private $server;

    /**
     * @var \NTSchool\Phpblog\Core\Bag
     */
    private $cookie;

    /**
     * @var \NTSchool\Phpblog\Core\Bag
     */
    private $files;

    /**
     * Request constructor.
     *
     * @param $get
     * @param $post
     * @param $server
     * @param $cookie
     * @param $files
     */
    public function __construct($get, $post, $server, $cookie, $files)
    {
        $this->get = new Bag($get);
        $this->post = new Bag($post);
        $this->server = new Bag($server);
        $this->cookie = new Bag($cookie);
        $this->files = new Bag($files);
    }

    /**
     * @return \NTSchool\Phpblog\Core\Bag
     */
    public function get()
    {
        return $this->get;
    }

    /**
     * @return \NTSchool\Phpblog\Core\Bag
     */
    public function post()
    {
        return $this->post;
    }

    /**
     * @return \NTSchool\Phpblog\Core\Bag
     */
    public function server()
    {
        return $this->server;
    }

    /**
     * @return \NTSchool\Phpblog\Core\Bag
     */
    public function cookie()
    {
        return $this->cookie;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->server->get('REQUEST_METHOD') === self::METHOD_POST;
    }

    /**
     * @return bool
     */
    public function isGet()
    {
        return $this->server->get('REQUEST_METHOD') === self::METHOD_GET;
    }
}
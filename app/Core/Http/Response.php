<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 05.12.2017
 * Time: 17:33
 */

namespace NTSchool\Phpblog\Core\Http;

use NTSchool\Phpblog\Core\Bag;

class Response
{
    const HTTP_OK = 200;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;

    /**
     * @var array
     */
    public static $statusTexts = [
        self::HTTP_OK => 'OK',
        self::HTTP_MOVED_PERMANENTLY => 'Moved Permanently',
        self::HTTP_FOUND => 'Found',
        self::HTTP_BAD_REQUEST => 'Bad Request',
        self::HTTP_UNAUTHORIZED => 'Unauthorized',
        self::HTTP_PAYMENT_REQUIRED => 'Payment Required',
        self::HTTP_FORBIDDEN => 'Forbidden',
        self::HTTP_NOT_FOUND => 'Not Found',
        self::HTTP_METHOD_NOT_ALLOWED => 'Method Not Allowed',
        self::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error',
        self::HTTP_NOT_IMPLEMENTED => 'Not Implemented',
        self::HTTP_BAD_GATEWAY => 'Bad Gateway',
        self::HTTP_SERVICE_UNAVAILABLE => 'Service Unavailable',
        self::HTTP_GATEWAY_TIMEOUT => 'Gateway Timeout',
    ];

    /**
     * @var Bag
     */
    protected $headers;

    /**
     * Http body for response
     *
     * @var string
     */
    protected $content;

    /**
     * @var
     */
    protected $statusCode;

    /**
     * @var
     */
    protected $statusText;

    /**
     * Response constructor.
     *
     * @param string $content
     * @param int $status
     * @param array $headers
     */
    public function __construct(string $content = '', int $status = 200, array $headers = [])
    {
        $this->headers = new Bag($headers);
    }

    /**
     * @return \NTSchool\Phpblog\Core\Bag
     */
    public function headers()
    {
        return $this->headers;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param int $code
     * @param string|null $text
     *
     * @return $this
     */
    public function setStatus(int $code, string $text = null)
    {
        $this->statusCode = $code;

        if($this->isInvalid()){
            //throw new Ex
        }

        if($text === null){
            $this->statusText = isset(self::$statusTexts[$code]) ? self::$statusTexts[$code] : 'Unknown status';

            return $this;
        }

        if($text === false){
            $this->statusText = '';

            return $this;
        }

        $this->statusText = $text;

        return $this;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function redirect(string $url)
    {
        $this->headers->set('redirect', "Location: $url");
        $this->setStatus(self::HTTP_MOVED_PERMANENTLY);

        return $this;
    }

    /**
     * @param \NTSchool\Phpblog\Core\Http\Cookie $cookie
     *
     * @return $this
     */
    public function setCookie(Cookie $cookie)
    {
        setcookie($cookie->name, $cookie->value, $cookie->expire, $cookie->path, $cookie->domain);

        return $this;
    }

    /**
     * @return $this
     */
    public function sendHeaders()
    {
        if($this->headers->count() === 0){
            return $this;
        }

        if(headers_sent()){
            return $this;
        }

        foreach($this->headers->getAll() as $header){
            header($header);
        }

        header("HTTP/1.1 $this->statusCode, $this->statusText");

        return $this;
    }

    /**
     * @return $this
     */
    public function sendContent()
    {
        echo $this->content;

        return $this;
    }

    /**
     * @return $this
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }

    /**
     * @return bool
     */
    private function isInvalid() : bool
    {
        return $this->statusCode < 100 || $this->statusCode >= 600;
    }
}
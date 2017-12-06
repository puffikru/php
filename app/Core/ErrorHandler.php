<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 06.12.2017
 * Time: 11:57
 */

namespace NTSchool\Phpblog\Core;


use NTSchool\Phpblog\Controller\BaseController;
use NTSchool\Phpblog\Core\Http\Response;

class ErrorHandler implements ErrorHandlerInterface
{
    private $controller;
    private $logger;
    private $response;
    private $dev;

    public function __construct(BaseController $controller, Logger $logger, Response $response, $dev = true)
    {
        $this->controller = $controller;
        $this->logger = $logger;
        $this->response = $response;
        $this->dev = $dev;
    }

    public function handle(\Exception $e, $message)
    {
        if(isset($this->logger)){
            $this->logger->write("{$e->getMessage()}\n {$e->getTraceAsString()}", "Error");
        }

        $msg = "<h1>$message</h1>";

        if($this->dev){
            $msg = "$msg<h2>{$e->getMessage()}</h2>{$e->getTraceAsString()}";
        }

        $this->controller->staticAction($msg);
        $this->response->setContent($this->controller->getFullTemplate());
        $this->response->send();

    }
}
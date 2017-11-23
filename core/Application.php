<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 22.11.2017
 * Time: 23:42
 */

namespace core;

use controller\PostController;
use core\Exceptions\Error404;
use core\Exceptions\Fatal;
use core\providers\ModelProvider;
use core\providers\UserProvider;

class Application
{
    public $request;
    private $controller;
    private $action;
    private $container;

    public function __construct()
    {
        $this->getController();
        $this->initRequest();

        $this->container = new ServiceContainer();

        (new ModelProvider())->register($this->container);
        (new UserProvider())->register($this->container);

        $router = new Router();
        $router->parseUri($this->request->server('REQUEST_URI'));

    }

    public function run()
    {
        try {
            $controller = new $this->controller($this->request, $this->container);
            $action = $this->action;
            $controller->$action();
            $controller->render();
        }catch(Error404 $e) {
            header("HTTP/1.0 404 Not Found");
            $controller = new PostController($this->request, $this->container);
            if(DEV_MODE) {
                $controller->error404($e);
                $controller->render();
            }else {
                $controller->error404();
                $controller->render();
            }
        }catch(Fatal $e) {
            $controller = new PostController($this->request, $this->container);
            if(DEV_MODE) {
                $controller->error404($e);
                $controller->render();
            }else {
                $controller->error503();
                $controller->render();
            }
        }
    }

    private function getController()
    {
        $qstring = $_GET['qstring'] ?? null;
        $params = explode('/', $qstring);
        $end = count($params) - 1;

        if($params[$end] === '') {
            unset($params[$end]);
        }

        $this->controller = '';
        $this->action = 'indexAction';
        $id = '';

        if(isset($params[0]) && $params[0] !== '') {
            $this->controller = trim('controller\\' . ucfirst($params[0]) . 'Controller');
        }else {
            $this->controller = 'controller\PostController';
        }

        if(isset($params[0])) {
            if(!file_exists('controller/' . ucfirst($params[0]) . 'Controller.php')) {
                // throw new Exception
            }
        }

        if(isset($params[1]) && $params !== '') {
            if(!is_numeric($params[1])) {
                $exp = explode('-', $params[1]);
                for($i = 1; $i < count($exp); $i++) {
                    if(!isset($exp[$i])) {
                        $exp = $exp[0];
                    }
                    $exp[$i] = ucfirst($exp[$i]);
                }
                $exp = implode('', $exp);

                $this->action = trim($exp) . 'Action';

                $id = $params[2] ?? null;

            }else {
                $this->action = 'oneAction';
                $id = $params[1];
            }
        }

        if($id) {
            $_GET['id'] = $id;
        }
    }

    private function initRequest()
    {
        $this->request = new Request($_GET, $_POST, $_SERVER, $_COOKIE, $_SESSION, $_FILES);
    }
}
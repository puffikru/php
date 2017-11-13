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

    public function addRoute($uri, \Closure $closure){
        $this->routes[$uri] = $closure;
    }

    public function getAllRoutes(){
        debug($this->routes);
    }

    public function init($uri){
        $parsedUri = $this->parseUri($uri);
        $method = $this->checkRequestMethod();

        switch($method){
            case "GET":
                $this->get($uri, $this->routes[$parsedUri['uri']], [$parsedUri['user']]);
                break;
            case "POST":
                $this->post($uri, $this->routes[$parsedUri['uri']], [$parsedUri['user']]);
                break;
            default:
                die('Error method');
        }
    }

    private function checkRequestMethod(){
        $method = $_SERVER['REQUEST_METHOD'];
        return $method;
    }

    private function get($uri, \Closure $closure, $params  = []){
        echo "Запрос направлени методом GET <br>";
        echo $uri . "<br>";
        call_user_func_array($closure, $params);
    }

    private function post($uri, \Closure $closure, $params = []){
        echo "Запрос направлен методом POST <br>";
        echo $uri . "<br>";
        call_user_func_array($closure, $params);
    }

    private function parseUri($uri){
        $getName = explode(':', $uri);
        $arr = [];
        if(count($getName) > 1){
            $arr['user'] = $getName[1];
            $uri_string = explode('/', $getName[0]);
            $end = count($uri_string) - 1;
            if($uri_string[$end] === ''){
                unset($uri_string[$end]);
            }
            if($uri_string[0] === ''){
                unset($uri_string[0]);
            }
            $arr['uri'] = $uri_string[1];
        }else{
            $uri_string = explode('/', $uri);
            $end = count($uri_string) - 1;
            if($uri_string[$end] === ''){
                unset($uri_string[$end]);
            }
            if($uri_string[0] === ''){
                unset($uri_string[0]);
            }
            $arr['uri'] = $uri_string[1];
        }

        return $arr ?? null;
    }

    public static function greeting($user){
        if($user){
            echo "Привет " . ucfirst($user) . "!";
        }else{
            echo "Привет гость!";
        }
    }
}

$route = new Router();
$route->addRoute('post', function($user = ''){
    echo "Список статей <br>";
    Router::greeting($user);
});

$route->addRoute('texts', function($user = ''){
    echo "Список текстов <br>";
    Router::greeting($user);
});

$route->addRoute('user', function($user = ''){
    echo "Пользователи <br>";
    Router::greeting($user);
});

$route->getAllRoutes();

$query = $_SERVER['REQUEST_URI'];

$route->init($query);


/*class Router
{
    private $routes = [];
    protected $user;

    public function addRoute(string $uri, \Closure $closure){
        if($this->routes[$uri]){
            return false;
        }

        $this->routes[$uri] = $closure;
    }

    public function init(string $uri, $params){
        //TODO: Доделать обработку методов GET и POST

        $type = $this->getType($params['REQUEST_METHOD'], $params['QUERY_STRING']);
        $arr = explode(':', $uri);

        if(gettype($arr) == 'array'){
            $uri = $arr[0];
            $this->user = $arr[1];
        }

        if(!$type){
            return false;
        }

        $data = [];

        if(!empty($this->user)){
            $data['name'] = $this->user;
        }else{
            $data['name'] = 'гость';
        }

        if(!$this->routes[$uri]){
            return false;
        }

        call_user_func_array($this->routes[$uri], $data);
    }

    public function showRouts(){
        return $this->routes;
    }

    public function get($param = ''){
        if(!empty($param)){
            $param = explode('=', $param);
        }else{

            return $_GET;
        }

        if(!isset($_GET[$param[0]])){
            return $_GET;
        }

        return $_GET[$param[0]];
    }

    public function post($param){
        if(!isset($_POST[$param])){
            return false;
        }

        return $_POST[$param];
    }

    public function getType($name, $param = ''){
        switch($name){
            case "GET":
                return $this->get($param);
                break;
            case "POST":
                return $this->post($param);
                break;
            default:
                return false;
        }
    }
}

$router = new Router();

$router->addRoute('/', function($param = '', $query = ''){
    echo "Main page<br>";
});

$router->addRoute('/posts/', function($param = '', $query = ''){
    echo "Posts page<br>";
});

$router->addRoute('/posts/6', function($param = '', $query = ''){
    echo "Post № 6<br>";
});

$router->addRoute('/admin/', function($name){

    if(isset($name)) {
        echo "Привет " . ucfirst($name) . "!";
    }
});

echo $router->init('/', $_SERVER);
echo $router->init('/posts/', $_SERVER);
echo $router->init('/posts/6', $_SERVER);
$query  = $_SERVER['REQUEST_URI'];
echo $router->init($query, $_SERVER);*/

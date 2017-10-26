<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 26.10.2017
 * Time: 22:32
 */
<?php
session_start();

include_once "config.php";
include_once "autoload.php";

$qstring = $_GET['qstring'] ?? null;
$params = explode('/', $qstring);
$end = count($params) - 1;
$err404 = false;

if($params[$end] === '') {
    unset($params[$end]);
}

$controller = '';
$action = 'indexAction';
$id = '';


if(isset($params[0]) && $params[0] !== '') {
    $controller = trim('controller\\' . ucfirst($params[0]) . 'Controller');
}else {
    $controller = 'controller\PostController';
}

if(isset($params[0])) {
    if(!file_exists('controller/' . ucfirst($params[0]) . 'Controller.php')) {
        $err404 = true;
    }
}

if(isset($params[1]) && $params !== '') {
    if(!is_numeric($params[1])) {
        $action = trim($params[1]) . 'Action';
        $id = $params[2] ?? null;

    }else {
        $action = 'oneAction';
        $id = $params[1];
    }
}

if($id) {
    $_GET['id'] = $id;
}


$request = new \core\Request($_GET, $_POST, $_SERVER, $_COOKIE, $_SESSION, $_FILES);

try {
    $controller = new $controller($request);
    $controller->$action();
    $controller->render();
}catch(\core\Exceptions\Error404 $e) {
    header("HTTP/1.0 404 Not Found");
    $controller = new controller\PostController($request);
    if(DEV_MODE == 0){
        $controller->error404($e);
        $controller->render();
    }else{
        $controller->error404();
        $controller->render();
    }
}catch(\core\Exceptions\Fatal $e) {
    $controller = new controller\PostController($request);
    if(DEV_MODE == 0){
        $controller->error404($e);
        $controller->render();
    }else{
        $controller->error503();
        $controller->render();
    }
}catch(\Exception $e){
    echo "Все пропало!";
}

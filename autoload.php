<?php

spl_autoload_register(function($classname){
    $file = str_replace('\\', '/', $classname) . '.php';
    if(is_file($file)){
        include_once $file;
    }else{
        throw new \core\Exceptions\Error404("class $classname not found!");
    }
});

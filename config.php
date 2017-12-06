<?php

define('ROOT', '/');
define('CHARSET', 'UTF-8');
define('LOG_DIR', 'app/logs');
define('DEV_MODE', 1);
define('FORM_SIGN', '/#@=@/');

// locale is RU excluding numeric
setlocale(LC_ALL, 'ru_RU.UTF-8');
setlocale(LC_NUMERIC, 'C');

// time zone is Moscow
date_default_timezone_set('Europe/Moscow');

if(!DEV_MODE){
    // display errors
    ini_set('display_errors', true);
    // errors are equals to all except notices
    Error_Reporting(E_ALL & ~E_NOTICE);
}

function debug($name){
    echo "<pre>";
    print_r($name);
    echo "</pre>";
}
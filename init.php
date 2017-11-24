<?php
include_once "config.php";
session_start();

// display errors
ini_set('display_errors', true);

// errors are equals to all except notices
Error_Reporting(E_ALL & ~E_NOTICE);

// locale is RU excluding numeric
setlocale(LC_ALL, 'ru_RU.UTF-8');
setlocale(LC_NUMERIC, 'C');

// time zone is Moscow
date_default_timezone_set('Europe/Moscow');

// autoload classes
include_once("vendor/autoload.php");


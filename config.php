<?php

const ROOT = '/';
const CHARSET = 'UTF-8';
const LOG_DIR = 'logs';
const DEV_MODE = 0;

function debug($name){
    echo "<pre>";
    print_r($name);
    echo "</pre>";
}
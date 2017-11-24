<?php
require_once "init.php";
try {
    NTSchool\Phpblog\Core\Core::instance()->run();
}catch(\NTSchool\Phpblog\Core\Exceptions\Error404 $e){
    echo $e->getMessage();
}
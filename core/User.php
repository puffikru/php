<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 28.10.2017
 * Time: 3:41
 */

namespace core;


use core\Exceptions\ValidateException;
use model\Sessions;
use model\Users;

class User
{
    private $mUser;
    private $mSession;

    public function __construct(Users $mUser, Sessions $mSession)
    {
        $this->mUser = $mUser;
        $this->mSession = $mSession;
    }

    public function signUp(array $fields)
    {
        if(!$this->comparePass($fields)){
            throw new ValidateException('Пароли не совпадают');
        }else{
            unset($fields['pass_confirm']);
            $this->mUser->signUp($fields);
        }
    }

    public function login(array $fields)
    {

    }

    public function isAuth(){

    }

    private function getHash($pass){
        return hash('sha256', $pass . SALT);
    }

    private function comparePass($password)
    {
        if($password['pass'] == $password['pass_confirm']){
            return true;
        }
    }

    private function sid(){
        $pattern = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $sid = '';
        for($i = 0; $i < 10; $i++){
            $letter = mt_rand(0, strlen($pattern) - 1);
            $sid .= $pattern[$letter];
        }
        return $sid;
    }

}
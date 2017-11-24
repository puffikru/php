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
    private $request;
    private $db;

    public function __construct(Users $mUser, Sessions $mSession, Request $request)
    {
        $this->mUser = $mUser;
        $this->mSession = $mSession;
        $this->request = $request;
        $this->db = new DBDriver();
    }

    public function signUp(array $fields)
    {
        if(!$this->comparePass($fields)){
            throw new ValidateException(['Пароли не совпадают']);
        }
        unset($fields['pass_confirm']);

        $this->mUser->signUp($fields);
    }

    public function login(array $fields)
    {
        $this->mUser->login($fields);
    }

    public function isAuth()
    {
        return $this->mUser->isAuth($this->request, $this->mSession);
    }

    private function comparePass($password)
    {
        if($password['pass'] == $password['pass_confirm']){
            return true;
        }
        return false;
    }

    public function logOut()
    {
        $this->mUser->logout();
    }
}
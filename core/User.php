<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 28.10.2017
 * Time: 3:41
 */

namespace core;


use model\Users;

class User
{
    private $mUser;

    public function __construct(Users $mUser)
    {
        $this->mUser = $mUser;
    }

    public function signUp(array $fields)
    {
        if(!$this->comparePass($fields)){
            throw new \Exception('Пароли не совпадают');
        }else{
            unset($fields['pass_confirm']);
            $this->mUser->signUp($fields);
        }
    }

    private function comparePass($password){
        if($password['pass'] == $password['pass_confirm']){
            return true;
        }
    }
}
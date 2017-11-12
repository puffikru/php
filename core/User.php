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
            throw new ValidateException('Пароли не совпадают');
        }
        unset($fields['pass_confirm']);
        $this->db->insert('users', [
            'name' => $fields['name'],
            'login' => $fields['login'],
            'pass' => $this->getHash($fields['pass'])
        ]);
        unset($fields['name']);
        $this->login($fields);
    }

    public function login(array $fields)
    {
        $user = $this->mUser->getByLogin($fields['login']);

        if(!$user){
            throw new ValidateException('Такого пользователя не существует!');
        }

        if($this->getHash($fields['pass']) !== $user['pass']){
            throw new ValidateException('Введен неверный пароль!');
        }

        if(isset($fields['remember'])){
            Cookie::set('login', $fields['login'], 3600 * 24 * 7);
            Cookie::set('pass', $this->getHash($fields['password']), 3600 * 24 * 7);
        }

        $token = $this->generateSid();
        $this->mSession->openSession($user['id_user'], $token);

        if(isset($_SESSION['returnUrl'])) {
            header('Location:' . $_SESSION['returnUrl']);
            unset($_SESSION['returnUrl']);
        }else {
            header('Location: ' . ROOT);
        }

        return true;
    }

    public function isAuth()
    {
        $sid = $this->request->session('sid');
        $login = $this->request->cookie('login');

        if(!$sid && !$login){
            return false;
        }

        if($sid){
            $user = $this->mUser->getBySid($sid);
            if($user){
                $this->mSession->edit($user['id_session'], [
                    'time_last' => date("Y-m-d H:i:s")
                ]);
                return true;
            }
        }else {

            if($login) {
                $user = $this->mUser->getByLogin($login);
                if($user) {
                    $token = $this->generateSid();
                    $this->mSession->openSession($user['id_user'], $token);
                    return true;
                }
            }
        }
        return false;
    }

    private function comparePass($password)
    {
        if($password['pass'] == $password['pass_confirm']){
            return true;
        }
        return false;
    }

    private function getHash($pass)
    {
        return hash('sha256', $pass . SALT);
    }

    private function generateSid($number = 10)
    {
        $pattern = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        for($i = 0; $i < $number; $i++){
            $code .= $pattern[mt_rand(0, strlen($pattern) - 1)];
        }
        return $code;
    }

    public function logOut()
    {
        $session = new Session();
        $session->del('sid');
        Cookie::del('login');
        Cookie::del('pass');
    }
}
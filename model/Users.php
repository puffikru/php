<?php

namespace model;

use core\Cookie;
use core\Session;

class Users extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
        $this->pk = 'id_user';
    }

    public function getByLogin($login)
    {
        $query = $this->db->select("SELECT * FROM {$this->table} WHERE login= :login", ['login' => $login]);
        return $query[0] ?? null;
    }

    public function validationMap()
    {
        return [
            'fields' => ['login', 'pass', 'name'],
            'not_empty' => ['login', 'pass'],
            'min_length' => [
                'login' => 5,
                'pass' => 6
            ]
        ];
    }

    public function signUp(array $fields)
    {
        $this->validation->execute($fields);
        if(!$this->validation->success()){
            throw new \Exception($this->validation->errors()[0]);
        }
        return $this->add(
            [
                'login' => $fields['login'],
                'pass' => $this->getHash($fields['pass'])
            ]
        );
    }

    public function login(array $fields)
    {
        $this->validation->execute($fields);
        if(!$this->validation->success()){
            throw new \Exception($this->validation->errors()[0]);
        }
        $user = $this->getByLogin($fields['login']);

        if(!$user){
            return false;
        }

        if($this->getHash($fields['password']) == $user['pass']){
            $session = new Session();
            $session->set('login', $fields['login']);
            $session->set('pass', $this->getHash($fields['password']));
            $session->set('isAuth', true);

            if(isset($fields['remember'])){
                Cookie::set('login', $fields['login'], 3600 * 24 * 7);
                Cookie::set('pass', $this->getHash($fields['password']), 3600 * 24 * 7);
            }

            if(isset($_SESSION['returnUrl'])) {
                header('Location:' . $_SESSION['returnUrl']);
                unset($_SESSION['returnUrl']);
                exit();

            }else {

                header('Location: ' . ROOT);
                exit();

            }
        }else{
            throw new \Exception('Введненные данные неверны. Попробуйте снова.');
        }

    }

    public static function isAuth()
    {
        $isAuth = false;

        if(isset($_SESSION['isAuth']) && $_SESSION['isAuth']) {

            $isAuth = true;

        }elseif(isset($_COOKIE['login']) && isset($_COOKIE['pass'])) {

            if($_COOKIE['login'] == $_SESSION['login'] && $_COOKIE['pass'] == self::getHash($_SESSION['pass'])) {

                $_SESSION['isAuth'] = true;
                $isAuth = true;
            }
        }
        return $isAuth;
    }

    public function logout()
    {
        $session = new Session();
        $session->del('login');
        $session->del('pass');
        $session->del('isAuth');
        Cookie::del('login');
        Cookie::del('pass');
    }

    private function getHash($pass){
        return hash('sha256', $pass . SALT);
    }

}
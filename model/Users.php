<?php

namespace model;

use core\Request;
use core\Exceptions\ValidateException;
use core\User;

class Users extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
        $this->pk = 'id_user';
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

    public function signUp(array $fields, Sessions $session, Request $request)
    {
        $this->validation->execute($fields);
        if(!$this->validation->success()){
            throw new ValidateException($this->validation->errors()[0]);
        }

        $user = new User($this, $session, $request);
        $user->signUp($fields);
    }

    public function login(array $fields, Sessions $session, Request $request)
    {
        $this->validation->execute($fields);
        if(!$this->validation->success()){
            throw new ValidateException($this->validation->errors()[0]);
        }

        $user = new User($this, $session, $request);
        $user->login($fields);

    }

    public function isAuth(Sessions $session, Request $request)
    {
        $user = new User($this, $session, $request);
        return $user->isAuth();
    }

    public function getByLogin($login)
    {
        $query = $this->db->select("SELECT * FROM {$this->table} WHERE login= :login", ['login' => $login]);
        return $query[0] ?? null;
    }

    public function getBySid($sid){
        $query = $this->db->select("SELECT * FROM {$this->table} JOIN sessions USING($this->pk) WHERE sid=:sid", ['sid' => $sid]);
        return $query[0] ?? null;
    }

    public function logout()
    {
        /*$session = new Session();
        $session->del('login');
        $session->del('pass');
        $session->del('isAuth');
        Cookie::del('login');
        Cookie::del('pass');*/
    }

    /*private function getHash($pass){
        return hash('sha256', $pass . SALT);
    }*/

}
<?php

namespace model;

class Users extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
        $this->pk = 'id_user';
    }

    public function getOne($login)
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

    private function getHash($pass){
        return hash('sha256', $pass . SALT);
    }

}
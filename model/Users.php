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

    public function validationMap(){
        return [
            'fields' => ['login', 'pass', 'name']
        ];
    }

}
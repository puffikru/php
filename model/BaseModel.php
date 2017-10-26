<?php

namespace model;

use core\DBDriver;
use core\Validation;

abstract class BaseModel
{
    protected $db;
    protected $table;
    protected $pk;
    protected $validation;

    public function __construct()
    {
        $this->db = DBDriver::instance();
        $this->validation = new Validation();
        $this->validation->setRules($this->validationMap());
    }

    public abstract function validationMap();

    public function all()
    {
        return $this->db->select("SELECT * FROM {$this->table}");
    }

    public function one($pk)
    {
        $res = $this->db->select("SELECT * FROM {$this->table} WHERE {$this->pk} = :pk", ['pk' => $pk]);
        return $res[0] ?? null;
    }

    public function add($obj)
    {
        $this->validation->execute($obj);
        if($this->validation->success()) {
            return $this->db->insert($this->table, $this->validation->clean());
        }else{
            return $this->validation->errors();
        }
    }

    public function edit($pk, $obj)
    {
        $this->validation->execute($obj);
        if($this->validation->success()) {
            return $this->db->update($this->table, $obj, "{$this->pk}=:pk", ['pk' => $pk]);
        }else{
            return $this->validation->errors();
        }
    }

    public function delete($pk)
    {
        return $this->db->delete($this->table, "{$this->pk} = :pk", ['pk' => $pk]);
    }


}
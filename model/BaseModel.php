<?php

namespace model;

use core\DBDriver;
use core\Exceptions\ValidateException;
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

    public function add($obj, $needValidation = true)
    {

        if($needValidation){
            $this->validation->execute($obj);
            if($this->validation->success()) {
                $obj =  $this->validation->clean();
            }else{
                throw new ValidateException($this->validation->errors());
            }
        }

        return $this->db->insert($this->table, $obj);

    }

    public function edit($pk, array $obj)
    {
        $this->validation->execute($obj);

        if($this->validation->success()) {
            return $this->db->update($this->table, $obj, "{$this->pk}=:pk", ['pk' => $pk]);
        }else{
            throw new ValidateException($this->validation->errors());
        }
    }

    public function delete($pk)
    {
        return $this->db->delete($this->table, "{$this->pk} = :pk", ['pk' => $pk]);
    }


}
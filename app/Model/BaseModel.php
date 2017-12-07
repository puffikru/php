<?php

namespace NTSchool\Phpblog\Model;

use NTSchool\Phpblog\Core\DBDriver;
use NTSchool\Phpblog\Core\Exceptions\ValidateException;
use NTSchool\Phpblog\Core\Validation;

abstract class BaseModel
{
    /**
     * @var DBDriver
     */
    protected $db;

    /**
     * @var
     */
    protected $table;

    /**
     * @var
     */
    protected $pk;

    /**
     * @var \NTSchool\Phpblog\Core\Validation
     */
    protected $validation;

    /**
     * BaseModel constructor.
     */
    public function __construct()
    {
        $this->db = DBDriver::instance();
        $this->validation = new Validation();
        $this->validation->setRules($this->validationMap());
    }

    /**
     * @return mixed
     */
    public abstract function validationMap();

    /**
     * @return array
     */
    public function all()
    {
        return $this->db->select("SELECT * FROM {$this->table}");
    }

    /**
     * @param $pk
     *
     * @return null
     */
    public function one($pk)
    {
        $res = $this->db->select("SELECT * FROM {$this->table} WHERE {$this->pk} = :pk", ['pk' => $pk]);
        return $res[0] ?? null;
    }

    /**
     * @param array $obj
     * @param bool $needValidation
     *
     * @return string
     * @throws \NTSchool\Phpblog\Core\Exceptions\ValidateException
     */
    public function add(array $obj, $needValidation = true)
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

    /**
     * @param $pk
     * @param array $obj
     *
     * @return int
     * @throws \NTSchool\Phpblog\Core\Exceptions\ValidateException
     */
    public function edit($pk, array $obj)
    {
        $this->validation->execute($obj);

        if($this->validation->success()) {
            return $this->db->update($this->table, $obj, "{$this->pk}=:pk", ['pk' => $pk]);
        }else{
            throw new ValidateException($this->validation->errors());
        }
    }

    /**
     * @param $pk
     *
     * @return bool
     */
    public function delete($pk)
    {
        return $this->db->delete($this->table, "{$this->pk} = :pk", ['pk' => $pk]);
    }


}
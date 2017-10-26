<?php

namespace core;


use core\Exceptions\Fatal;

class DBDriver
{
    use \core\traits\Singleton;
    protected $db;

    public function __construct()
    {
        $this->db = new \PDO('mysql:host=' . Settings::HOST . ';dbname=' . Settings::DBNAME, Settings::LOGIN, Settings::PASS);
        $this->db->exec('SET NAMES UTF8');
    }

    public function select($sql, $params = [])
    {
        $query = $this->db->prepare($sql);
        $query->execute($params);
        $this->check_error($query);
        return $query->fetchAll();
    }

    public function insert($table, $obj)
    {
        $keys = [];
        $masks = [];
        foreach($obj as $k => $v) {
            $keys[] = $k;
            $masks[] = ':' . $k;
        }
        $fields = implode(', ', $keys);
        $values = implode(', ', $masks);

        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $query = $this->db->prepare($sql);
        $query->execute($obj);
        $this->check_error($query);
        return $this->db->lastInsertId();
    }

    public function update($table, $obj, $where, $params = [])
    {
        $pairs = [];

        foreach($obj as $k => $v) {
            $pairs[] = "$k= :$k";
        }

        $pairs_str = implode(',', $pairs);
        $sql = "UPDATE $table SET $pairs_str WHERE $where";

        $merge = array_merge($obj, $params);
        $query = $this->db->prepare($sql);
        $query->execute($merge);
        $this->check_error($query);

        return $query->rowCount();
    }

    public function delete($table, $where, $params = [])
    {
        $sql = "DELETE FROM $table WHERE $where";
        $query = $this->db->prepare($sql);
        $query->execute($params);
        $this->check_error($query);
        return true;
    }

    private function check_error($query)
    {
        if($query->errorCode() != \PDO::ERR_NONE) {
            throw new Fatal($query->errorInfo()[2]);
        }
    }

    public function query($sql, $params = [])
    {

        $query = $this->db->prepare($sql);
        $query->execute($params);

        $this->check_error($query);

        return $query;
    }
}
<?php

namespace NTSchool\Phpblog\Core;


use NTSchool\Phpblog\Core\Exceptions\Fatal;

class DBDriver
{
    use Traits\Singleton;

    /**
     * @var \PDO
     */
    protected $db;

    /**
     * DBDriver constructor.
     */
    public function __construct()
    {
        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];
        $this->db = new \PDO('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASS'), $opt);
        $this->db->exec('SET NAMES UTF8');
    }

    /**
     * @param $sql
     * @param array $params
     *
     * @return array
     */
    public function select($sql, $params = [])
    {
        $query = $this->db->prepare($sql);
        $query->execute($params);
        $this->check_error($query);
        return $query->fetchAll();
    }

    /**
     * @param $table
     * @param $obj
     *
     * @return string
     */
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

    /**
     * @param $table
     * @param $obj
     * @param $where
     * @param array $params
     *
     * @return int
     */
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

    /**
     * @param $table
     * @param $where
     * @param array $params
     *
     * @return bool
     */
    public function delete($table, $where, $params = [])
    {
        $sql = "DELETE FROM $table WHERE $where";
        $query = $this->db->prepare($sql);
        $query->execute($params);
        $this->check_error($query);
        return true;
    }

    /**
     * @param $query
     *
     * @throws \NTSchool\Phpblog\Core\Exceptions\Fatal
     */
    private function check_error($query)
    {
        if($query->errorCode() != \PDO::ERR_NONE) {
            throw new Fatal($query->errorInfo()[2]);
        }
    }

    /**
     * @param $sql
     * @param array $params
     *
     * @return \PDOStatement
     */
    public function query($sql, $params = [])
    {

        $query = $this->db->prepare($sql);
        $query->execute($params);

        $this->check_error($query);

        return $query;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 31.10.2017
 * Time: 2:51
 */

namespace NTSchool\Phpblog\Model;


use NTSchool\Phpblog\Core\Session;

class Sessions extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'sessions';
        $this->pk = 'id_session';
    }

    public function validationMap()
    {
        return [
            'fields' => ['id_user', 'sid'],
            'not_empty' => ['id_user', 'sid']
        ];
    }

    public function getBySid($sid)
    {
        return $this->db->select("SELECT * FROM {$this->table} WHERE 'sid' = :sid", ['sid' => $sid]);
    }

    public function openSession($id_user, $sid)
    {
        $now = date("Y-m-d H:i:s");
        $obj = [];
        $obj['id_user'] = $id_user;
        $obj['sid'] = $sid;
        $obj['time_start'] = $now;
        $obj['time_last'] = $now;
        $this->db->insert('sessions', $obj);

        $session = new Session();
        $session->set('sid', $sid);

        return $sid;
    }

    public function clearSessions()
    {
        $min = date('Y-m-d H:i:s', time() - 60 * 20);
        $where = "time_last < :time";
        $this->db->delete('sessions', $where, ['time' => $min]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 31.10.2017
 * Time: 2:51
 */

namespace model;


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

    public function getBySid(){

    }
}
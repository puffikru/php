<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 06.12.2017
 * Time: 1:55
 */

namespace NTSchool\Phpblog\Model;


class RoleModel extends BaseModel
{
    /**
     * RoleModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = 'roles';
        $this->pk = 'id_role';
    }

    /**
     * @return array
     */
    public function validationMap()
    {
        return ['fields' => ['name', 'description'], 'not_empty' => ['name', 'description']];
    }


    /**
     * @param int $userId
     *
     * @return null
     */
    public function checkPriv(int $userId)
    {
        $sql = "SELECT 
    `users`.`id_user`,
    `privs`.`id_priv`,
    `users`.`name` AS user_name,
	`privs`.`name` AS priv_name,
    `roles`.`name` AS role_name
    FROM `privs`
    JOIN `priv2roles` 
    	ON `privs`.`id_priv`=`priv2roles`.`id_priv`
    JOIN `roles` 
    	ON `priv2roles`.`id_role`=`roles`.`id_role`
    JOIN `users`
    	ON `users`.`id_role`=`roles`.`id_role`
    WHERE `users`.`id_user`= :id";

        $res = $this->db->select($sql, ['id' => $userId]);

        return $res[0] ?? null;
    }
}
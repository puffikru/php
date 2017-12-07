<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 28.10.2017
 * Time: 3:41
 */

namespace NTSchool\Phpblog\Core;

use NTSchool\Phpblog\Core\Exceptions\ValidateException;
use NTSchool\Phpblog\Core\Http\Request;
use NTSchool\Phpblog\Model\RoleModel;
use NTSchool\Phpblog\Model\Sessions;
use NTSchool\Phpblog\Model\Users;
use NTSchool\Phpblog\Core\Http\Session;

class User
{
    /**
     * @var \NTSchool\Phpblog\Model\Users
     */
    private $mUser;

    /**
     * @var \NTSchool\Phpblog\Model\Sessions
     */
    private $mSession;

    /**
     * @var \NTSchool\Phpblog\Core\Http\Request
     */
    private $request;

    /**
     * @var \NTSchool\Phpblog\Core\Http\Session
     */
    private $session;

    /**
     * @var \NTSchool\Phpblog\Model\RoleModel
     */
    private $mRole;

    /**
     * @var \NTSchool\Phpblog\Core\DBDriver
     */
    private $db;

    /**
     * @var null
     */
    protected $current = null;

    /**
     * User constructor.
     *
     * @param \NTSchool\Phpblog\Model\Users $mUser
     * @param \NTSchool\Phpblog\Model\Sessions $mSession
     * @param \NTSchool\Phpblog\Core\Http\Request $request
     * @param \NTSchool\Phpblog\Core\Http\Session $session
     * @param \NTSchool\Phpblog\Model\RoleModel $mRole
     */
    public function __construct(Users $mUser, Sessions $mSession, Request $request, Session $session, RoleModel $mRole)
    {
        $this->mUser = $mUser;
        $this->mSession = $mSession;
        $this->request = $request;
        $this->session = $session;
        $this->mRole = $mRole;
        $this->db = new DBDriver();
    }

    /**
     * @param array $fields
     *
     * @throws \NTSchool\Phpblog\Core\Exceptions\ValidateException
     */
    public function signUp(array $fields)
    {
        if(!$this->comparePass($fields)){
            throw new ValidateException(['Пароли не совпадают']);
        }

        $this->mUser->signUp($fields);
    }

    /**
     * @param array $fields
     */
    public function login(array $fields)
    {
        $this->mUser->login($fields);
    }

    /**
     * @return bool
     */
    public function isAuth()
    {
        return $this->mUser->isAuth($this->request, $this->mSession, $this->session, $this);
    }

    /**
     * @return bool|null
     */
    public function checkAccess()
    {
        if(!$this->current){
            return false;
        }

        return $this->mRole->checkPriv($this->current['id_user']);
    }

    /**
     * @param $user
     */
    public function setCurrent($user)
    {
        $this->current = $user;
    }

    /**
     * @return null
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param $password
     *
     * @return bool
     */
    private function comparePass($password)
    {
        if($password['pass'] == $password['pass_confirm']){
            return true;
        }
        return false;
    }

    /**
     *
     */
    public function logOut()
    {
        $this->mUser->logout();
    }
}
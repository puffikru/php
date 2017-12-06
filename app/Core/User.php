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
    private $mUser;
    private $mSession;
    private $request;
    private $session;
    private $mRole;

    private $db;

    protected $current = null;

    public function __construct(Users $mUser, Sessions $mSession, Request $request, Session $session, RoleModel $mRole)
    {
        $this->mUser = $mUser;
        $this->mSession = $mSession;
        $this->request = $request;
        $this->session = $session;
        $this->mRole = $mRole;
        $this->db = new DBDriver();
    }

    public function signUp(array $fields)
    {
        if(!$this->comparePass($fields)){
            throw new ValidateException(['Пароли не совпадают']);
        }
        unset($fields['pass_confirm']);

        $this->mUser->signUp($fields);
    }

    public function login(array $fields)
    {
        $this->mUser->login($fields);
    }

    public function isAuth()
    {
        return $this->mUser->isAuth($this->request, $this->mSession, $this->session, $this);
    }

    public function checkAccess()
    {
        if(!$this->current){
            return false;
        }

        return $this->mRole->checkPriv($this->current['id_user']);
    }

    public function setCurrent($user)
    {
        $this->current = $user;
    }

    public function getCurrent()
    {
        return $this->current;
    }

    private function comparePass($password)
    {
        if($password['pass'] == $password['pass_confirm']){
            return true;
        }
        return false;
    }

    public function logOut()
    {
        $this->mUser->logout();
    }
}
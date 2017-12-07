<?php

namespace NTSchool\Phpblog\Controller;

use NTSchool\Phpblog\Core\Exceptions\ValidateException;
use NTSchool\Phpblog\Core\Forms\FormBuilder;
use NTSchool\Phpblog\Forms\SignIn;
use NTSchool\Phpblog\Forms\SignUp;

class UserController extends BaseController
{
    public function signUpAction()
    {
        $form = new SignUp();
        $formBuilder = new FormBuilder($form);

        $user = $this->container->get('service.user', $this->request);
        $user->isAuth();
        $access = $user->checkAccess();

        if($this->request->isPost()) {
            try {
                $user->signUp($form->handleRequest($this->request));
                $this->response->redirect(ROOT);
            }catch(ValidateException $e) {
                $form->addErrors($e->getErrors());
            }

        }

        $this->menu = $this->build('v_menu', ['access' => $access]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->title = 'Регистрация';
        $this->content = $this->build('v_signup', ['form' => $formBuilder]);
    }

    public function loginAction()
    {
        $this->container->get('models', 'Sessions')->clearSessions();
        $form = new SignIn();
        $formBuilder = new FormBuilder($form);
        $user = $this->container->get('service.user', $this->request);
        $user->isAuth();
        $access = $user->checkAccess();

        if($this->request->isPost()){
            try {
                $user->login($form->handleRequest($this->request));
                $this->response->redirect(ROOT);
            }catch(ValidateException $e){
                $form->addErrors($e->getErrors());
            }
        }

        $this->menu = $this->build('v_menu', ['access' => $access]);
        $this->content = $this->build('v_login', ['form' => $formBuilder]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->title = 'Авторизация';
    }

    public function logoutAction()
    {
        $this->container->get('service.user', $this->request)->logOut();
        $this->response->redirect(ROOT);
    }

    public function listAction()
    {
        $mUser = $this->container->get('models', 'Users');

        $user = $this->container->get('service.user', $this->request);
        $user->isAuth();
        $access = $user->checkAccess();
        $all = $mUser->getAllUsers();
        $roles = $this->container->get('models', 'RoleModel')->all();

        if(!$access){
            $this->response->redirect(ROOT);
            exit();
        }

        $this->menu = $this->build('v_menu', ['access' => $access]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->title = 'Пользователи';
        $this->content = $this->build('v_users', ['all' => $all, 'header' => $this->title, 'roles' => $roles]);
    }
}
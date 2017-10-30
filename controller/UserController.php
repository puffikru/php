<?php

namespace controller;


use core\User;
use model\Texts;
use model\Users;

class UserController extends FrontController
{
    public function signUpAction()
    {
        $text = new Texts();
        $errors = '';

        if($this->request->isPost()) {
            $mUser = new Users();

            $user = new User($mUser);

            try {
                $user->signUp($this->request->post());
                header('Location:' . ROOT);
            }catch(\Exception $e) {
                $errors = $e->getMessage();
            }

        }


        $this->menu = $this->build('v_menu');
        $this->sidebar = $this->build('v_left');
        $this->texts = $text->getTexts() ?? null;
        $this->title = 'Регистрация';
        $this->content = $this->build('v_signup', ['errors' => $errors]);
    }

    public function loginAction()
    {
        $text = new Texts();
        $errors = '';

        if(isset($_GET['auth'])) {
            if($_GET['auth'] === 'off') {
                throw new \Exception('У вас нет прав для просмотра данной страницы!');
            }
        }

        if($this->request->isPost()){
            $mUser = new Users();

            try {
                $mUser->login($this->request->post());
                header('Location' . ROOT);
            }catch(\Exception $e){
                $errors = $e->getMessage();
            }
        }

        $this->menu = $this->build('v_menu');
        $this->content = $this->build('v_login', ['errors' => $errors]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $text->getTexts() ?? null;
        $this->title = 'Авторизация';
    }

    public function logoutAction()
    {
        $user = new Users();
        $user->logout();
        header('Location:' . ROOT );
    }
}
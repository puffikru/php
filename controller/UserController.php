<?php

namespace controller;

use core\Exceptions\ValidateException;
use core\Forms\FormBuilder;
use forms\SignUp;
use model\Sessions;
use model\Texts;
use model\Users;

class UserController extends FrontController
{
    public function signUpAction()
    {
        $text = new Texts();
        $errors = '';
        $mUser = new Users();
        $mSession = new Sessions();
        $form = new SignUp();
        $formBuilder = new FormBuilder($form);

        if($this->request->isPost()) {

            try {
                //$mUser->signUp($this->request->post(), $mSession, $this->request);
                $mUser->signUp($form->handleRequest($this->request), $mSession, $this->request);
                $this->redirect(ROOT);
            }catch(ValidateException $e) {
                //$errors = $e->getMessage();
                $form->addErrors($e->getErrors());
            }

        }

        $this->menu = $this->build('v_menu');
        $this->sidebar = $this->build('v_left');
        $this->texts = $text->getTexts() ?? null;
        $this->title = 'Регистрация';
        $this->content = $this->build('v_signup', ['form' => $formBuilder]);
    }

    public function loginAction()
    {
        $text = new Texts();
        $errors = '';
        $mUser = new Users();
        $mSession = new Sessions();
        $mSession->clearSessions();

        /*if(isset($_GET['auth'])) {
            if($_GET['auth'] === 'off') {
                //throw new \Exception('У вас нет прав для просмотра данной страницы!');
                //$this->logoutAction();
            }
        }*/

        if($this->request->isPost()){

            try {
                $mUser->login($this->request->post(), $mSession, $this->request);
                $this->redirect(ROOT);
            }catch(ValidateException $e){
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
        $mUser = new Users();
        $session = new Sessions();
        $mUser->logout($session, $this->request);
        $this->redirect(ROOT);
    }
}
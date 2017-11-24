<?php

namespace controller;

use core\Exceptions\ValidateException;
use core\Forms\FormBuilder;
use forms\SignIn;
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
        $mUser = new Users();
        $mSession = new Sessions();
        $mSession->clearSessions();
        $form = new SignIn();
        $formBuilder = new FormBuilder($form);


        if($this->request->isPost()){

            try {
                $mUser->login($form->handleRequest($this->request), $mSession, $this->request);
                $this->redirect(ROOT);
            }catch(ValidateException $e){
                $form->addErrors($e->getErrors());
            }
        }

        $this->menu = $this->build('v_menu');
        $this->content = $this->build('v_login', ['form' => $formBuilder]);
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
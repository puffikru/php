<?php

namespace controller;

use core\Exceptions\ValidateException;
use core\Forms\FormBuilder;
use forms\SignIn;
use forms\SignUp;

class UserController extends FrontController
{
    public function signUpAction()
    {
        $text = $this->container->get('model.texts');
        $user = $this->container->get('service.user', $this->request);
        $form = new SignUp();
        $formBuilder = new FormBuilder($form);

        if($this->request->isPost()) {
            try {
                $user->signUp($form->handleRequest($this->request));
                $this->redirect(ROOT);
            }catch(ValidateException $e) {
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
        $text = $this->container->get('model.texts');
        $this->container->get('model.session')->clearSessions();
        $user = $this->container->get('service.user', $this->request);
        $form = new SignIn();
        $formBuilder = new FormBuilder($form);

        if($this->request->isPost()){
            try {
                $user->login($form->handleRequest($this->request));
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
        $this->container->get('service.user', $this->request)->logOut();
        $this->redirect(ROOT);
    }
}
<?php

namespace controller;

use core\Validation;
use model\Auth;
use model\Texts;
use model\Users;

class TextsController extends FrontController
{
    public function indexAction()
    {
        $isAuth = Users::isAuth();

        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . 'texts';
            header('Location: ' . ROOT . 'user/login?auth=off');
            exit();
        }

        if(isset($_GET['auth'])) {
            if($_GET['auth'] == 'off') {
                Auth::logOff();
                header('Location: ' . ROOT . "texts");
                exit();
            }
        }
        $staticTexts = new Texts();
        $texts = $staticTexts->all();

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth]);
        $this->sidebar = $this->build('v_left');
        $this->content = $this->build('v_texts', ['texts' => $texts]);
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->title = 'Тексты';
    }

    public function addAction()
    {
        $isAuth = Users::isAuth();

        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . 'add-text';
            header('Location: ' . ROOT . 'user/login?auth=off');
            exit();
        }

        $staticTexts = new Texts();
        $alias = '';
        $content = '';

        if($this->request->isPost()) {

            extract($this->request->post());

            try {
                $staticTexts->add(['alias' => $alias, 'content' => $content]);
                header("Location: " . ROOT . "texts");
                exit();
            }catch(\Exception $e){
                $errors = $e->getMessage();
            }


        }else {
            $alias = '';
            $content = '';
            $errors = '';
        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth]);
        $this->sidebar = $this->build('v_left');
        $this->content = $this->build('v_add-text', ['alias' => $alias, 'content' => $content, 'errors' => $errors]);
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->title = 'Новый текст';
    }

    public function editAction()
    {
        $isAuth = Users::isAuth();

        $id = $this->request->get('id');
        $err404 = false;

        // Проверка авторизации
        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . "edit-text/$id";
            header('Location: ' . ROOT . 'user/login?auth=off');
            exit();
        }

        if(!isset($id) || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            $err404 = true;
        }

        $staticTexts = new Texts();
        $text = $staticTexts->one($id);
        $errors = '';
        $alias = '';
        $content = '';

        if(!$text) {
            $errors = $text;
        }

        if($this->request->isPost()) {

            extract($this->request->post());

            try {
                $staticTexts->edit($id, ['alias' => $alias, 'content' => $content]);
                header('Location: ' . ROOT . "texts");
                exit();
            }catch(\Exception $e){
                $errors = $e->getMessage();
            }

        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth]);
        $this->content = $this->build('v_edit-text', ['err404' => $err404, 'text' => $text, 'errors' => $errors]);
        $this->title = 'Редактирование текста';
    }

    public function deleteAction()
    {
        $isAuth = Users::isAuth();
        unset($_SESSION['returnUrl']);

        if(!$isAuth) {
            header('Location: ' . ROOT . 'user/login?auth=off');
            exit();
        }
        $staticTexts = new Texts();

        $id = $this->request->get('id');

        if(!isset($id) || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            echo "Такого текста не существует!";
        }else {
            $staticTexts->delete($id);
            header('Location:' . ROOT . "texts");
            exit();
        }
    }
}
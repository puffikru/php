<?php

namespace controller;

use model\Sessions;
use model\Texts;
use model\Users;

class TextsController extends FrontController
{
    public function indexAction()
    {
        $user = new Users();
        $session = new Sessions();
        $isAuth = $user->isAuth($session, $this->request);

        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . 'texts';
            $this->redirect(ROOT . 'user/login?auth=off');
            exit();
        }

        if(isset($_GET['auth'])) {
            if($_GET['auth'] == 'off') {
                $user->logout($session, $this->request);
                $this->redirect(ROOT . "texts");
                exit();
            }
        }
        $staticTexts = new Texts();
        $texts = $staticTexts->all();
        $cUser = $user->getBySid($this->request->session('sid'));

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $cUser['name']]);
        $this->sidebar = $this->build('v_left');
        $this->content = $this->build('v_texts', ['texts' => $texts]);
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->title = 'Тексты';
    }

    public function addAction()
    {
        $user = new Users();
        $session = new Sessions();
        $isAuth = $user->isAuth($session, $this->request);

        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . 'add-text';
            $this->redirect(ROOT . 'user/login?auth=off');
            exit();
        }

        $staticTexts = new Texts();
        $alias = '';
        $content = '';
        $cUser = $user->getBySid($this->request->session('sid'));

        if($this->request->isPost()) {

            extract($this->request->post());

            try {
                $staticTexts->add(['alias' => $alias, 'content' => $content]);
                $this->redirect(ROOT . "texts");
                exit();
            }catch(\Exception $e){
                $errors = $e->getMessage();
            }


        }else {
            $alias = '';
            $content = '';
            $errors = '';
        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $cUser['name']]);
        $this->sidebar = $this->build('v_left');
        $this->content = $this->build('v_add-text', ['alias' => $alias, 'content' => $content, 'errors' => $errors]);
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->title = 'Новый текст';
    }

    public function editAction()
    {
        $user = new Users();
        $session = new Sessions();
        $isAuth = $user->isAuth($session, $this->request);

        $id = $this->request->get('id');
        $err404 = false;

        // Проверка авторизации
        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . "edit-text/$id";
            $this->redirect(ROOT . 'user/login?auth=off');
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
        $cUser = $user->getBySid($this->request->session('sid'));

        if(!$text) {
            $errors = $text;
        }

        if($this->request->isPost()) {

            extract($this->request->post());

            try {
                $staticTexts->edit($id, ['alias' => $alias, 'content' => $content]);
                $this->redirect(ROOT . "texts");
                exit();
            }catch(\Exception $e){
                $errors = $e->getMessage();
            }

        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $cUser['name']]);
        $this->content = $this->build('v_edit-text', ['err404' => $err404, 'text' => $text, 'errors' => $errors]);
        $this->title = 'Редактирование текста';
    }

    public function deleteAction()
    {
        $user = new Users();
        $session = new Sessions();
        $isAuth = $user->isAuth($session, $this->request);
        unset($_SESSION['returnUrl']);

        if(!$isAuth) {
            $this->redirect(ROOT . 'user/login?auth=off');
            exit();
        }
        $staticTexts = new Texts();

        $id = $this->request->get('id');

        if(!isset($id) || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            echo "Такого текста не существует!";
        }else {
            $staticTexts->delete($id);
            $this->redirect(ROOT . "texts");
            exit();
        }
    }
}
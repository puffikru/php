<?php

namespace controller;

use core\Exceptions\Error404;
use model\Auth;
use model\Messages;
use model\Texts;
use model\Users;

class PostController extends FrontController
{
    public function indexAction()
    {
        $isAuth = Users::isAuth();
        $text = new Texts();
        unset($_SESSION['returnUrl']);

        if(isset($_GET['auth'])) {
            if($_GET['auth'] == 'off') {
                Auth::logOff();
                header('Location: ' . ROOT);
                exit();
            }
        }

        $messages = new Messages();
        $articles = $messages->getAll();


        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $text->getTexts() ?? null;
        $this->title = 'Главная';
        $this->content = $this->build('v_index', ['articles' => $articles, 'isAuth' => $isAuth]);
    }

    public function oneAction()
    {
        $isAuth = Users::isAuth();

        $id = $this->request->get('id');

        $text = new Texts();

        if($id === null || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            throw new Error404("Статьи номер $id не существует!");
        }else {
            $messages = new Messages();
            $content = $messages->one($id);

            if(!$content) {
                throw new Error404("Такой статьи не существует!");
            }
        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $text->getTexts() ?? null;
        $this->content = $this->build('v_post', ['content' => $content, 'isAuth' => $isAuth]);
        $this->title = 'Просмотр сообщения';

    }

    public function addAction()
    {
        $isAuth = Users::isAuth();
        $text = new Texts();
        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . 'add';
            header('Location: ' . ROOT . 'user/login?auth=off');
            exit();
        }

        $messages = new Messages();
        $users = new Users();
        $user = $users->getByLogin($this->request->session('login'));
        $title = '';

        if($this->request->isPost()) {

            extract($this->request->post());

            try {
                $id = $messages->add(['title' => $title, 'content' => $content ?? '', 'id_user' => $user['id_user']]);
                header("Location: " . ROOT . "post/$id");
                exit();
            }catch(\Exception $e){
                $error = $e->getMessage();
            }

        }else {
            $this->title = '';
            $content = '';
            $error = '';
        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $text->getTexts() ?? null;
        $this->title = 'Новое сообщение';
        $this->content = $this->build('v_add', ['title' => $title, 'content' => $content, 'error' => $error]);
    }

    public function editAction()
    {
        $isAuth = Users::isAuth();

        $id = $this->request->get('id');
        $staticTexts = new Texts();

        // Проверка авторизации
        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . "edit/$id";
            header('Location: ' . ROOT . 'user/login?auth=off');
            exit();
        }

        if(!isset($id) || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            throw new Error404("Статьи номер $id не существует!");
        }

        $messages = new Messages();
        $text = $messages->one($id);
        $error = '';
        $title = '';
        $content = '';

        if(!$text) {
            throw new Error404("Такой статьи не существует!");
        }

        if($this->request->isPost()) {


            extract($this->request->post());

            try {
                $messages->edit($id, ['title' => $title, 'content' => $content]);
                header('Location: ' . ROOT);
            }catch(\Exception $e){
                $error = $e->getMessage();
            }

        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth]);
        $this->title = 'Редактирование сообщения';
        $this->sidebar = $this->build('v_left');
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->content = $this->build('v_edit', ['title' => $this->title, 'text' => $text, 'error' => $error]);
    }

    public function deleteAction()
    {
        $isAuth = Users::isAuth();
        unset($_SESSION['returnUrl']);

        if(!$isAuth) {
            header('Location: ' . ROOT . 'user/login?auth=off');
            exit();
        }
        $messages = new Messages();
        $id = $this->request->get('id');

        if(!isset($id) || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            echo "Такой статьи не существует!";
        }else {
            $messages->delete($id);
            header('Location:' . ROOT);
            exit();
        }
    }

    public function error404($err = '')
    {
        $staticTexts = new Texts();

        $this->title = 'Ошибка 404';
        $this->sidebar = $this->build('v_left');
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->content = $this->build('v_err404', ['title' => $this->title, 'error' => $err]);
    }

    public function error503($err = '')
    {
        $staticTexts = new Texts();

        $this->title = 'Временная ошибка сервера!';
        $this->sidebar = $this->build('v_left');
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->content = $this->build('v_err503', ['title' => $this->title, 'error' => $err]);
    }
}
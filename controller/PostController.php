<?php

namespace controller;

use core\Exceptions\Error404;
use core\Exceptions\ValidateException;
use core\Forms\FormBuilder;
use forms\AddPost;
use model\Messages;
use model\Sessions;
use model\Texts;
use model\Users;

class PostController extends FrontController
{
    public function indexAction()
    {
        $text = $this->container->get('model.texts');
        unset($_SESSION['returnUrl']);
        $user = $this->container->get('model.user');

        $session = $this->container->get('model.session');
        $isAuth = $user->isAuth($session, $this->request);

        $messages = $this->container->get('model.post');

        $articles = $messages->getAll();
        $cUser = $user->getBySid($this->request->session('sid'));

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $cUser['name']]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $text->getTexts() ?? null;
        $this->title = 'Главная';
        $this->content = $this->build('v_index', ['articles' => $articles, 'isAuth' => $isAuth]);
    }

    public function oneAction()
    {
        $user = $this->container->get('model.user');
        $session = $this->container->get('model.session');
        $isAuth = $user->isAuth($session, $this->request);

        $id = $this->request->get('id');

        $text = $this->container->get('model.texts');
        $cUser = $user->getBySid($this->request->session('sid'));


        if($id === null || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            throw new Error404("Статьи номер $id не существует!");
        }else {
            $messages = $this->container->get('model.post');
            $content = $messages->one($id);

            if(!$content) {
                throw new Error404("Такой статьи не существует!");
            }
        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $cUser['name']]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $text->getTexts() ?? null;
        $this->content = $this->build('v_post', ['content' => $content, 'isAuth' => $isAuth]);
        $this->title = 'Просмотр сообщения';

    }

    public function addAction()
    {
        $users = new Users();
        $session = new Sessions();
        $isAuth = $users->isAuth($session, $this->request);
        $text = new Texts();
        $error = '';
        $form = new AddPost();
        $formBuilder = new FormBuilder($form);

        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . 'add';
            $this->redirect(ROOT . 'user/login?auth=off');
            exit();
        }

        $messages = new Messages();
        $user = $users->getBySid($this->request->session('sid'));
        $title = '';

        if($this->request->isPost()) {

            foreach($form->handleRequest($this->request) as $fields => $item){
                $obj[$fields] = $item;
            }
            $obj['id_user'] = $user['id_user'];

            try {
                $id = $messages->add($obj);
                $this->redirect(ROOT . "post/$id");
            }catch(ValidateException $e){
                $form->addErrors($e->getErrors());
            }

        }else {
            $this->title = '';
            $content = '';
        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $user['name']]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $text->getTexts() ?? null;
        $this->title = 'Новое сообщение';
        $this->content = $this->build('v_add', ['form' => $formBuilder]);
    }

    public function editAction()
    {
        $user = new Users();
        $session = new Sessions();
        $isAuth = $user->isAuth($session, $this->request);

        $id = $this->request->get('id');
        $staticTexts = new Texts();
        $cUser = $user->getBySid($this->request->session('sid'));

        // Проверка авторизации
        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . "edit/$id";
            $this->redirect(ROOT . 'user/login?auth=off');
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
                $this->redirect(ROOT);
            }catch(ValidateException $e){
                $error = $e->getErrors();
            }

        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $cUser['name']]);
        $this->title = 'Редактирование сообщения';
        $this->sidebar = $this->build('v_left');
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->content = $this->build('v_edit', ['title' => $this->title, 'text' => $text, 'error' => $error]);
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
        $messages = new Messages();
        $id = $this->request->get('id');

        if(!isset($id) || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            echo "Такой статьи не существует!";
        }else {
            $messages->delete($id);
            $this->redirect(ROOT);
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
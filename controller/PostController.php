<?php

namespace controller;

use core\Exceptions\Error404;
use core\Exceptions\ValidateException;
use core\Forms\FormBuilder;
use forms\AddPost;
use forms\EditPost;

class PostController extends FrontController
{
    public function indexAction()
    {
        $text = $this->container->get('model.texts');
        unset($_SESSION['returnUrl']);
        $mUser = $this->container->get('model.user');

        $isAuth = $this->container->get('service.user', $this->request)->isAuth();

        $messages = $this->container->get('model.post');

        $articles = $messages->getAll();
        $cUser = $mUser->getBySid($this->request->session('sid'));

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $cUser['name']]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $text->getTexts() ?? null;
        $this->title = 'Главная';
        $this->content = $this->build('v_index', ['articles' => $articles, 'isAuth' => $isAuth]);
    }

    public function oneAction()
    {
        $user = $this->container->get('model.user');

        $isAuth = $this->container->get('service.user', $this->request)->isAuth();

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
        $users = $this->container->get('model.user');
        $isAuth = $this->container->get('service.user', $this->request)->isAuth();
        $text = $this->container->get('model.texts');
        $form = new AddPost();
        $formBuilder = new FormBuilder($form);

        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . 'add';
            $this->redirect(ROOT . 'user/login?auth=off');
            exit();
        }

        $messages = $this->container->get('model.post');
        $user = $users->getBySid($this->request->session('sid'));

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
        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $user['name']]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $text->getTexts() ?? null;
        $this->title = 'Новое сообщение';
        $this->content = $this->build('v_add', ['form' => $formBuilder]);
    }

    public function editAction()
    {
        $user = $this->container->get('model.user');
        $isAuth = $this->container->get('service.user', $this->request)->isAuth();

        $id = $this->request->get('id');
        $staticTexts = $this->container->get('model.texts');
        $cUser = $user->getBySid($this->request->session('sid'));
        $form = new EditPost();
        $formBuilding = new FormBuilder($form);

        // Проверка авторизации
        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . "edit/$id";
            $this->redirect(ROOT . 'user/login?auth=off');
            exit();
        }

        if(!isset($id) || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            throw new Error404("Статьи номер $id не существует!");
        }

        $messages = $this->container->get('model.post');
        $text = $messages->one($id);

        if(!$text) {
            throw new Error404("Такой статьи не существует!");
        }

        $form->saveValues($text);

        if($this->request->isPost()) {

            $form->saveValues($this->request->post());

            try {
                $messages->edit($id, $form->handleRequest($this->request));
                $this->redirect(ROOT);
            }catch(ValidateException $e){
                $form->addErrors($e->getErrors());
            }

        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $cUser['name']]);
        $this->title = 'Редактирование сообщения';
        $this->sidebar = $this->build('v_left');
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->content = $this->build('v_edit', ['form' => $formBuilding]);
    }

    public function deleteAction()
    {
        $isAuth = $this->container->get('service.user', $this->request)->isAuth();
        unset($_SESSION['returnUrl']);

        if(!$isAuth) {
            $this->redirect(ROOT . 'user/login?auth=off');
            exit();
        }
        $messages = $this->container->get('model.post');
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
        $staticTexts = $this->container->get('model.texts');

        $this->title = 'Ошибка 404';
        $this->sidebar = $this->build('v_left');
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->content = $this->build('v_err404', ['title' => $this->title, 'error' => $err]);
    }

    public function error503($err = '')
    {
        $staticTexts = $this->container->get('model.texts');

        $this->title = 'Временная ошибка сервера!';
        $this->sidebar = $this->build('v_left');
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->content = $this->build('v_err503', ['title' => $this->title, 'error' => $err]);
    }
}
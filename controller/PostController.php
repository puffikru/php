<?php

namespace controller;

use core\Exceptions\Error404;
use core\Exceptions\ValidateException;
use core\Forms\FormBuilder;
use forms\AddPost;
use forms\EditPost;

class PostController extends BaseController
{
    public function indexAction()
    {
        unset($_SESSION['returnUrl']);
        $mUser = $this->container->get('models', 'Users');

        $isAuth = $this->container->get('service.user', $this->request)->isAuth();

        $articles = $this->container->get('models', 'Messages')->getAll();
        $cUser = $mUser->getBySid($this->request->session('sid'));

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $cUser['name']]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->title = 'Главная';
        $this->content = $this->build('v_index', ['articles' => $articles, 'isAuth' => $isAuth]);
    }

    public function oneAction()
    {
        $isAuth = $this->container->get('service.user', $this->request)->isAuth();

        $id = $this->request->get('id');

        $cUser = $this->container->get('models', 'Users')->getBySid($this->request->session('sid'));

        if($id === null || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            throw new Error404("Статьи номер $id не существует!");
        }else {
            $content = $this->container->get('models', 'Messages')->one($id);

            if(!$content) {
                throw new Error404("Такой статьи не существует!");
            }
        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $cUser['name']]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->content = $this->build('v_post', ['content' => $content, 'isAuth' => $isAuth]);
        $this->title = 'Просмотр сообщения';

    }

    public function addAction()
    {
        $isAuth = $this->container->get('service.user', $this->request)->isAuth();
        $form = new AddPost();
        $formBuilder = new FormBuilder($form);

        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . 'add';
            $this->redirect(ROOT . 'user/login?auth=off');
            exit();
        }

        $user = $this->container->get('models', 'Users')->getBySid($this->request->session('sid'));

        if($this->request->isPost()) {

            foreach($form->handleRequest($this->request) as $fields => $item){
                $obj[$fields] = $item;
            }
            $obj['id_user'] = $user['id_user'];

            try {
                $id = $this->container->get('models', 'Messages')->add($obj);
                $this->redirect(ROOT . "post/$id");
            }catch(ValidateException $e){
                $form->addErrors($e->getErrors());
            }

        }else {
            $this->title = '';
        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $user['name']]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->title = 'Новое сообщение';
        $this->content = $this->build('v_add', ['form' => $formBuilder]);
    }

    public function editAction()
    {
        $isAuth = $this->container->get('service.user', $this->request)->isAuth();

        $id = $this->request->get('id');
        $cUser = $this->container->get('models', 'Users')->getBySid($this->request->session('sid'));
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

        $messages = $this->container->get('models', 'Messages');
        $text = $messages->one($id);

        if(!$text) {
            throw new Error404("Такой статьи не существует!");
        }

        $form->saveValues($text);

        if($this->request->isPost()) {
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
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
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
        $id = $this->request->get('id');

        if(!isset($id) || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            echo "Такой статьи не существует!";
        }else {
            $this->container->get('models', 'Messages')->delete($id);
            $this->redirect(ROOT);
            exit();
        }
    }

    public function error404($err = '')
    {
        $this->title = 'Ошибка 404';
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->content = $this->build('v_err404', ['title' => $this->title, 'error' => $err]);
    }

    public function error503($err = '')
    {
        $this->title = 'Временная ошибка сервера!';
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->content = $this->build('v_err503', ['title' => $this->title, 'error' => $err]);
    }
}
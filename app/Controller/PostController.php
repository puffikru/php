<?php

namespace NTSchool\Phpblog\Controller;

use NTSchool\Phpblog\Core\Exceptions\Error404;
use NTSchool\Phpblog\Core\Exceptions\ValidateException;
use NTSchool\Phpblog\Core\Forms\FormBuilder;
use NTSchool\Phpblog\Forms\AddPost;
use NTSchool\Phpblog\Forms\EditPost;

class PostController extends BaseController
{
    /**
     *
     */
    public function indexAction()
    {
        unset($_SESSION['returnUrl']);
        $user = $this->container->get('service.user', $this->request);
        $user->isAuth();
        $access = $user->checkAccess();

        $articles = $this->container->get('models', 'Messages')->getAll();

        $this->menu = $this->build('v_menu', ['access' => $access]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->title = 'Главная';
        $this->content = $this->build('v_index', ['articles' => $articles, 'access' => $access]);
    }

    /**
     * @throws \NTSchool\Phpblog\Core\Exceptions\Error404
     */
    public function oneAction()
    {
        $user = $this->container->get('service.user', $this->request);
        $user->isAuth();
        $access = $user->checkAccess();

        $id = $this->request->get()->get('id');

        if($id === null || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            throw new Error404("Статьи номер $id не существует!");
        }else {
            $content = $this->container->get('models', 'Messages')->one($id);

            if(!$content) {
                throw new Error404("Такой статьи не существует!");
            }
        }

        $this->menu = $this->build('v_menu', ['access' => $access]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->content = $this->build('v_post', ['content' => $content]);
        $this->title = 'Просмотр сообщения';

    }

    /**
     *
     */
    public function addAction()
    {
        $cUser = $this->container->get('service.user', $this->request);
        $cUser->isAuth();
        $access = $cUser->checkAccess();
        $form = new AddPost();
        $formBuilder = new FormBuilder($form);

        if(!$access) {
            $_SESSION['returnUrl'] = ROOT . 'add';
            $this->response->redirect(ROOT . 'user/login?auth=off');
            exit();
        }

        $user = $this->container->get('models', 'Users')->getBySid($this->container->get('http.session')->collection()->get('sid'));

        if($this->request->isPost()) {

            foreach($form->handleRequest($this->request) as $fields => $item){
                $obj[$fields] = $item;
            }
            $obj['id_user'] = $user['id_user'];

            try {
                $id = $this->container->get('models', 'Messages')->add($obj);
                $this->response->redirect(ROOT . "post/$id");
            }catch(ValidateException $e){
                $form->addErrors($e->getErrors());
            }

        }else {
            $this->title = '';
        }

        $this->menu = $this->build('v_menu', ['access' => $access]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->title = 'Новое сообщение';
        $this->content = $this->build('v_add', ['form' => $formBuilder]);
    }

    /**
     * @throws \NTSchool\Phpblog\Core\Exceptions\Error404
     */
    public function editAction()
    {
        $user = $this->container->get('service.user', $this->request);
        $user->isAuth();
        $access = $user->checkAccess();

        $id = $this->request->get()->get('id');

        $form = new EditPost();
        $formBuilding = new FormBuilder($form);

        // Проверка авторизации
        if(!$access) {
            $_SESSION['returnUrl'] = ROOT . "edit/$id";
            $this->response->redirect(ROOT . 'user/login?auth=off');
        }

        if(!isset($id) || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            throw new Error404("Статьи номер $id не существует!");
        }

        $messages = $this->container->get('models', 'Messages');
        $text = $messages->one($id);

        if($access['id_priv'] < 2 && $access['id_user'] !== $text['id_user']){
            $this->response->redirect(ROOT);
        }

        if(!$text) {
            throw new Error404("Такой статьи не существует!");
        }

        $form->saveValues($text);

        if($this->request->isPost()) {
            try {
                $messages->edit($id, $form->handleRequest($this->request));
                $this->response->redirect(ROOT);
            }catch(ValidateException $e){
                $form->addErrors($e->getErrors());
            }

        }

        $this->menu = $this->build('v_menu', ['access' => $access]);
        $this->title = 'Редактирование сообщения';
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->content = $this->build('v_edit', ['form' => $formBuilding]);
    }

    /**
     *
     */
    public function deleteAction()
    {
        $isAuth = $this->container->get('service.user', $this->request)->isAuth();
        unset($_SESSION['returnUrl']);

        if(!$isAuth) {
            $this->response->redirect(ROOT . 'user/login?auth=off');
            exit();
        }
        $id = $this->request->get()->get('id');

        if(!isset($id) || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            echo "Такой статьи не существует!";
        }else {
            $this->container->get('models', 'Messages')->delete($id);
            $this->response->redirect(ROOT);
        }
    }

    /**
     * @param string $err
     */
    public function error404($err = '')
    {
        $this->title = 'Ошибка 404';
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->content = $this->build('v_err404', ['title' => $this->title, 'error' => $err]);
    }

    /**
     * @param string $err
     */
    public function error503($err = '')
    {
        $this->title = 'Временная ошибка сервера!';
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->content = $this->build('v_err503', ['title' => $this->title, 'error' => $err]);
    }
}
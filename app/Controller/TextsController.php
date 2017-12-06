<?php

namespace NTSchool\Phpblog\Controller;

use NTSchool\Phpblog\Core\Exceptions\ValidateException;
use NTSchool\Phpblog\Core\Forms\FormBuilder;
use NTSchool\Phpblog\Forms\AddText;
use NTSchool\Phpblog\Forms\EditText;

class TextsController extends BaseController
{
    public function indexAction()
    {
        $user = $this->container->get('service.user', $this->request);
        $user->isAuth();
        $access = $user->checkAccess();

        if(!$access) {
            $_SESSION['returnUrl'] = ROOT . 'texts';
            $this->response->redirect(ROOT . 'user/login?auth=off');
            exit();
        }

        if(isset($_GET['auth'])) {
            if($_GET['auth'] == 'off') {
                $user->logout();
                $this->response->redirect(ROOT . "texts");
                exit();
            }
        }
        $staticTexts = $this->container->get('models', 'Texts');
        $texts = $staticTexts->all();

        $this->menu = $this->build('v_menu', ['access' => $access]);
        $this->sidebar = $this->build('v_left');
        $this->content = $this->build('v_texts', ['texts' => $texts]);
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->title = 'Тексты';
    }

    public function addAction()
    {
        $user = $this->container->get('service.user', $this->request);
        $user->isAuth();
        $access = $user->checkAccess();
        $form = new AddText();
        $formBuilder = new FormBuilder($form);

        if(!$access) {
            $_SESSION['returnUrl'] = ROOT . 'add-text';
            $this->response->redirect(ROOT . 'user/login?auth=off');
            exit();
        }

        $staticTexts = $this->container->get('models', 'Texts');

        if($this->request->isPost()) {
            try {
                $staticTexts->add($form->handleRequest($this->request));
                $this->response->redirect(ROOT . "texts");
            }catch(ValidateException $e){
                $form->addErrors($e->getErrors());
            }

        }

        $this->menu = $this->build('v_menu', ['access' => $access]);
        $this->sidebar = $this->build('v_left');
        $this->content = $this->build('v_add-text', ['form' => $formBuilder]);
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->title = 'Новый текст';
    }

    public function editAction()
    {
        $user = $this->container->get('service.user', $this->request);
        $user->isAuth();
        $access = $user->checkAccess();
        $form = new EditText();
        $formBuilder = new FormBuilder($form);

        $id = $this->request->get()->get('id');

        // Проверка авторизации
        if(!$access) {
            $_SESSION['returnUrl'] = ROOT . "edit-text/$id";
            $this->response->redirect(ROOT . 'user/login?auth=off');
            exit();
        }

        if(!isset($id) || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            // throw new Ex
        }

        $staticTexts = $this->container->get('models', 'Texts');
        $text = $staticTexts->one($id);

        if(!$text) {
            $errors = $text;
        }

        $form->saveValues($text);

        if($this->request->isPost()) {
            try {
                $staticTexts->edit($id, $form->handleRequest($this->request));
                $this->response->redirect(ROOT . "texts");
            }catch(ValidateException $e){
                $form->addErrors($e->getErrors());
            }

        }

        $this->menu = $this->build('v_menu', ['access' => $access]);
        $this->content = $this->build('v_edit-text', ['form' => $formBuilder]);
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->title = 'Редактирование текста';
    }

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
            echo "Такого текста не существует!";
        }else {
            $this->container->get('models', 'Texts')->delete($id);
            $this->response->redirect(ROOT . "texts");
        }
    }
}
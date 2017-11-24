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
        $mUser = $this->container->get('models', 'Users');
        $user = $this->container->get('service.user', $this->request);
        $isAuth = $user->isAuth();

        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . 'texts';
            $this->redirect(ROOT . 'user/login?auth=off');
            exit();
        }

        if(isset($_GET['auth'])) {
            if($_GET['auth'] == 'off') {
                $user->logout();
                $this->redirect(ROOT . "texts");
                exit();
            }
        }
        $staticTexts = $this->container->get('models', 'Texts');
        $texts = $staticTexts->all();
        $cUser = $mUser->getBySid($this->request->session('sid'));

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $cUser['name']]);
        $this->sidebar = $this->build('v_left');
        $this->content = $this->build('v_texts', ['texts' => $texts]);
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->title = 'Тексты';
    }

    public function addAction()
    {
        $mUser = $this->container->get('models', 'Users');
        $isAuth = $this->container->get('service.user', $this->request)->isAuth();
        $form = new AddText();
        $formBuilder = new FormBuilder($form);

        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . 'add-text';
            $this->redirect(ROOT . 'user/login?auth=off');
            exit();
        }

        $staticTexts = $this->container->get('models', 'Texts');
        $cUser = $mUser->getBySid($this->request->session('sid'));

        if($this->request->isPost()) {
            try {
                $staticTexts->add($form->handleRequest($this->request));
                $this->redirect(ROOT . "texts");
                exit();
            }catch(ValidateException $e){
                $form->addErrors($e->getErrors());
            }

        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $cUser['name']]);
        $this->sidebar = $this->build('v_left');
        $this->content = $this->build('v_add-text', ['form' => $formBuilder]);
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->title = 'Новый текст';
    }

    public function editAction()
    {
        $mUser = $this->container->get('models', 'Users');
        $isAuth = $this->container->get('service.user', $this->request)->isAuth();
        $form = new EditText();
        $formBuilder = new FormBuilder($form);

        $id = $this->request->get('id');

        // Проверка авторизации
        if(!$isAuth) {
            $_SESSION['returnUrl'] = ROOT . "edit-text/$id";
            $this->redirect(ROOT . 'user/login?auth=off');
            exit();
        }

        if(!isset($id) || $id == '' || !preg_match('/^[0-9]+$/', $id)) {
            $err404 = true;
        }

        $staticTexts = $this->container->get('models', 'Texts');
        $text = $staticTexts->one($id);

        $cUser = $mUser->getBySid($this->request->session('sid'));

        if(!$text) {
            $errors = $text;
        }

        $form->saveValues($text);

        if($this->request->isPost()) {
            try {
                $staticTexts->edit($id, $form->handleRequest($this->request));
                $this->redirect(ROOT . "texts");
                exit();
            }catch(ValidateException $e){
                $form->addErrors($e->getErrors());
            }

        }

        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth, 'user' => $cUser['name']]);
        $this->content = $this->build('v_edit-text', ['form' => $formBuilder]);
        $this->texts = $staticTexts->getTexts() ?? null;
        $this->title = 'Редактирование текста';
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
            echo "Такого текста не существует!";
        }else {
            $this->container->get('models', 'Texts')->delete($id);
            $this->redirect(ROOT . "texts");
            exit();
        }
    }
}
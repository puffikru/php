<?php

namespace controller;


use model\Auth;
use model\Texts;

class LoginController extends FrontController
{
    public function indexAction()
    {
        $isAuth = Auth::isAuth();
        $msg = '';
        $text = new Texts();

        if(isset($_GET['auth'])) {
            if($_GET['auth'] == 'off' && isset($_SESSION['is_auth'])) {
                unset($_SESSION['is_auth']);
            }
        }

        if(isset($_COOKIE['login'])) {
            setcookie('login', '', 1, '/');
        }

        if(isset($_COOKIE['password'])) {
            setcookie('password', '', 1, '/');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $login = trim(strip_tags($_POST['login']));
            $password = trim(strip_tags($_POST['password']));

            if($login == 'admin' && $password == 'qwerty') {
                $_SESSION['login'] = $login;
                $_SESSION['password'] = $password;
                $_SESSION['is_auth'] = true;


                if(isset($_POST['remember'])) {
                    setcookie('login', Auth::myHash($login), time() + 3600 * 24 * 7, '/');
                    setcookie('password', Auth::myHash($password), time() + 3600 * 24 * 7, '/');
                }

                if(isset($_SESSION['returnUrl'])) {
                    header('Location:' . $_SESSION['returnUrl']);
                    unset($_SESSION['returnUrl']);
                    exit();

                }else {

                    header('Location: ' . ROOT);
                    exit();

                }

            }else {

                $msg = 'Введенные данные не верны! Пожалуйста, повторите попытку.';

            }

        }else {

            if(isset($_GET['auth'])) {
                if($_GET['auth'] === 'off') {
                    $msg = 'У вас нет прав для просмотра данной страницы!';
                }
            }

        }


        $this->menu = $this->build('v_menu', ['isAuth' => $isAuth]);
        $this->content = $this->build('v_login', ['msg' => $msg]);
        $this->sidebar = $this->build('v_left');
        $this->texts = $text->getTexts() ?? null;
        $this->title = 'Авторизация';
    }
}
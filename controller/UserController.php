<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 27.10.2017
 * Time: 21:46
 */

namespace controller;


use model\Texts;

class UserController extends FrontController
{
    public function signUpAction()
    {
        $text = new Texts();
        $msg = '';

        $this->menu = $this->build('v_menu');
        $this->sidebar = $this->build('v_left');
        $this->texts = $text->getTexts() ?? null;
        $this->title = 'Регистрация';
        $this->content = $this->build('v_signup', ['msg' => $msg]);
    }
}
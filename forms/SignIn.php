<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 15.11.2017
 * Time: 3:38
 */

namespace forms;


use core\Forms\Form;

class SignIn extends Form
{
    public function __construct()
    {
        $this->fields = [
            [
                'name' => 'login',
                'type' => 'text',
                'placeholder' => 'Введите логин',
                'label' => 'Логин',
                'tag' => 'input'
            ],
            [
                'name' => 'pass',
                'type' => 'password',
                'placeholder' => 'Введите пароль',
                'label' => 'Пароль',
                'tag' => 'input'
            ],
            [
                'name' => 'remember',
                'type' => 'checkbox',
                'label' => 'Запомнить',
                'tag' => 'input'
            ],
            [
                'type' => 'submit',
                'value' => 'Войти',
                'tag' => 'input'
            ]
        ];

        $this->form_name = 'sign-in';
        $this->method  = 'POST';
    }
}
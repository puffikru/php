<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 14.11.2017
 * Time: 22:03
 */

namespace forms;


use core\Forms\Form;

class SignUp extends Form
{
    public function __construct()
    {
        $this->fields = [
            [
                'name' => 'name',
                'type' => 'text',
                'placeholder' => 'Введите Ваше имя',
                'class' => 'login-input',
                'label' => 'Имя',
                'tag' => 'input'
            ],
            [
                'name' => 'login',
                'type' => 'text',
                'placeholder' => 'Введите Ваш Email',
                'label' => 'Email',
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
                'name' => 'pass_confirm',
                'type' => 'password',
                'placeholder' => 'Повторите пароль',
                'label' => 'Пароль',
                'tag' => 'input'
            ],
            [
                'type' => 'submit',
                'value' => 'Зарегистрироваться',
                'tag' => 'input'
            ]
        ];

        $this->form_name = 'sign-up';
        $this->method  = 'POST';
    }
}
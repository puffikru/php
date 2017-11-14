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
                'label' => 'Имя'
            ],
            [
                'name' => 'login',
                'type' => 'text',
                'placeholder' => 'Введите Ваш Email',
                'label' => 'Email'
            ],
            [
                'name' => 'pass',
                'type' => 'password',
                'placeholder' => 'Введите пароль',
                'label' => 'Пароль'
            ],
            [
                'name' => 'pass_confirm',
                'type' => 'password',
                'placeholder' => 'Повторите пароль',
                'label' => 'Пароль'
            ],
            [
                'type' => 'submit',
                'value' => 'Зарегистрироваться'
            ]
        ];

        $this->form_name = 'sign-up';
        $this->method  = 'POST';
    }
}
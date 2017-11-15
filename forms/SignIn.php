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
                'label' => 'Логин'
            ],
            [
                'name' => 'pass',
                'type' => 'password',
                'placeholder' => 'Введите пароль',
                'label' => 'Пароль'
            ],
            [
                'name' => 'remember',
                'type' => 'checkbox',
                'label' => 'Запомнить'
            ],
            [
                'type' => 'submit',
                'value' => 'Войти'
            ]
        ];

        $this->form_name = 'sign-in';
        $this->method  = 'POST';
    }
}
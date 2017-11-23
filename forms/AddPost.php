<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 23.11.2017
 * Time: 6:20
 */

namespace forms;


use core\Forms\Form;

class AddPost extends Form
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
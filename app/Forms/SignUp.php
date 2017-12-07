<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 14.11.2017
 * Time: 22:03
 */

namespace NTSchool\Phpblog\Forms;


use NTSchool\Phpblog\Core\Forms\Form;

class SignUp extends Form
{
    /**
     * SignUp constructor.
     */
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
                'type' => 'email',
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
                'name' => 'answer',
                'type' => 'text',
                'placeholder' => 'Введите код с картинки',
                'label' => 'Введите код',
                'tag' => 'div',
                'size' => '6'
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
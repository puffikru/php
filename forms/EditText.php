<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 24.11.2017
 * Time: 3:32
 */

namespace forms;


use core\Forms\Form;

class EditText extends Form
{
    public function __construct()
    {
        $this->fields = [
            [
                'name' => 'alias',
                'type' => 'text',
                'placeholder' => 'Введите алиас',
                'label' => 'Название',
                'tag' => 'input'
            ],
            [
                'name' => 'content',
                'placeholder' => 'Введите текст',
                'label' => 'Контент',
                'tag' => 'textarea'
            ],
            [
                'type' => 'submit',
                'value' => 'Сохранить',
                'tag' => 'input'
            ]
        ];

        $this->form_name = 'edit-text';
        $this->method  = 'POST';
    }
}
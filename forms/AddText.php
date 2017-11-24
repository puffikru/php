<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 24.11.2017
 * Time: 3:32
 */

namespace forms;


use core\Forms\Form;

class AddText extends Form
{
    public function __construct()
    {
        $this->fields = [
            [
                'name' => 'title',
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
                'value' => 'Добавить',
                'tag' => 'input'
            ]
        ];

        $this->form_name = 'add-text';
        $this->method  = 'POST';
    }
}